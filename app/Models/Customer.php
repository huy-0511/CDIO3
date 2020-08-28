<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';
    protected $fillable = [
        'name', 'gender', 'email','address','phone_number','note'
    ];
    public function bill(){
    	return $this->hasMany('App\Models\Bill','id_customer','id'); // quan he 1 thuộc về
    }
    
}
