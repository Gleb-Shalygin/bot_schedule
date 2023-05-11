<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherGroup extends Model
{
    use HasFactory;

    public $table = 'teachers_groups';

    protected $fillable = [
        'id_group',
        'id_teacher'
    ];
}
