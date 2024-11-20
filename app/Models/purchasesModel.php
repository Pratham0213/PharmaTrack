<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 */

class purchasesModel extends Model{
    use HasFactory;
    protected $table = 'purchases';
    
    public function getSuppliersName(){
        return $this->belongsTo(suppliersModel::class,'suppliers_id');
    }
}