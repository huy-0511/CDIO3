<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'name','unit_price','promotion_price','image','unit','id_type','new','description'
    ];
    public function product_type(){
    	return $this->belongsTo('App\Models\ProductType','id_type','id'); // quan he 1 thuộc về
    }
    public function bill_detail	(){
    	return $this->hasMany('App\Models\BillDetails','id_product','id'); // quan he 1 thuộc về
    }
}
