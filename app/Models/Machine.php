<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    protected $fillable = ['name','status'];

    public function machine_produces()
    {
        return $this->hasMany(MachineProduce::class, 'machine_id');
    }
}
