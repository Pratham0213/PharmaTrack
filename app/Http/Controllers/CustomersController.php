<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\customersModel;

class CustomersController extends Controller
{
    public function customers(Request $request){
        // $data['getRecord'] = customersModel::get();
        $data['getRecord'] = customersModel::getAllRecord();

        return view('admin.customers.list', $data);
    }

    public function add_customers(Request $request){
        return view('admin.customers.add');
    }

    public function insert_add_customers(Request $request){
        // dd($request->all());
        // Insert customer data into database
        $save = new customersModel;
        $save->name = trim($request->name);
        $save->contact_number = trim($request->contact_number);
        $save->address = trim($request->address);
        $save->doctor_name = trim($request->doctor_name);
        $save->doctor_address = trim($request->doctor_address);
        $save->save();

        //redirect
        return redirect('admin/customers')->with('success', 'Customer Added Successfully');
    }

    public function edit_customers($id, Request $request){
        // echo $id; die();
        // $data['getRecord'] = customersModel::find($id);
        $data['getRecord'] = customersModel::getSingle($id);
        return view('admin.customers.edit', $data);
    }

    public function update_customers($id, Request $request){
        // dd($request->all());
        // $save = customersModel::find($id);
        $save = customersModel::getSingle($id);
        $save->name = trim($request->name);
        $save->contact_number = trim($request->contact_number);
        $save->address = trim($request->address);
        $save->doctor_name = trim($request->doctor_name);
        $save->doctor_address = trim($request->doctor_address);
        $save->save();

        //redirect
        return redirect('admin/customers')->with('success', 'Customer Details Updated Successfully');
    }

    public function delete_customers($id){
        // echo $id; die();
        // $delete_record = customersModel::find($id);
        $delete_record = customersModel::getSingle($id);
        $delete_record->delete();

        //redirect
        return redirect('admin/customers')->with('error', 'Customer Deleted Successfully');
    }
}
