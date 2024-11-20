<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\invoicesModel;
use App\Models\customersModel;

class InvoicesController extends Controller
{
    public function index(Request $request){
        // echo "bchjsbvsdh"; die();
        $data['getRecord'] = invoicesModel::get();
        return view('admin.invoices.list', $data);
    }

    public function create(Request $request){
        $data['getRecord'] = customersModel::get();
        return view('admin.invoices.add', $data);
    }

    public function store(Request $request){
        //dd($request->all());
        $save = new invoicesModel;
        $save->net_total = $request->net_total;
        $save->invoices_date = $request->invoices_date;
        $save->customers_id = $request->customers_id;
        $save->total_amount = $request->total_amount;
        $save->total_discount = $request->total_discount;

        $save->save();

        //redirect
        return redirect('admin/invoices')->with('success', 'Invoices Added Successfully');
    }

    public function delete($id,Request $request){
        // echo $id; die();

        $deleteRecord = invoicesModel::find($id);
        $deleteRecord->delete();
        //redirect
        return redirect('admin/invoices')->with('success', 'Invoices Deleted Successfully');
    }

    public function edit($id,Request $request){
        // echo $id; die();
        $data['EditRecord'] = invoicesModel::find($id);
        $data['getRecord'] = customersModel::get();
        return view('admin.invoices.edit', $data);
    }

    public function update(Request $request, $id){
        // dd($request->all());

        $update = invoicesModel::find($id);
        $update->net_total = trim($request->net_total);
        $update->customers_id = trim($request->customers_id);
        $update->invoices_date = trim($request->invoices_date);
        $update->total_amount = trim($request->total_amount);
        $update->total_discount = trim($request->total_discount);
        $update->save();

        //redirect
        return redirect('admin/invoices')->with('success', 'Invoices Updated Successfully');
    }
    
}