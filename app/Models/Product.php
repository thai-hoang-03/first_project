<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "products";

    protected $fillable = [
        'id_category', 'id_brand', 'id_user', 'image', 'name', 'web_id', 'price',
        'status', 'sale', 'condition', 'description', 'company_profile'
    ];

    public function category(){
        return $this->belongsTo(Category::class, 'id_category');
    }

    public function brand(){
        return $this->belongsTo(Brand::class, 'id_brand');
    }

    public function user(){
        return $this->belongsTo(User::class, 'id_user');
    }

}
