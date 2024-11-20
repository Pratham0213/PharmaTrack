<?php

namespace App\Http\Controllers;

use App\Models\customersModel;
use App\Models\invoicesModel;
use App\Models\medicinesModel;
use App\Models\medicinesStockModel;
use App\Models\purchasesModel;
use App\Models\suppliersModel;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Str;
use File;

class DashboardController extends Controller
{
    public function dashboard(){
        $data['TotalCustomers'] = customersModel::count();
        $data['TotalMedicines'] = medicinesModel::count();
        $data['TotalMedicinesStoke'] = medicinesStockModel::count();
        $data['TotalSuppliers'] = suppliersModel::count();
        $data['TotalInvoices'] = invoicesModel::count();
        $data['TotalPurchased'] = purchasesModel::count();
        return view('admin.dashboard.list', $data);
    }

    public function my_account(Request $request){
        // echo 'wjkcdbjs'; die();
        $data['getRecord'] = User::find(Auth::user()->id);
        return view('admin.my_account.update', $data);
    }

    public function my_account_update(Request $request){
        // dd($request->all());
        $save = request()->validate([
            'email' => 'required|unique:users,email,'.Auth::user()->id
        ]);

        $save = User::find(Auth::user()->id);
        $save->name = trim($request->name);
        $save->email = trim($request->email);

        if(!empty($request->password)){
            $save->password = Hash::make($request->password);
        }

        //profile
        if(!empty($request->file('profile_image'))){

            if(!empty($save->profile_image) && file_exists('upload/profile/'.$save->profile_image)){
                unlink('upload/profile/'.$save->profile_image);
            }

            $file = $request->file('profile_image');
            $randomStr = Str::random(30);
            // $filename = $randomStr. '.'.$file()->getClientOriginalExtension();
            $filename = $randomStr . '.' . $file->getClientOriginalExtension();


            $file->move('upload/profile/', $filename);
            $save->profile_image = $filename;
        }
        //profile end


        $save->save();
        return redirect('admin/my_account')->with('success', 'Profile updated successfully');
    }
}
