<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Trips;

class tripController extends Controller
{
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
    public function create(Request $request)
    {
      $waypoints= array();
      $j=0;
      for ($i=0; $i < count($request->waypts) ; $i++) {
        if (($i>1) && ($i<(count($request->waypts)))) {
          $waypoints[$j++]=$request->waypts[$i];
        }
      }
        $trip=new Trips();
        $trip->user_email=$request->user_email;
        $trip->trip_name=$request->waypts[0]." "."To"." ".$request->waypts[1];
        $trip->start_location=$request->waypts[0];
        $trip->end_location=$request->waypts[1];
        $trip->waypoints=((count($waypoints)==1)?$waypoints[0]:serialize($waypoints));
        $trip->save();
        return($waypoints);
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
    public function destroy($id)
    {
        //
    }
}