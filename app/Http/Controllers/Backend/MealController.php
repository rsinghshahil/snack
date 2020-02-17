<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Meal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class MealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('meals as m')
                ->select(['m.id','m.image','m.name','m.status','m.price'])
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
        //
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
            'meal.name'         => 'required',
            'meal.image'        => 'required',
            'meal.price'       => 'required',
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
        $meal = Meal::create([
            'name' => $request['meal']['name'],
            'image' => $request['meal']['image'],
            'price' => $request['meal']['price'],
        ]);
        return response('Meal Saved Successfully!', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Meal  $meal
     * @return \Illuminate\Http\Response
     */
    public function show(Meal $meal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Meal  $meal
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return response()->json(['data' => Meal::find($id)],200);
    }

        /**
     * Activation and Deactivation.
     */
    public function activate($id)
    {
        $check = Meal::find($id);
        $check->status = 1;
        $check->save();
        if($check){
            return response('Meal Activated!',200);
        }
    }

    public function terminate($id)
    {
        $check = Meal::find($id);
        $check->status = 2;
        $check->save();
        if($check){
            return response('Meal on HOlD!',200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Meal  $meal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Meal $meal)
    {
        $valid = Validator::make($request->all(),[
            'meal.name'        => 'required',
            'meal.image'       => 'required',
            'meal.price'       => 'required',
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

        $meal->name = $request['meal']['name'];
        $meal->image = $request['meal']['image'];
        $meal->price = $request['meal']['price'];
        $meal->save();
        return response('Meal Updated!',200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Meal  $meal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Meal $meal)
    {
        if($meal->delete()){
            return response('Customer Deleted!',200);
        }
    }
}
