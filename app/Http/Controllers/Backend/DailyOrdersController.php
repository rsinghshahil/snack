<?php

namespace App\Http\Controllers\Backend;

use App\BreadSize;
use App\BreadType;
use App\DailyOrder;
use App\Flavour;
use App\Sauce;
use App\Vegetable;
use Alert;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DailyOrdersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        // dd('yu hoooooo!',$request->all());
        $meal_status = $request->meal_status;

        // Validation code goes here
        $valid = Validator::make($request->all(),[
            'bread'             => 'required',
            'baked'             => 'required',
            'bread_size'        => 'required',
            'taste_preference'  => 'required',
            'extras'            => 'required',
            'vegetable'         => 'required',
            'sauce'             => 'required',
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

        $breadtype = BreadType::find($request->bread)->first();
        $breadsize = BreadSize::find($request->bread_size)->first();
        $vegetable = Vegetable::find($request->vegetable)->first();
        $flavour = Flavour::find($request->taste_preference)->first();
        $sauce = Sauce::find($request->sauce)->first();
        $baked = $request->baked;
        $extra = $request->extras;

        $total_cost = $breadtype->cost + $breadsize->cost + $flavour->cost + $vegetable->cost + $sauce->cost;
        // dd($total_cost);

        $orders = DailyOrder::create([
            'meal_id' => $request->meal_id,
            'user_id' => auth()->user()->id,
            'bread_type' => $breadtype->id,
            'bread_size' => $breadsize->id,
            'flavour' => $flavour->id,
            'vegetable' => $vegetable->id,
            'sauce' => $sauce->id,
            'non_baked' => $baked,
            'extras' => $extra,
            'total_cost' => $total_cost
        ]);
            Alert::success('Success', 'Order Placed. Thank You!');

        return redirect()->back()->with('success','Order has been placed. Thank You!');
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
