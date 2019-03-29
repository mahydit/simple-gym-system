@extends('layouts.dashboard')

@section('content')
<div class="box">
    <div class="box-header with-border">
        @hasrole('gymmanager')
        <h3 class="box-title">{{$gym->name}}</h3>
        @endhasrole

        @hasrole('citymanager')
        <h3 class="box-title">{{$city->name}}</h3>
        @endhasrole

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                title="Collapse">
                <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                <i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="row box-body ">
        <div class="col col-lg-8 ">

            @hasrole('gymmanager')
            <b>Created at</b>
            <p>{{$gym->created_at}}</p>
            <b>Created by</b>
            <p>{{$gym->created_by}}</p>
            @endhasrole

            @hasrole('citymanager')
            <b>Country</b>
            <p>{{$city->country->name}}</p>
            @endhasrole

            @hasrole('admin')
            <!-- TODO: Add some data here -->
            @endhasrole
        </div>
        <div class="col col-lg-4">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{$revenue}}</h3>

                    @hasrole('gymmanager')
                    <p>{{$gym->name}}</p>
                    @endhasrole

                    @hasrole('citymanager')
                    <p>{{$city->name}}</p>
                    @endhasrole

                    @hasrole('admin')
                    <p>Gym System</p>
                    @endhasrole
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
            </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
        </div>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->

<!-- small box -->

@endsection

@section('plugins')
<!-- jQuery 3 -->
<script src="{{ asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
@endsection
