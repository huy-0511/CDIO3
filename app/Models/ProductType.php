<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    protected $table = 'type_products';
     protected $fillable = [
        'name','description','image'
    ];
    public function product(){
    	return $this->hasMany('App/Models/Product','id_type','id');// quan he 1 nhiều('duong dan',khoa ngoai,khoa chinh)

    }

}
