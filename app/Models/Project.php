<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable=[
        'title',
        'description'
    ];

    public function tasks(){
        return $this->hasMany(Task::class, 'project_id');
    }

    public function users(){
        return $this->belongsToMany(User::class, 'user_project', 'project_id', 'user_id')
        ->withTimestamps();
    }

}
