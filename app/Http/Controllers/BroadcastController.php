<?php

namespace App\Http\Controllers;
use App\Broadcast;
use App\Tower;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Validator, Input, Redirect ,Session ;

class BroadcastController extends Controller
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
    public function destroy($id)
    {
        //
    }


/*
* Display all data
*/

    public function BroadcastTable(Request $request , $id){
        if ($request->ajax()) {
            $broadcast = Tower::find($id);
            return Datatables::of(Broadcast::with('user','device')->where('tower_id', $broadcast->id))
                ->rawColumns(['action'])
                ->addColumn('action', function ($broadcast) {
                        return '
                <td class="text-center">
                    <!-- Single button -->
                    <div class="btn-group" >
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="" data-toggle="modal" data-target="#viewModal_broadcast" onclick="fun_view_broadcast(' . $broadcast->id . ')">View</a></li>
                            <li><a href="" data-toggle="modal" data-target="#editModal_broadcast" onclick="fun_edit_broadcast(' .  $broadcast->id  . ')">Edit</a></li>
                            <li><a href="" data-toggle="modal" data-target="#addModal_broadcast_ticket">Ticket</a></li>
                        </ul>
                    </div>
                </td>       
                             ';
                })
                ->make(true);
        }
    }

    public function broadcast_view_crud()
    {
        return view('vendor.adminlte.pages.tower.partials.broadcast_view_crud');
    }

    /*
     * Add student data
     */
    public function addAjax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'number_sign'       => 'max:10',
            'name'              => 'max:20',
            'ssid'              => 'max:30 | required',
            'antenna'           => 'max:20',
            'direction'         => 'max:100',
            'device_id'         => 'required',
            'ip'                => 'ip | required | unique:broadcasts',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator);
        } else {
            $data = new Broadcast;
            $data->device_id             = $request->device_id;
            $data->number_sign           = $request->number_sign;
            $data->name                  = $request->name;
            $data->ssid                  = $request->ssid;
            $data->ip                    = $request->ip;
            $data->mac                   = $request->mac;
            $data->antenna               = $request->antenna;
            $data->degree                = $request->degree;
            $data->gin                   = $request->gin;
            $data->channal               = $request->channal;
            $data->channal_width         = $request->channal_width;
            $data->direction             = $request->direction;
            $data->broadcasts_info       = $request->broadcasts_info;
            $data->tower_id              = $request->tower_id;
            $data->created_by            = Auth::User()->id;
            $data->updated_by            = Auth::User()->id;
            $data->save();
            return back()
                ->with('message_broadcast', 'this Broadcast added successfully.');
        }
    }

    /*
     * View data
     */
    public function viewAjax(Request $request)
    {
        $cw = channel_width();
        if($request->ajax()){
            $id = $request->id;
            $info = Broadcast::find($id);
            //echo json_decode($info);
            $info->channel_width = $cw[$info->channal_width];
            return response()->json($info);
        }
    }

    /*
    *   Update data
    */
    public function updateAjax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'number_sign'       => 'max:5',
            'name'              => 'max:20',
            'ssid'              => 'max:30 | required',
            'antenna'           => 'max:20',
            'direction'         => 'max:50',
            'device_id'         => 'max:5 | required',
            'ip'                => 'ip | required',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator);
        } else {
        $id = $request -> edit_id;
        $data = Broadcast::find($id);
            $data->device_id             = $request->device_id;
            $data->number_sign           = $request->number_sign;
            $data->name                  = $request->name;
            $data->ssid                  = $request->ssid;
            $data->ip                    = $request->ip;
            $data->mac                   = $request->mac;
            $data->antenna               = $request->antenna;
            $data->degree                = $request->degree;
            $data->gin                   = $request->gin;
            $data->channal               = $request->channal;
            $data->channal_width         = $request->channal_width;
            $data->direction             = $request->direction;
            $data->broadcasts_info       = $request->broadcasts_info;
            $data->updated_by            = Auth::User()->id;
        $data -> save();
        return back()
            ->with('message_broadcast','Broadcast Updated successfully.');
         }
    }

    /*
    *   Delete record
    */
    public function deleteAjax(Request $request)
    {
        $id = $request -> id;
        $data = Broadcast::find($id);
        $response = $data -> delete();
        if($response)
            echo "Record Deleted successfully.";
        else
            echo "There was a problem. Please try again later.";
    }

}
