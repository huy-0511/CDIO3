<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $table = 'bills';
    public function bill_detail(){
    	return $this->hasMany('App\Models\BillDetails','id_bill','id'); // quan he 1 thuộc về
    }
    public function bill(){
    	return $this->belongsTo('App\Models\Customer','id_customer','id'); // quan he 1 thuộc về
    }
}
