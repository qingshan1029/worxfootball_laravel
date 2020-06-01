@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.booking.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.payments.store") }}" enctype="multipart/form-data">
                @csrf
            <div class='row'>
                <div class='col-md-4'></div>
                <div class='col-md-4'>
                        <div class='form-row'>
                            <div class='col-lg-8 form-group'>
                                <label class='control-label'>Player ID</label> <input
                                    class='form-control' type='number' name="player_id" required>
                            </div>
                            <div class='col-lg-4 form-group'>
                                <label class='control-label'>Match ID</label> <input
                                    class='form-control' type='number' name="match_id" required>
                            </div>
                        </div>
                        <div class='form-row'>
                            <div class='col-lg-4 form-group'>
                                <label class='control-label'>Name on Card</label> <input
                                    class='form-control' type='text' name="card_name" required>
                            </div>

                            <div class='col-lg-8 form-group '>
                                <label class='control-label'>Card Number</label> <input
                                    autocomplete='off' class='form-control card-number' size='20'
                                    type='text' name="card_number" required>
                            </div>
                        </div>

                        <div class='form-row'>
                            <div class='col-lg-4 form-group cvc'>
                                <label class='control-label'>CVC</label> <input
                                    autocomplete='off' class='form-control card-cvc'
                                    placeholder='ex. 311' type='text' name="card_cvc" required>
                            </div>
                            <div class='col-lg-4 form-group expiration'>
                                <label class='control-label'>Expiration(Month)</label> <input
                                    class='form-control card-expiry-month' placeholder='MM'
                                    type='text' name="card_month" required>
                            </div>
                            <div class='col-lg-4 form-group expiration'>
                                <label class='control-label'>Expiration(Year)</label> <input
                                    class='form-control card-expiry-year' placeholder='YYYY'
                                    type='text' name="card_year" required>
                            </div>
                        </div>
                        <div class='form-row'>
                            <div class="col-md-5">
                                <label class='control-label'>GBP</label><input
                                    class='form-control' size='4' type='number' name="amount" required>
                            </div>
                       </div>
                        <div class='form-row mt-5' style="margin-bottom: 100px">
                            <div class='col-md-12 form-group'>
                                <button class='form-control btn btn-primary submit-button'
                                        type='submit' style="margin-top: 10px;">Pay »</button>
                            </div>
                        </div>
                </div>
                <div class='col-md-4'></div>
            </div>
        </form>
    </div>
</div>
@endsection
