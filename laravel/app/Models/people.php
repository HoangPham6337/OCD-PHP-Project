<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class people extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'birth_name',
        'middle_names',
        'date_of_birth',
        'created_by',
    ];

    public function children()
    {
        return $this->hasMany(Relationship::class, 'parent_id');
    }

    public function parents()
    {
        return $this->hasMany(Relationship::class, 'child_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class,'created_by');
    }


}
