<?php

namespace App\Http\Controllers;

use App\Hub;
use App\Olt;
use App\RefillCard;
use App\RefillCustomer;
use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\Auth;
use App\Customer;
use App\AddressHelper;
use App\Device;
use App\Tower;
use App\CustomerTicket;
use App\Broadcast;
use Validator, Redirect ,Session ;




class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $refillCustomer = RefillCustomer::with('card','customer')->where('payment_status',1)->get();
        $refills = RefillCard::all();
        return view('vendor.adminlte.pages.customer.customers_dashboard',compact('refills','refillCustomer'));
    }


    public function CustomerTableOneView()
    {
        $refills = RefillCard::all();
        return view('vendor.adminlte.pages.customer.customers_dashboard',compact('refills'));
    }

    public function CustomerTableOneAjax()
    {
        $customers = Customer::select('id','fullname','username','mobile_1','connection_method');
        return Datatables::of($customers)->take(5)
            ->orderBy('created_at', 'id $1')

            ->editColumn('connection_method', function ($customers) {
                $array = connection_method_value();
                return $customers->connection_method = $array[$customers->connection_method];
            })

            ->editColumn('fullname',function ($customers){
                if ($customers->getUnpaid() > 0 or $customers->openTicketCount() > 0){
                    return '<div class="text-red" >'.$customers->fullname.'</div>';
                }else{
                    return $customers->fullname ;
                }
            })
            ->addColumn('navigation',function ($customers){
                if ($customers->getUnpaid() > 0 and $customers->openTicketCount() > 0){
                    return '<small class="label bg-red-active"> UnPaid  '.number_format( $customers->getUnpaid() / 1, 0).' </small>' . '<br> <br>' .'<small class="label bg-yellow"> '. $customers->openTicketCount() .' Open Ticket  </small>';
                }elseif ($customers->getUnpaid() > 0 and $customers->openTicketCount() == 0){
                    return '<small class="label bg-red-active"> UnPaid  '.number_format( $customers->getUnpaid() / 1, 0).' </small>' ;
                }elseif ( $customers->getUnpaid() == 0 and $customers->openTicketCount() > 0){
                    return '<small class="label bg-yellow-active"> '. $customers->openTicketCount() .' Open Ticket  </small>' ;
                }else{
                    return '' ;
                }
            })
            ->rawColumns(['action','navigation','fullname'])
            ->addColumn('action', function ($customers) {
                return '
                <td class="text-center">
                    <!-- Single button -->
                    <div class="btn-group" >
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="" data-toggle="modal" data-target="#viewModal_customer_peek" onclick="fun_peek_customer('.$customers->id.')" >Peek</a></li>
                            <li><a href="customers/'.$customers->id.'">View</a></li>
                            <li><a href="customers/'.$customers->id.'/edit">Edit</a></li>
                            <li><a href="customers/delete/'.$customers->id.'">Delete</a></li>
                            <li><a href="" data-toggle="modal" data-target="#addModal_refill" onclick="fun_get_id('.$customers->id.')">Refill</a></li>
                            <li><a href="" data-toggle="modal" data-target="#addModal_hint" onclick="fun_get_hint_id('.$customers->id.')">Hint</a></li>
                            <li><a href="" data-toggle="modal" data-target="#addModal_tower_ticket" onclick="fun_get_Ticket_id('.$customers->id.')">Ticket</a></li>
                        </ul>
                    </div>
                </td>
                ';
            })
            ->make(true);
    }



    public function CustomersTableTwoAjax()
    {
        $customer = Customer::with('tower','broadcast')->select('customers.*');
        return Datatables::of($customer)

            ->make(true);
    }

    public function Peek(Request $request)
    {
        if($request->ajax()){
            $id = $request->id;
            $info = Customer::with('address_helper')->find($id);
            //echo json_decode($info);
            return response()->json($info);
        }
    }

    public function create()
    {
        $customer           = Customer::all();
        $towers             = Tower::all();
        $broadcast          = Broadcast::all();
        $device             = Device::all();
        $address            = AddressHelper::all();
        $apmac              = Broadcast::all();
        return view('vendor.adminlte.pages.customer.new-customer' , compact('customer','device','towers','broadcast','address','apmac','connection_types'));
    }



    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname'       => 'required|max:30|unique:customers',
            'username'       => 'required|max:30|unique:customers',
            'password'       => 'max:10',
            'mobile_1'       => 'nullable|numeric|digits:11|unique:customers',
            'mobile_2'       => 'nullable|numeric|digits:11',
            'address_2'      => 'required|max:50',
            'about'          => 'nullable|max:50',
            'ip'             => 'nullable|ip|unique:customers'
        ]);

        if ($validator->fails()) {
            return redirect('isp-cpanel/customers/create')
                ->withErrors($validator)
                ->withInput();
        }else {

            // store
            $customer = new Customer;
            $customer->fullname           = $request->fullname;
            $customer->username           = $request->username;
                if($request->password == null) {
                    $customer->password           ='0000';
                }elseif ($request->password){
                    $customer->password           = $request->password;
                }
            $customer->mobile_1           = $request->mobile_1;
            $customer->mobile_2           = $request->mobile_2;
            $customer->address_1          = $request->address_1;
            $customer->address_2          = $request->address_2;
            $customer->about              = $request->about;
            $customer->mac                = $request->mac;
            $customer->ip                 = $request->ip;
            $customer->device_id          = $request->device_id;
            $customer->broadcast_id       = $request->broadcast_id;
            $customer->tower_id           = $request->tower_id;
            $customer->apmac_id           = $request->apmac_id;
            $customer->wireless_type_id   = $request->wireless_type_id;
            $customer->olt_id             = $request->olt_id;
            $customer->splitter_id        = $request->splitter_id;
            $customer->hub_id             = $request->hub_id;
            $customer->switch_port        = $request->switch_port;
            $customer->connection_method  = $request->connection_method;
            $customer->created_by         = Auth::User()->id;
            $customer->save();

            // redirect
            Session::flash('message','Successfuly Add ' . $customer->fullname. ' !' ) ;

            return redirect('isp-cpanel/customers');

        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tower              = Tower::all();
        $refills            = RefillCard::all();
        $broadcast          = Broadcast::all();
        $device             = Device::all();
        $apmac              = Broadcast::all();
        $ticket             = CustomerTicket::all();
        $customer           = Customer::find($id);
        return view('vendor.adminlte.pages.customer.view-customer' , compact('customer','device','tower','broadcast','apmac','ticket','user','fiberbox','fibernode','refills','hubs')) ;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $towers          = Tower::all();
        $hubs            = Hub::all();
        $address         = AddressHelper::all();
        $broadcasts      = Broadcast::all();
        $device          = Device::all();
        $apmac           = Broadcast::all();
        $olt             = Olt::all();
        $customer        = Customer::find($id);
        return view('vendor.adminlte.pages.customer.edit-customer' , compact('customer','device','towers','broadcasts','apmac','fiberbox','fibernode','address','olt','hubs')) ;
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
        $validator = Validator::make($request->all(), [
            'fullname'       => 'required|max:30|unique:customers,fullname,'. $id,
            'username'       => 'required|max:30|unique:customers,username,'. $id,
            'password'       => 'max:10',
            'mobile_1'       => 'nullable|numeric|digits:11|unique:customers,mobile_1,'. $id,
            'mobile_2'       => 'nullable|numeric|digits:11',
            'address_2'      => 'required|max:50',
            'about'          => 'nullable|max:50',
            'ip'             => 'nullable|ip|unique:customers,ip,'. $id,
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        } else {

            $customer = Customer::find($id);
            $customer->fullname           = $request->fullname;
            $customer->username           = $request->username;
                if($request->password == null) {
                    $customer->password           ='0000';
                }elseif ($request->password){
                    $customer->password           = $request->password;
                }
            $customer->mobile_1           = $request->mobile_1;
            $customer->mobile_2           = $request->mobile_2;
            $customer->address_1          = $request->address_1;
            $customer->address_2          = $request->address_2;
            $customer->about              = $request->about;
            $customer->mac                = $request->mac;
            $customer->ip                 = $request->ip;
            $customer->device_id          = $request->device_id;
            $customer->broadcast_id       = $request->broadcast_id;
            $customer->tower_id           = $request->tower_id;
            $customer->apmac_id           = $request->apmac_id;
            $customer->wireless_type_id   = $request->wireless_type_id;
            $customer->olt_id             = $request->olt_id;
            $customer->splitter_id        = $request->splitter_id;
            $customer->hub_id             = $request->hub_id;
            $customer->switch_port        = $request->switch_port;
            $customer->connection_method  = $request->connection_method;
            $customer->updated_by         = Auth::User()->id;
            $customer->save();
            Session::flash('message', 'Successfuly updated ' . '( ' . $customer->fullname . ' )' . ' ! ');
            return redirect('isp-cpanel/customers');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $customer = Customer::find($id);
        $customer->destroy($id);
        Session::flash('message','Successfuly deleted ' . $customer->fullname.' !');
        return back();
    }


}
