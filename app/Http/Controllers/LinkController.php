<?php

namespace App\Http\Controllers;

use App\MealLink;
use App\User;
use App\UserLocation;
use Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LinkController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data = DB::table('meal_links as ml')
        //         ->select('ml.*','m.name')
        //         ->leftjoin('meals as m','ml.meal_id','m.id')
        //         ->get();
        //         dd($data);
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
        // gets the geo infos via ip

        $geo = geoip()->getLocation('27.34.26.31');
        // $geo = geoip()->getLocation($_SERVER['REMOTE_ADDR']);

        if (Auth::user() == null) {
            Alert::toast('Please login and try the link again','info');
            return redirect()->route('login');
        }

        if (UserLocation::where('user_id',Auth::user()->id)->first() == null) {
                UserLocation::create([
                    'user_id'   => Auth::user()->id,
                    'ip'        => $geo->ip,
                    'country'   => $geo->country,
                    'city'      => $geo->city,
                    'state_name'=> $geo->state_name,
                    'lat'       => $geo->lat,
                    'lon'       => $geo->lon,
                    'timezone'  => $geo->timezone
                ]);
        }else {
            $location = UserLocation::where('user_id',Auth::user()->id)
                    ->update([
                    'ip'        => $geo->ip,
                    'country'   => $geo->country,
                    'city'      => $geo->city,
                    'state_name'=> $geo->state_name,
                    'lat'       => $geo->lat,
                    'lon'       => $geo->lon,
                    'timezone'  => $geo->timezone
                    ]);
        }

        $meal = DB::table('meals as m')
                ->select('m.id','m.name','m.image','bm.status as bmstatus')
                ->leftJoin('meal_links as ml','m.id','=','ml.meal_id')
                ->leftJoin('broadcast_meals as bm','m.id','=','bm.meal_id')
                ->where('ml.token',$id)
                ->get()[0];
        // dd($meal);
        return view('current-order')->with(compact('meal'));
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
