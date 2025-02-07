<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MachineProduce extends Model
{
    protected $fillable = ['machine_id', 'produce_id','count','defect','user_id'];
}
