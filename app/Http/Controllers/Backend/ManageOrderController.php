<?php

namespace App\Http\Controllers\Backend;

use App\BreadSize;
use App\BreadType;
use App\DailyOrder;
use App\Flavour;
use App\Sauce;
use App\Vegetable;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManageOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(Carbon::now()->toDateString(),'here');
        $orders = DB::table('dailyorders as o')
                    ->select('o.id','o.non_baked','o.meal_id','o.user_id','o.bread_type','o.bread_size','o.flavour','o.vegetable','o.sauce','o.extras','o.total_cost','o.status',
                        'bt.id as bt_id','bt.name as bt_name',
                        'bs.id as bs_id','bs.size as bs_size',
                        'fl.id as fl_id','fl.name as fl_name',
                        'vg.id as vg_id','vg.name as vg_name',
                        'sc.id as sc_id','sc.name as sc_name',
                        'm.id as m_id','m.name as m_name',
                        'u.id as u_id','u.name as user_name','u.mobile as user_mobile'
                    )
                    ->leftJoin('breadtypes as bt','o.bread_type','bt.id')
                    ->leftJoin('breadsizes as bs','o.bread_size','bs.id')
                    ->leftJoin('flavours as fl','o.flavour','fl.id')
                    ->leftJoin('vegetables as vg','o.vegetable','vg.id')
                    ->leftJoin('sauces as sc','o.sauce','sc.id')
                    ->leftJoin('meals as m','o.meal_id','m.id')
                    ->leftJoin('users as u','o.bread_type','u.id')
                    // ->where('o.status',0)
                    ->whereDate('o.created_at',Carbon::now()->toDateString())
                    ->get();

        return response()->json(['data' => $orders],200);
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
        //
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
    public function destroy(DailyOrder $dailyOrder)
    {
        if($dailyOrder->delete()){
            return response('Customer Deleted!',200);
        }
    }

    public function take($id){
        // dd('take');
        $check = DailyOrder::find($id);
        $check->status = 100;
        $check->save();
        if($check){
            return response('Order Taken!',200);
        }
    }

    public function ready($id){
        // dd('ready');
        $check = DailyOrder::find($id);
        $check->status = 200;
        $check->save();
        if($check){
            return response('Order Ready!',200);
        }
    }

    public function deliver($id){
        // dd('deliver');
        $check = DailyOrder::find($id);
        $check->status = 300;
        $check->save();
        if($check){
            return response('Order Delivered!',200);
        }
    }
}
