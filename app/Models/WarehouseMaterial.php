<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarehouseMaterial extends Model
{
    protected $fillable = ['warehouse_id','product_id','value','type'];

    public function material()
    {
        return $this->belongsTo(Material::class,'material_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class,'warehouse_id');
    }
}
