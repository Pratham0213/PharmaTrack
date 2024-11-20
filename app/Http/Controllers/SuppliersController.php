<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\suppliersModel;

class SuppliersController extends Controller{
    public function index(Request $request){
        // echo 'lollllll'; die();
        $data['getRecord'] = suppliersModel::get();
        return view('admin.suppliers.list', $data);  
    }

    public function create(Request $request){
        // echo 'lollllll'; die();
        return view('admin.suppliers.add');
    }

    public function store(Request $request){
        // echo 'lollllll'; die();
        // dd($request->all());
        $save = new suppliersModel;
        $save->suppliers_name = trim($request->suppliers_name);
        $save->suppliers_email = trim($request->suppliers_email);
        $save->contact_number = trim($request->contact_number);
        $save->address = trim($request->address);
        $save->save();

        //redirect
        return redirect('admin/suppliers')->with('success', 'Supplier Added Successfully');
    }

    public function edit(Request $request, $id){
        // echo $id; die();
        $data['getRecord'] = suppliersModel::find($id);
        return view('admin.suppliers.edit', $data);
    }

    public function update(Request $request, $id){
        $save = suppliersModel::find($id);
        $save->suppliers_name = trim($request->suppliers_name);
        $save->suppliers_email = trim($request->suppliers_email);
        $save->contact_number = trim($request->contact_number);
        $save->address = trim($request->address);
        $save->save();

        //redirect
        return redirect('admin/suppliers')->with('success', 'Supplier Updated Successfully');
    }

    public function delete(Request $request, $id){
        // echo $id; die();
        $remove = suppliersModel::find($id);
        $remove->delete();
        return redirect('admin/suppliers')->with('error', 'Supplier Deleted Successfully');
    }
}