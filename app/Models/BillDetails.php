<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillDetails extends Model
{
    protected $table = 'bill_detail';
    public function product_type(){
    	return $this->belongsTo('App\Models\Product','id_product','id'); // quan he 1 thuộc về
    }
    public function bill(){
    	return $this->belongsTo('App\Models\Bill','id_Bill','id'); // quan he 1 thuộc về
    }
}
