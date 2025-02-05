<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    protected $fillable = ['company', 'text', 'date'];

    public function entry_materials()
    {
        return $this->hasMany(EntryMaterial::class, 'entry_id');
    }
}
