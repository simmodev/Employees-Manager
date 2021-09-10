<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'name',
        'description'
    ];

    public function taskEmployees(){
        return $this->hasMany(UserTask::class, 'task_id');
    }
}
