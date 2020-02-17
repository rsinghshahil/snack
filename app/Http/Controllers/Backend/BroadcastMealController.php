<?php

namespace App\Http\Controllers\Backend;

use App\BroadcastMeal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Meal;
use Carbon\Carbon;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\DB;
use MessageBird\Objects\Voice;
use MessageBird\Objects;
use MessageBird\Client;
use MessageBird;
use MessageBird\Objects\Message;

class BroadcastMealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(BroadcastMeal::first() == null){
            $data = DB::table('meals as m')
                        ->select(['m.id','m.image','m.name','m.status','m.price',DB::raw('0 as bcreated_at')])
                        ->get();
        }else{
            $data = DB::table('meals as m')
                        ->select(['m.id','m.image','m.name','m.status as mstatus','m.price','bm.id as bid','bm.meal_id','bm.created_at','bm.status as bstatus'])
                        ->leftJoin('broadcast_meals as bm','m.id','=','bm.meal_id')
                        ->where('m.status',1)
                        ->get();
        }
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
        // $check = BroadcastMeal::all()->last();
        // dd($check);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BroadcastMeal  $broadcastMeal
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $meal = Meal::find($id);

        if (BroadcastMeal::first() == null) {
            $broadcast = new BroadcastMeal();
            $broadcast->meal_id = $meal->id;
            $broadcast->status = 1;
            $broadcast->save();

        }else {

            if (BroadcastMeal::where('meal_id',$meal->id)->first() == null){
                $check = BroadcastMeal::where('meal_id','!=',$meal->id)
                ->update(['status' => 0,'updated_at' => false]);
                $broadcast = new BroadcastMeal();
                $broadcast->meal_id = $meal->id;
                $broadcast->status = 1;
                $broadcast->save();
            }else {
                $check = BroadcastMeal::where('meal_id','!=',$meal->id)
                ->update(['status' => 0,'updated_at' => false]);
                $broadcast = BroadcastMeal::where('meal_id','=',$meal->id)
                ->update(['status' => 1]);
            }
        }
        // $check = BroadcastMeal::whereDate('created_at', Carbon::today())->get();

        return response('Meal Opened for the day',200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BroadcastMeal  $broadcastMeal
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $meal = Meal::find($id);

            if (BroadcastMeal::where('meal_id',$meal->id)->first() != null){
                $check = BroadcastMeal::where('meal_id','=',$meal->id)
                ->update(['status' => 0]);
            }

        return response('Meal Closed for the day',200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BroadcastMeal  $broadcastMeal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BroadcastMeal $broadcastMeal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BroadcastMeal  $broadcastMeal
     * @return \Illuminate\Http\Response
     */
    public function destroy(BroadcastMeal $broadcastMeal)
    {
        //
    }

    public function makeCall() {

        try {
            $messagebird = new MessageBird\Client('srk4fVh5qVtRm1opigKfPDV3I');
            // dd($messagebird->voiceCalls);
            $call = $messagebird->voiceCalls;
            $call->source = '9779841218814';
            $call->destination = '9779818546400';

            $flow = $messagebird->voiceCallFlows;
            $flow->title = 'Test Flow';

            $step = new MessageBird\Objects\Voice\Step;
            $step->action = 'say';
            $step->options = [
                'payload' => 'Hey you, a little bird told me you wanted a call!',
                'language' => 'en-GB',
                'voice' => 'female'
            ];
            $flow->steps = [ $step ];
            $call->callFlow = $flow;
            $response = $messagebird->voiceCalls->create($call);
            dd($response);

        }
        catch(\Exception $e) {

            return response()->json($e->getMessage(),500);
        }
    }
}
