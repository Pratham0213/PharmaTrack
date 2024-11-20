<?php

namespace App\Http\Controllers;

use App\Models\invoicesModel;
use App\Models\purchasesModel;
use App\Models\suppliersModel;
use Illuminate\Http\Request;

class PurchasesController extends Controller{
    public function index(Request $request){
        // echo 'kjkjbjh'; die();
        $data['getRecord'] = purchasesModel::get(); 
        return view('admin.purchases.list', $data);
    }

    public function create(){
        // echo 'kjkjbjh'; die();
        $data['GetSuppliers'] = suppliersModel::get();
        $data['GetInvoices'] = invoicesModel::get();
        return view('admin.purchases.add', $data);
    }

    public function store(Request $request){
        // dd($request->all());
        $save = new purchasesModel;
        $save->suppliers_id = $request->suppliers_id;
        $save->invoices_id = $request->invoices_id;
        $save->voucher_number = $request->voucher_number;
        $save->purchase_date = $request->purchase_date;
        $save->total_amount = $request->total_amount;
        $save->payment_status = $request->payment_status;
        $save->save();

        //redirect
        return redirect('admin/purchases')->with('success', 'Purchases Added Successfully');
    }

    public function edit($id, Request $request){
        // echo 'kjkjbjh'; die();
        $data['getRecord'] = purchasesModel::find($id);
        $data['GetSuppliers'] = suppliersModel::get();
        $data['GetInvoices'] = invoicesModel::get();
        return view('admin.purchases.edit', $data);
    }

    public function update($id, Request $request){
        $save = purchasesModel::find($id);
        $save->suppliers_id = $request->suppliers_id;
        $save->invoices_id = $request->invoices_id;
        $save->voucher_number = $request->voucher_number;
        $save->purchase_date = $request->purchase_date;
        $save->total_amount = $request->total_amount;
        $save->payment_status = $request->payment_status;
        $save->save();

        //redirect
        return redirect('admin/purchases')->with('success', 'Purchases Successfully Update');
    }

    public function delete($id, Request $request){
        $delete_record = purchasesModel::find($id);
        $delete_record->delete();
        //redirect
        return redirect('admin/purchases')->with('error', 'Purchases Successfully Delete');
    }
}