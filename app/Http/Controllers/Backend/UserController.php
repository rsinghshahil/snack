<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('users as u')
                        ->select('u.id', 'u.name', 'u.email', 'u.status', 'u.mobile as phone','l.country','l.city','l.state_name')
                        ->leftJoin('user_locations as l','u.id','=','l.user_id')
                        ->get();

        return response()->json(['data' => $data],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return response()->json(['msg' => 'ok']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valid = Validator::make($request->all(),[
            'register.name'         => 'required',
            'register.email'        => 'required|email',
            'register.mobile'       => 'required',
            'register.password'     => 'required',
        ]);
        if($valid->fails()){
            $response = array(
                'error'     => $valid->errors(),
                'message'   => "Please fill the mandotory fields",
                'status'    => 0,
                'f_message' => $valid->errors()->first(),
            );
            return response()->json([
                'response' => $response
            ],422);
        }
        $user_data = $request['register'];
        if($user_data['password'] != $user_data['password_confirmation']){
            return response("Password doesn't match!",409);
        }
        try{
            $user = User::create([
                'name'      => $user_data['name'],
                'email'     => $user_data['email'],
                // 'mobile'    => $user_data['mobile'],
                'status'    => 1,
                'password'  => Hash::make($user_data['password'])
            ]);
            return response('Saved Successfully!', 200);
        }
        catch(Exception $e){

            return response($e->getMessage(),409);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Activation and Deactivation.
     */
    public function activate($id)
    {
        $check = User::find($id);
        $check->status = 1;
        $check->save();
        if($check){
            return response('Customer Activated!',200);
        }
    }

    public function terminate($id)
    {
        $check = User::find($id);
        $check->status = 2;
        $check->save();
        if($check){
            return response('Customer Terminated!',200);
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        return response()->json(['data' => User::find($id)],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $valid = Validator::make($request->all(),[
            'register.name'         => 'required',
            'register.email'        => 'required|email',
            'register.mobile'       => 'required',
        ]);
        if($valid->fails()){
            $response = array(
                'error'     => $valid->errors(),
                'message'   => "Please fill the mandotory fields",
                'status'    => 0,
                'f_message' => $valid->errors()->first(),
            );
            return response()->json([
                'response' => $response
            ],422);
        }
        $user_data = $request['register'];
        try{
            $user = User::find($id);
            $user->name = $user_data['name'];
            $user->email = $user_data['email'];
            // $user->mobile = $user_data['mobile'];
            $user->save();
            return response('Updated Successfully!', 200);
        }
        catch(Exception $e){

            return response($e->getMessage(),409);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $destroy = User::find($id);
        $destroy->delete();
        if($destroy){
            return response('Customer Deleted!',200);
        }
    }
}
