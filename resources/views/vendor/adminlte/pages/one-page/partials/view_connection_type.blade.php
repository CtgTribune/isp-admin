@if ($message = Session::get('success'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
@endif
<button type="button" class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#addModal">Add new Connection Type</button>
<br>
<br>
<div class="box-bod" >
    <table id="data" class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Connection Type</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $x)
            <tr>
                <td>{{$x -> connection_types}}</td>
                <td>
                    <button class="btn btn-info" data-toggle="modal" data-target="#viewModal" onclick="fun_view('{{$x -> id}}')">View</button>
                    <button class="btn btn-warning" data-toggle="modal" data-target="#editModal" onclick="fun_edit('{{$x -> id}}')">Edit</button>
                    <button class="btn btn-danger" onclick="fun_delete('{{$x -> id}}')">Delete</button>
                </td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th>connection type</th>
            <th>Actions</th>
        </tr>
        </tfoot>
    </table>
</div>
<input type="hidden" name="hidden_view" id="hidden_view" value="{{url('isp-cpanel/settings/connection_types/view')}}">
<input type="hidden" name="hidden_delete" id="hidden_delete" value="{{url('isp-cpanel/settings/connection_types/delete')}}">
<!-- Add Modal start -->
<div class="modal fade" id="addModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Connection Type</h4>
            </div>

            <div class="modal-body">
                <form action="{{ url('isp-cpanel/settings/connection_types') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <div class="box-body">
                            <div class="form-group">
                                Example ..
                                <lo>
                                    <li>fiber</li>
                                    <li>wireless 2.4</li>
                                    <li>LAN Cable</li>
                                </lo>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="connection_types">Connection Type:</label>
                            <input type="text" class="form-control" id="connection_types" name="connection_types">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-info">this new Connection Type</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<!-- add code ends -->

<!-- View Modal start -->
<div class="modal fade" id="viewModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">View this Connection Type </h4>
            </div>
            <div class="modal-body">
                <p><b>Connection Type : </b><h3><span id="view_connection_types" class="text-success"></span></h3></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Dismiss</button>
            </div>
        </div>
    </div>
</div>
<!-- view modal ends -->

<!-- Edit Modal start -->
<div class="modal fade" id="editModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit this Connection Type</h4>
            </div>
            <div class="modal-body">
                <form action="{{ url('isp-cpanel/settings/connection_types/update') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <div class="form-group">
                            <label for="edit_connection_types">Connection Type :</label>
                            <input type="text" class="form-control" id="edit_connection_types" name="edit_connection_types">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-default">Update</button>
                    <input type="hidden" id="edit_id" name="edit_id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
