<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Trips;
use Session;
use Cornford\Googlmapper\Facades\MapperFacade as Mapper;

class tripController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $trips=Trips::where('user_email',\Auth()->user()->email)->get(['id','trip_name']);
      if (Session::has('trip_details')) {
        $source=Session::get('source');
        $destination=Session::get('destination');
        $waypoints=Session::get('waypts');

        Mapper::map(0, 0, ['eventAfterLoad' => 'addRoute(map_0);']);
        return view('all_trips',['trips'=>$trips]);
      }
      else {
        Mapper::map(0, 0, ['locate' => true]);
        return view('all_trips',['trips'=>$trips]);
      }
        //echo($trips[0]);

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
        Session::flash('message', "Trip Saved");
        return Redirect::back();
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
        $trip_details=Trips::where('id',$id)->get();
        $all_pts=[];
        //$source
        //echo $trip_details[0];
        $source=$trip_details[0]->start_location;
        $destination=$trip_details[0]->end_location;
        $waypoints=unserialize($trip_details[0]->waypoints);
        foreach ($waypoints as $waypt) {
          array_push($all_pts,$waypt);
        }
        Session::flash('trip_details',$trip_details);
        Session::flash('source',$source);
        Session::flash('destination',$destination);
        $all_points=collect($all_pts);
        Session::flash('waypts',$all_points);
        //echo $all_points;
        return redirect()->back()->with(compact($source),compact($destination),compact($waypoints));
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
