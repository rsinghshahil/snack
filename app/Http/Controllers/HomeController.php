<?php

namespace App\Http\Controllers;

use App\BreadSize;
use App\BreadType;
use App\BroadcastMeal;
use App\Flavour;
use App\Sauce;
use App\Vegetable;
use App\Rating;
Use Alert;
use App\DailyOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = DB::table('broadcast_meals as bm')
                    ->select('bm.id','bm.meal_id','bm.status','m.image','m.name')
                    ->leftjoin('meals as m','bm.meal_id','=','m.id')
                    // ->where('bm.status',1)
                    ->latest('bm.updated_at')
                    ->get()[0];

        if($data != null){
            $has_previous_order = DB::table('dailyorders')
                            ->where('meal_id',$data->meal_id)
                            ->where('user_id',Auth::user()->id)
                            ->orderBy('created_at','desc')
                            // ->skip(1)
                            ->take(1)
                            ->first();
        }

        $breadtypes = BreadType::all();
        $breadsizes = BreadSize::all();
        $vegetables = Vegetable::all();
        $flavours = Flavour::all();
        $sauces = Sauce::all();
        $rating = Rating::where('user_id',Auth::user()->id)->where('meal_id',$data->meal_id)->first();
        return view('home')->with(compact('rating','data','breadtypes','has_previous_order','breadsizes','flavours','sauces','vegetables'));
        // return redirect()->to('/login');
    }

    public function postStar (Request $request)
    {
        $check = Rating::where('user_id',Auth::user()->id)
                        ->where('meal_id',$request->meal_id)
                        ->first();

        if ($check == null) {
            Rating::create([
                'user_id' => Auth::user()->id,
                'meal_id' => $request->meal_id,
                'rating'  => $request->rating,
            ]);
        }else {
            $rating = Rating::where('user_id',Auth::user()->id)
                    ->where('meal_id',$request->meal_id)
                    ->update(['rating' => $request->rating]);
        }
        return response('Your feedback has been recorded. Thanks!',200);
    }
    public function userLog()
    {
        $logs = DB::table('dailyorders as od')
                    ->select('od.*','m.id as mid','m.name','m.image')
                    ->leftjoin('meals as m','od.meal_id','=','m.id')
                    ->where('user_id',Auth::user()->id)
                    ->orderBy('updated_at','desc')
                    ->get();
        // dd($logs);
        return view('user-meal-log')->with(compact('logs'));
    }

}
