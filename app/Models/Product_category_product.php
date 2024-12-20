<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product_category;
use App\Models\Product_category_transletion;

class Product_category_product extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'product_category_products';

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function category_detail()
    {
        return $this->hasOne(Product_category::class, 'id','category_id');
    }

  

}
