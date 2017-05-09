<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
    $(function() {
        $("#wireless").hide();
        $("#fttx").hide();
        $("#lan").hide();
        var value = $('#v').val();
        if(value == 0) {
            $("#fttx").hide();
            $("#wireless").hide();
            $("#lan").hide();
        }else if (value == 1){
            $("#wireless").show();
            $("#fttx").hide();
            $("#lan").hide();
        }else if (value == 2){
            $("#fiber").hide();
            $("#wireless").hide();
            $("#lan").show();
        }else if (value == 3){
            $("#fttx").show();
            $("#wireless").hide();
            $("#lan").hide();
        }
    });
</script>
<div class="box-body">
    <div  class="col-lg-3 form-group">
        <label><div class="fa fa-user"></div> Full Name</label>
        <input type="text" class="form-control" value="{{ $customer->fullname }}" disabled >
    </div>
    <div  class="col-lg-3 form-group">
        <label><div class="fa fa-user-plus"></div> PPPOE User</label>
        <input type="text" class="form-control" value="{{ $customer->username }}" disabled >
    </div>
    <div  class="col-lg-2 form-group">
        <label><div class="fa fa-unlock"></div> Password</label>
        <input type="text" class="form-control" value="{{ $customer->password }}" disabled >
    </div>
    <div  class="col-lg-2 form-group">
        <label><div class="fa fa-phone"></div> Mobile</label>
        <input type="text" class="form-control" value="{{ $customer->mobile_1 }}" disabled >
    </div>
    <div  class="col-lg-2 form-group">
        <label><div class="fa fa-phone" ></div> Other Mobile</label>
        <input type="text" class="form-control" value="{{ $customer->mobile_2 }}" disabled >
    </div>
    <div  class="col-lg-3 form-group">
        <label><div class="fa fa-home"></div> Adress</label>
        <input type="text" class="form-control" value="" disabled >
    </div>
    <div  class="col-lg-3 form-group">
        <label><div class="fa fa-home"></div> About the address</label>
        <input type="text" class="form-control" value="{{ $customer->address_2 }}" disabled >
    </div>
    <div  class="col-lg-6 form-group">
        <label><div class="fa fa-home"></div> More Information</label>
        <input type="text" class="form-control" value="{{ $customer->about }}" disabled >
    </div>
    @if($customer->Device)
    <div  class="col-lg-3 form-group">
        <label><div class="fa fa-gears"></div> Station Type</label>
        <input type="text" class="form-control" value="{{ $customer->Device->brand_model }}" disabled >
    </div>
    @endif
    <div  class="col-lg-3 form-group">
        <label><div class="fa fa-barcode"></div> MAC Address</label>
        <input type="text" class="form-control" value="{{ $customer->mac }}" disabled >
    </div>
    <div  class="col-lg-3 form-group">
        <label><div class="fa fa-sitemap"></div> IP Address</label>
        <input type="text" class="form-control" value="{{ $customer->ip }}" disabled >
    </div>
    @if($customer->connectionMmethod)
    <div  class="col-lg-3 form-group">
        <label><div class="fa fa-sitemap"></div> Connection Method :</label>
        <input type="text" class="form-control"  value="{{ $customer->connectionMmethod->method }}" disabled >
    </div>
    @endif
        <input id="v" value="{{ $customer->connection_method }}" hidden>

</div>
<hr>
<div class="box-body" id="wireless">
    @if($customer->tower)
    <div  class="col-lg-3 form-group">
        <label><div class="fa fa-wifi"></div> point / Tower</label>
        <input  type="text" class="form-control" value="{{ $customer->towerName->name }}" disabled >
    </div>
    @endif
    @if($customer->BroadcastSSID)
    <div  class="col-lg-3 form-group">
        <label><div class="fa fa-wifi"></div> Broadcast SSID</label>
        <input type="text" class="form-control"  value="{{ $customer->BroadcastSSID->ssid }}" disabled >
    </div>
    @endif
    @if($customer->BroadcastMAC)
    <div  class="col-lg-3 form-group">
        <label><div class="fa fa-wifi"></div> Broadcast AP MAC</label>
        <input type="text" class="form-control"  value="{{ $customer->BroadcastMAC->mac }}" disabled >
    </div>
    @endif
    @if($customer->wirelessType)
    <div  class="col-lg-3 form-group">
        <label><div class="fa fa-wifi"></div> Wireless Method</label>
        <input type="text" class="form-control"  value="{{ $customer->wirelessType->type }}" disabled >
    </div>
    @endif
</div>

<div class="box-body" id="fttx">
    @if($customer->tower)
    <div  class="col-lg-4 form-group">
        <label><div class="fa fa-wifi"></div> OLT No. & Location</label>
        <input  type="text" class="form-control" value="{{ $customer->tower->name }}" disabled >
    </div>
    @endif
    <div  class="col-lg-4 form-group">
        <label><div class="fa fa-wifi"></div> First Splitter No. & Location</label>
        <input type="text" class="form-control"  value="" disabled >
    </div>
    <div  class="col-lg-4 form-group">
        <label><div class="fa fa-wifi"></div> Second Splitter No. & Location</label>
        <input type="text" class="form-control"  value="" disabled >
    </div>
</div>

<div class="box-body" id="lan">
    <div  class="col-lg-4 form-group">
        <label><div class="fa fa-wifi"></div> Hub Switch</label>
        <input  type="text" class="form-control" value="" disabled >
    </div>
    <div  class="col-lg-4 form-group">
        <label><div class="fa fa-wifi"></div> Port Number</label>
        <input type="text" class="form-control"  value="" disabled >
    </div>
</div>
<hr>
<div class="box-body" id="lan">
    <div  class="col-lg-3 form-group">
        <label><div class="fa fa-wifi"></div> Last Dibet</label>
        <input  type="text" class="form-control" value="232323" disabled >
    </div>
    <div  class="col-lg-3 form-group">
        <label><div class="fa fa-wifi"></div> Balance</label>
        <input type="text" class="form-control"  value="2323232" disabled >
    </div>
    <div  class="col-lg-3 form-group">
        <label><div class="fa fa-wifi"></div> Balance</label>
        <input type="text" class="form-control"  value="4432" disabled >
    </div>
    <div  class="col-lg-3 form-group">
        <label><div class="fa fa-wifi"></div> Balance</label>
        <input type="text" class="form-control"  value="643234" disabled >
    </div>
</div>
<hr>
<div class="box-body">
    <div  class="col-lg-3 form-group">
        <label><div class="fa fa-calendar-times-o"></div> Add Date</label>
        <input type="text" class="form-control" value="{{ $customer->created_at->format('(D g:i A)    d-n-Y') }}" disabled >
    </div>
    <div  class="col-lg-3 form-group">
        <label><div class="fa  fa-user-secret"></div> Add by</label>
        <input type="text" class="form-control" value="{{ $customer->userCreated->name}}" disabled >
    </div>
    @if ($customer->updated_at != $customer->created_at)
    <div  class="col-lg-3 form-group">
        <label><div class="fa fa-calendar-times-o"></div> Last Update at</label>
        <input type="text" class="form-control" value="{{ $customer->updated_at->format('(D g:i A)    d-n-Y') }}" disabled >
    </div>
    @endif
    @if ($customer->updated_by)
    <div  class="col-lg-3 form-group">
        <label><div class="fa  fa-user-secret"></div> Last Update by</label>
        <input type="text" class="form-control" value="{{ $customer->userUpdated->name}}" disabled >
    </div>
    @endif
</div>
<hr>
