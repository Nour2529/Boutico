<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'description', 'price', 'marque_id','category_id', 'stock', 'part_number','image'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function marque(){
        return $this->belongsTo(Marque::class);
    }

}
