@extends('layouts.dashboard')

@section('style')
<style>
    .StripeElement {
        box-sizing: border-box;

        height: 40px;

        padding: 10px 12px;

        border: 1px solid transparent;
        border-radius: 4px;
        background-color: white;

        box-shadow: 0 1px 3px 0 #e6ebf1;
        -webkit-transition: box-shadow 150ms ease;
        transition: box-shadow 150ms ease;
    }

    .StripeElement--focus {
        box-shadow: 0 1px 3px 0 #cfd7df;
    }

    .StripeElement--invalid {
        border-color: #fa755a;
    }

    .StripeElement--webkit-autofill {
        background-color: #fefde5 !important;
    }

</style>
@endsection

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

            <!-- select -->
            <div class="form-group{{ $errors->has('gym_id') ? 'has-error' : '' }}">
                <label>Select Gym</label>
                <select class="form-control" name="gym_id" readonly>
                    <option value="{{$gym->id}}">{{$gym->name}}</option>
                </select>
                @if ($errors->has('gym_id'))
                <span class="help-block" role="alert">
                    <strong>{{ $errors->first('gym_id') }}</strong>
                </span>
                @endif
            </div>

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


            <!-- <div class="form-row"> -->
            <!-- <label for="card-element">
                Credit or debit card
            </label>
            <div id="card-element">-->
            <!-- A Stripe Element will be inserted here. -->
            <!-- </div>  -->

            <div class="row form-group">
                <div class="form-group col-xs-6">
                    <label class='control-label'>Card Number</label>
                    <input autocomplete='off' class='form-control card-number'size='20' type='text' name="card_no">
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
                        <input autocomplete='off' class='form-control card-cvc' size='4'
                            type='text' name="cvv">
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
                        <input class='form-control card-expiry-month' size='4' type='text'
                            name="expiry_month">
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

                        <input class='form-control card-expiry-year' size='4' type='text'name="expiry_year">
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
<!-- <script src="https://js.stripe.com/v3/"></script>
<script>
    // Create a Stripe client.
    var stripe = Stripe('pk_test_5ZlU021zZ5BBzPRV44stQu6v00q0sYmjdU');

    // Create an instance of Elements.
    var elements = stripe.elements();

    // Custom styling can be passed to options when creating an Element.
    // (Note that this demo uses a wider set of styles than the guide below.)
    var style = {
        base: {
            color: '#32325d',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };

    // Create an instance of the card Element.
    var card = elements.create('card', {
        style: style
    });

    // Add an instance of the card Element into the `card-element` <div>.
    card.mount('#card-element');

    // Handle real-time validation errors from the card Element.
    card.addEventListener('change', function (event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    // Handle form submission.
    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function (event) {
        event.preventDefault();

        stripe.createToken(card).then(function (result) {
            if (result.error) {
                // Inform the user if there was an error.
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
            } else {
                // Send the token to your server.
                stripeTokenHandler(result.token);
            }
        });
    });

    // Submit the form with the token ID.
    function stripeTokenHandler(token) {
        // Insert the token ID into the form so it gets submitted to the server
        var form = document.getElementById('payment-form');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);

        // Submit the form
        form.submit();
    }

</script> -->
@endsection
