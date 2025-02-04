<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salary_type extends Model
{
    protected $fillable = [
        'name',
        'status'
    ];

    public function workers()
    {
        return $this->hasMany(Worker::class, 'salary_type_id');
    }
}
