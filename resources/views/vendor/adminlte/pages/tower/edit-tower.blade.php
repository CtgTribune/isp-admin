@extends('adminlte::layouts.app')


@section('htmlheader_title')
@endsection


@section('contentheader_title')
@endsection


@section('contentheader_description')
@endsection


@section('page-name')
@endsection


@section('main-content')
    @include('adminlte::layouts.partials.pageheader')

    {!! Form::open(['action'=>'TowerController@store']) !!}
    {{ csrf_field() }}

    <div>
        <div class="box-body">
            <label><div class="fa fa-info-circle"></div>   Tower information</label>
            <br>
            <br>
            <div  class="col-lg-2 form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label><div for="name" class="glyphicon glyphicon-info-sign control-label" ></div> Tower Name</label>
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Enter the  Name" >
                @if ($errors->has('name'))
                    <span  class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                @endif
            </div>

            <div class="col-lg-2">
                <div class="form-group">
                    <label><div class="fa fa-home"></div> Address</label>
                    <select name="location" class="form-control" >
                        @foreach ($address as $address) {
                        <option value="{!! $address->id !!}" >{!! $address->place_1 !!}</option>
                        }
                        @endforeach
                    </select>
                </div>
            </div>

            <div  class="col-lg-3 form-group{{ $errors->has('google_location') ? ' has-error' : '' }}">
                <label><div for="google_location" class="glyphicon glyphicon-map-marker control-label" ></div> google_location</label>
                <input id="google_location" type="text" class="form-control" name="google_location" value="{{ old('google_location') }}"  >
                @if ($errors->has('google_location'))
                    <span  class="help-block">
                                            <strong>{{ $errors->first('google_location') }}</strong>
                                        </span>
                @endif
            </div>

            <div  class="col-lg-12 form-group{{ $errors->has('tower_info') ? ' has-error' : '' }}">
                <label><div for="tower_info" class="fa fa-info-circle control-label" ></div> Tower Information</label>
                <input id="tower_info" type="text" class="form-control" name="tower_info" value="{{ old('tower_info') }}">
                @if ($errors->has('tower_info'))
                    <span class="help-block">
                                                <strong>{{ $errors->first('tower_info') }}</strong>
                                            </span>
                @endif
            </div>



        </div>

        <div class="panel-body">
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="save" name="save">
            </div>
        </div>

    </div>

    {!! Form::close() !!}

    @include('adminlte::layouts.partials.pagefooter')
@endsection


@section('page-scripts')
@endsection