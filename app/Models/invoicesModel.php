<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 */

class invoicesModel extends Model{
    use HasFactory;
    protected $table = 'invoices'; 

    public function getCustomersName(){

        return $this->belongsTo(customersModel::class, 'customers_id');
    }
}