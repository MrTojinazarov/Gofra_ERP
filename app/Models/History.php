<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $fillable = [
        'type',
        'status',
        'material_id',
        'quantity',
        'was',
        'been',
        'from_id',
        'to_id'
    ];

    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }

    public function from()
    {
        return $this->belongsTo(Warehouse::class,'warehouse_id');
    }

    public function to()
    {
        return $this->belongsTo(Warehouse::class,'warehouse_id');
    }

    public function entry()
    {
        return $this->belongsTo(Entry::class,'entry_id');
    }
}
