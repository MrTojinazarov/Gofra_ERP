<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produce extends Model
{
    protected $fillable = ['product_id', 'count','defect'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
