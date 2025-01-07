# Genealogy Website

A genealogy website built with Laravel 8.x (or higher) for exploring and managing family relationships. The project allows users to create, view, and manage individuals and their family connections.

## Features

- Add and manage individuals, their parents, and children.
- Display family relationships dynamically.
- User authentication for secure access.
- Modern web application structure powered by Laravel.

## Technologies Used

- **PHP** (Laravel Framework)
- **MySQL** (Relational Database)
- **HTML/CSS/Blade** (Frontend with Laravel Blade Templates)

## Part 3 Database design
```txt
Table users {
  id bigint [pk, increment]
  username varchar(255) [unique, not null]
  email varchar(255) [unique, not null]
  password varchar(255) [not null]
  person_id bigint [ref: > people.id, null] // Linked to their person profile if applicable
  created_at datetime
  updated_at datetime
}

Table people {
  id bigint [pk, increment]
  created_by bigint [ref: > users.id, not null] // User who created the profile
  first_name varchar(255) [not null]
  last_name varchar(255) [not null]
  birth_date date
  owner_id bigint [ref: > users.id, null] // User who owns this profile
  created_at datetime
  updated_at datetime
}

Table relationships {
  id bigint [pk, increment]
  created_by bigint [ref: > users.id, not null]
  parent_id bigint [ref: > people.id, not null]
  child_id bigint [ref: > people.id, not null]
  created_at datetime
  updated_at datetime
}

Table modifications {
  id bigint [pk, increment]
  proposer_id bigint [ref: > users.id, not null] // User who proposed the change
  target_id bigint [ref: > people.id, not null] // Person being modified
  type varchar(255) [not null] // 'profile_update' or 'relationship_add'
  data json [not null] // Stores the proposed changes or new relationship
  status enum('pending', 'approved', 'rejected') [default: 'pending']
  created_at datetime
  updated_at datetime
}

Table modification_votes {
  id bigint [pk, increment]
  modification_id bigint [ref: > modifications.id, not null]
  voter_id bigint [ref: > users.id, not null]
  vote enum('accept', 'reject') [not null]
  created_at datetime
}

Table invitations {
  id bigint [pk, increment]
  inviter_id bigint [ref: > users.id, not null]
  invitee_email varchar(255) [not null]
  person_id bigint [ref: > people.id, null] // Profile being invited to
  status enum('pending', 'accepted', 'declined') [default: 'pending']
  created_at datetime
  updated_at datetime
}
```
### Database Evolution 
#### 1. Change Proposals:
    - Users propose updates or new relationships. 
    - Data is inserted into the `modifications` table with a `'pending'` status.

**Propose a profile update**: _A user proposes to update the name of a person_
```sql
INSERT INTO modifications (proposer_id, target_id, type, data, status, created_at) 
VALUES (1, 10, 'profile_update', '{"first_name": "Updated Name"}', 'pending', NOW());

```
**Propose a relationship**: _A user proposes adding a parent-child relationship_
```sql
INSERT INTO modifications (proposer_id, target_id, type, data, status, created_at)
VALUES (2, NULL, 'relationship_add', '{"parent_id": 10, "child_id": 15}', 'pending', NOW());

```

#### 2. Validation:
**Validation steps**:
    - Community members vote on proposals.
    - Votes are recorded in the `modification_votes` table.
    - If a proposal receives 3 accepts, it is approved, and changes are applied to the database (`people` or `relationships` table).
    - If a proposal receives 3 rejects, it is marked as 'rejected' and no changes are applied.

**User 3 votes accept**
```sql
INSERT INTO modification_votes (modification_id, voter_id, vote, created_at)
VALUES (1, 3, 'accept', NOW());
```

**User 4 votes to reject**
```sql
INSERT INTO modification_votes (modification_id, voter_id, vote, created_at)
VALUES (1, 4, 'reject', NOW());
```

**Validation result**: _Vote count:_
```sql
SELECT 
    SUM(vote = 'accept') AS accepts,
    SUM(vote = 'reject') AS rejects
FROM modification_votes
WHERE modification_id = 1;
```

**Approval**:
- If 3 or more accepts, the modification is approved: `UPDATE modifications SET status = 'approved' WHERE id = 1;`
- For profile_update, apply the change: `UPDATE people SET first_name = 'Updated Name' WHERE id = 10;`
- For relationship_add, insert into the relationships table: `INSERT INTO relationships (created_by, parent_id, child_id, created_at) VALUES (2, 10, 15, NOW());`
- Update: `UPDATE modifications SET status = 'rejected' WHERE id = 1;`
#### 3. Example Workflow:
    - A user proposes a name update.
    - The proposal is voted on by 5 members (3 accepts, 2 rejects).
    - The name update is approved and applied to the `people` table.
