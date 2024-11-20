<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\medicinesModel;
use App\Models\medicinesStockModel;

class MedicinesController extends Controller
{
    public function medicines(Request $request)
    {
        $data['getRecord'] = medicinesModel::where('isDeleted', '=', 0)->get();
        return view('admin.medicines.list', $data);
    }

    public function add_medicines()
    {
        return view('admin.medicines.add');
    }

    public function add_update_M(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'packing' => 'required',
            'generic_name' => 'required',
            'supplier_name' => 'required',
        ]);

        $SaveUpdate = new medicinesModel;
        $SaveUpdate->name = $request->name;
        $SaveUpdate->packing = $request->packing;
        $SaveUpdate->generic_name = $request->generic_name;
        $SaveUpdate->supplier_name = $request->supplier_name;
        $SaveUpdate->save();

        return redirect('admin/medicines')->with('success', 'Medicine added successfully');
    }

    public function edit_medicines($id)
    {
        // echo 'Edit Med'; die();
        $data['getRecord'] = medicinesModel::find($id);
        return view('admin.medicines.edit', $data);
    }

    public function add_update_edit($id, Request $request)
    {
        // echo 'Add Update'; die();
        $request->validate([
            'name' => 'required',
            'packing' => 'required',
            'generic_name' => 'required',
            'supplier_name' => 'required',
        ]);

        $SaveUpdate = medicinesModel::find($id);

        if (!$SaveUpdate) {
            return redirect('admin/medicines')->with('error', 'Record not found');
        }

        $SaveUpdate->name = $request->name;
        $SaveUpdate->packing = $request->packing;
        $SaveUpdate->generic_name = $request->generic_name;
        $SaveUpdate->supplier_name = $request->supplier_name;
        $SaveUpdate->save();

        return redirect('admin/medicines')->with('success', 'Medicine Updated successfully');
    }

    public function medicines_delete($id){
        // echo $id; die();
        $deleteRecord = medicinesModel::find($id);
        $deleteRecord->isDeleted = 1;
        $deleteRecord->save();
        // $deleteRecord->delete();

        return redirect('admin/medicines')->with('success', 'Medicine deleted successfully');
    }

    public function medicines_stock_list(){
        // echo 'sdnzbcvjhs'; die();
        $data['getRecord'] = medicinesStockModel::get();
        return view('admin.medicines_stock.list', $data);
    }

    public function medicines_stock_add(){
        // echo 'add new medicine stock'; die();
        $data['getRecord'] = medicinesModel::where('isDeleted', '=', 0)->get();
        return view('admin.medicines_stock.add', $data);
    }

    public function medicines_stock_store(Request $request){
        // dd($request->all());
        $SaveUpdate = new medicinesStockModel;

        $SaveUpdate->medicines_id = $request->medicines_id;
        $SaveUpdate->batch_id = $request->batch_id;
        $SaveUpdate->expiry_date = $request->expiry_date;
        $SaveUpdate->quantity = $request->quantity;
        $SaveUpdate->mrp = $request->mrp;
        $SaveUpdate->rate = $request->rate;
        $SaveUpdate->save();

        return redirect('admin/medicines_stock')->with('success', 'Medicine Stock Saved successfully');

    }

    public function medicines_stock_delete(Request $request, $id){
        // echo 'delete medicine stock'; die();
        $DeleteRecord = medicinesStockModel::find($id);
        $DeleteRecord->delete();

        return redirect('admin/medicines_stock')->with('success', 'Medicine Stock deleted successfully');
    }

    public function medicines_stock_edit($id, Request $request){
        // echo 'edit medicine stock'; die();
        // $data['getRecord'] = medicinesStockModel::find($id);
        $data['oldRecord'] = medicinesStockModel::find($id);
        $data['getRecord'] = medicinesModel::where('isDeleted', '=', 0)->get();
        return view('admin.medicines_stock.edit', $data);
    }

    public function medicines_stock_edit_update($id, Request $request){
        $SaveUpdate = medicinesStockModel::find($id);

        $SaveUpdate->medicines_id = $request->medicines_id;
        $SaveUpdate->batch_id = $request->batch_id;
        $SaveUpdate->expiry_date = $request->expiry_date;
        $SaveUpdate->quantity = $request->quantity;
        $SaveUpdate->mrp = $request->mrp;
        $SaveUpdate->rate = $request->rate;
        $SaveUpdate->save();

        return redirect('admin/medicines_stock')->with('success', 'Medicine Stock Updated successfully');

    }


}