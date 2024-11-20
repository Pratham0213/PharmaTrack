<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 */

class medicinesStockModel extends Model{

    use HasFactory;
    protected $table = 'medicines_stock'; 

    public function getMedicinesName(){
        return $this->belongsTo(medicinesModel::class, 'medicines_id');
    }
}