<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product_translation extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table = 'product_translations';
}
