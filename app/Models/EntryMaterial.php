<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntryMaterial extends Model
{
    protected $fillable = [
        'entry_id',
        'material_id',
        'quantity',
        'price',
        'total',
        'unit'
    ];

    public function entry()
    {
        return $this->belongsTo(Entry::class,'entry_id');
    }

    public function material()
    {
        return $this->belongsTo(Material::class,'material_id');
    }
}
