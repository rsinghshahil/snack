<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Meal;
use App\MealLink;
use Illuminate\Support\Facades\DB;

class MealLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('meal_links as ml')
        ->select('ml.*','m.name','m.image')
        ->leftjoin('meals as m','ml.meal_id','m.id')
        ->get();

        return response()->json([
            'data' => $data
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd('create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd('store');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $check = MealLink::where('meal_id',$id)->first();
        if ($check == null){
            $token =  $token = time() . str_random();
            $link = url('meal_link/') . '/' . $token .'/edit';
            MealLink::create([
                'meal_id' => $id,
                'link'    => null,
                'meal_link'    => $link,
                'token'   => $token,
            ]);
            return response('The link has been generated. Thanks!',200);

        }else{
            return response()->json(['data' => 'error'],304);
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
        dd('edit',$id);
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
        dd('update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = MealLink::find($id);
        $delete->delete();
        return response("Deleted",200);

    }
}
