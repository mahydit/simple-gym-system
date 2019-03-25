@extends('layouts.dashboard')

@section('content')
 <!-- ./col -->
 <div class="content">
          <div class="box box-solid callout callout-info">
            <div class="box-header with-border">
              <i class="fa fa-text-width"></i>

              <h3 class="box-title">{{$session->name}}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <dl class="dl-horizontal">
                <dt>Session date</dt>
                <dd>{{date(' \o\n l jS F Y ', strtotime($session->session_date))}}</dd>
                <dt>Session starts at</dt>
                <dd>{{date('g:ia', strtotime($session->starts_at))}}</dd>
                <dt>Session ends at</dt>
                <dd>{{date('g:ia', strtotime($session->ends_at))}}</dd>
                <dt>Gym</dt>
                <dd>{{$gym->name}}</dd>
                <dt>Coaches</dt>
                @foreach($coaches as $coach)
                <dd>{{$coach->name}}</dd>
                @endforeach
              </dl>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
@endsection