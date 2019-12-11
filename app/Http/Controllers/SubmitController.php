<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Form;
use Log;

class SubmitController extends Controller
{

    public function store(Request $request){
    	if (Form::where('phone_number', '=', $request->phone_number)->exists()) {
   			return response()->json(['duplicate_phone_number' => 1]);
		}
    	else
    	{	
    	 		return Form::firstorCreate([
    					'name'=> $request->name,
                        'email'=>$request->email,
                        'phone_number'=>$request->phone_number,
                        'password' => Hash::make($request['password']),
                ]);
    	}   	
    }
}
