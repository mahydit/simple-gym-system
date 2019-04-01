@extends('layouts.dashboard')

@section('content')

<!-- general form elements disabled -->
<div class="box box-warning">
    <div class="box-header with-border">
        <h3 class="box-title">Buy Package</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <form action="{{route('purchases.store')}}" method="POST" id="payment-form">
            @csrf

            @hasrole('admin')
            <div class="box-body">
            <div class="form-group">
                <label>City</label>
                <select class="form-control dynamic" name="city_id" id="city_id" data-dependent="gym">
                    <option disabled  selected value="">Select City</option>
                    @foreach ($cities as $city)
                        <option value="{{$city->id}}">{{$city->name}}</option>
                    @endforeach
                </select>
            </div>
        
            <div class="form-group{{ $errors->has('gym_id') ? 'has-error' : '' }}">
                <label>Gym</label>
                <select class="form-control" name="gym_id" id="gym">
                   <option disabled selected>Select Gym </option>
                </select>
                @if ($errors->has('gym_id'))
                <span class="help-block" role="alert">
                    <strong>{{ $errors->first('gym_id') }}</strong>
                </span>
                @endif
            </div>
        </div>
            @endrole

            @hasrole('citymanager')

            <div class="form-group">
                <label>Select City</label>
                <select class="form-control" name="city_id" readonly>
                    <option value="{{$cities->id}}">{{$cities->name}}</option>
                </select>
            </div>

            <!-- select -->
            <div class="form-group{{ $errors->has('gym_id') ? 'has-error' : '' }}">
                <label>Select Gym</label>
                <select class="form-control" name="gym_id">
                    @foreach($gyms as $gym)
                    <option value="{{$gym->id}}">{{$gym->name}}</option>
                    @endforeach
                </select>
                @if ($errors->has('gym_id'))
                <span class="help-block" role="alert">
                    <strong>{{ $errors->first('gym_id') }}</strong>
                </span>
                @endif
            </div>
            @endhasrole

            @hasrole('gymmanager')
            <!-- select -->
            <div class="form-group{{ $errors->has('gym_id') ? 'has-error' : '' }}">
                <label>Select Gym</label>
                <select class="form-control" name="gym_id" readonly>
                    <option value="{{$gyms->id}}">{{$gyms->name}}</option>
                </select>
                @if ($errors->has('gym_id'))
                <span class="help-block" role="alert">
                    <strong>{{ $errors->first('gym_id') }}</strong>
                </span>
                @endif
            </div>
            @endhasrole

            <div class="form-group{{ $errors->has('user_id') ? 'has-error' : '' }}">
                <label>Select User </label>
                <select class="form-control" name="user_id">
                    @foreach($users as $user)
                    <option value="{{$user->id}}">{{$user->name}}</option>
                    @endforeach
                </select>
                @if ($errors->has('user_id'))
                <span class="help-block" role="alert">
                    <strong>{{ $errors->first('user_id') }}</strong>
                </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('package_id') ? 'has-error' : '' }}">
                <label>Select Package </label>
                <select class="form-control" name="package_id">
                    @foreach($packages as $package)
                    <option value="{{$package->id}}">{{$package->name}} - {{$package->price}}$</option>
                    @endforeach
                </select>
                @if ($errors->has('package_id'))
                <span class="help-block" role="alert">
                    <strong>{{ $errors->first('package_id') }}</strong>
                </span>
                @endif
            </div>

            <div class="row form-group">
                <div class="form-group col-xs-6">
                    <label class='control-label'>Card Number</label>
                    <input autocomplete='off' class='form-control card-number' size='20' type='text' name="card_no">
                    @if ($errors->has('card_no'))
                    <div class="alert alert-danger" style="margin: 4px;">
                        <ul style="list-style: none;">
                            <li>{{ $errors->first('card_no')}}</li>
                        </ul>
                    </div>
                    @endif
                </div>




                <div class='col-xs-2 form-group cvc required'>

                    <label class='control-label'>CVV (ex. 311)</label>
                    <input autocomplete='off' class='form-control card-cvc' size='4' type='text' name="cvv">
                    @if ($errors->has('cvv'))
                    <div class="alert alert-danger" style="margin: 4px;">
                        <ul style="list-style: none;">
                            <li>{{ $errors->first('cvv')}}</li>
                        </ul>
                    </div>
                    @endif
                </div>

                <div class='col-xs-2 form-group expiration'>
                    <label class='control-label'>Expiration Month (MM)</label>
                    <input class='form-control card-expiry-month' size='4' type='text' name="expiry_month">
                    @if ($errors->has('expiry_month'))
                    <div class="alert alert-danger" style="margin: 4px;">
                        <ul style="list-style: none;">
                            <li>{{ $errors->first('expiry_month')}}</li>
                        </ul>
                    </div>
                    @endif
                </div>

                <div class='col-xs-2 form-group expiration'>

                    <label class='control-label'>Expiration Year (YYYY)</label>

                    <input class='form-control card-expiry-year' size='4' type='text' name="expiry_year">
                    @if ($errors->has('expiry_year'))
                    <div class="alert alert-danger" style="margin: 4px;">
                        <ul style="list-style: none;">
                            <li>{{ $errors->first('expiry_year')}}</li>
                        </ul>
                    </div>
                    @endif

                </div>
            </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-primary">Buy</button>
            </div>
        </form>
    </div>

    <!-- /.box-body -->
</div>
<!-- /.box -->
@endsection

@section('plugins')
<!-- jQuery 3 -->
<script src="{{ asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
@endsection

@section('script')
<script>
       $(document).ready(function() {
        $('.dynamic').change(function () {
            if ($(this).val() != '') {
                var select = $(this).attr("id");
                var value = $(this).val();
                var dependent = $(this).data('dependent');
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('dynamicdependentPurchase.fetch') }}",
                    method: "POST",
                    data: {select: select, value: value, _token: _token, dependent: dependent},
                    success: function (result) {
                        console.log(result);
                        $('#' + dependent).html(result);
                    },
                    error: function (respose) {
                        alert(' error');
                        console.log(respose);
                    }
                })
            }
        });
        $('#city_id').change(function(){
            $('#gym').val('');
        });
    });
</script>
@endsection