@extends('layouts.app')

@section('content')
    
    <div class="my-content-wrapper">
        <div class="content-container">
            <div class="row salesWrap">
                {{-- MODAL TRIGGER --}}
                <a href="#addSaleDialog" class="addSaleBtn hide-on-small-only-old modal-trigger btn-floating btn-large waves-effect waves-light red darken-2"><i class="material-icons">add</i></a>
                {{-- MODAL BODY --}}
                <div id="addSaleDialog" class="modal modal-fixed-footer">
                    <form action="{{ url('storeSales') }}" method="post" name="addSalesForm" class="addSalesForm">
                        <div class="modal-content">
                            <h5>New Money Transfer</h5>
                                @csrf
                                <input type="hidden" name="transferTransaction">
                                <div class="row">
                                    <div class="input-field col s12 m4 l4">
                                        <input id="firstname" name="firstname" type="text">
                                        @if ($errors->has('firstname'))
                                            <span class="helper-text red-text" >
                                                <strong>{{ $errors->first('firstname') }}</strong>
                                            </span>
                                        @endif
                                        <label for="firstname">Depositor's Firstname</label>
                                    </div>
                                    <div class="input-field col s12 m4 l4">
                                        <input id="lastname" name="lastname" type="text">
                                        @if ($errors->has('lastname'))
                                            <span class="helper-text red-text" >
                                                <strong>{{ $errors->first('lastname') }}</strong>
                                            </span>
                                        @endif
                                        <label for="lastname">Depositor's Lastname</label>
                                    </div>
                                    <div class="input-field col s12 m4 l4">
                                        <input id="phone" name="phone" type="text">
                                        @if ($errors->has('phone'))
                                            <span class="helper-text red-text" >
                                                <strong>{{ $errors->first('phone') }}</strong>
                                            </span>
                                        @endif
                                        <label for="phone">Depositor's Phone</label>
                                    </div>
                                    <div class="input-field col s12 m12 l12">
                                        <i class="material-icons prefix">place</i>
                                        <textarea id="location" name="location" class="materialize-textarea"></textarea>
                                        @if ($errors->has('location'))
                                            <span class="helper-text red-text" >
                                                <strong>{{ $errors->first('location') }}</strong>
                                            </span>
                                        @endif
                                        <label for="location"> Depositor's Address</label>
                                    </div>
                                </div>

                                <fieldset style="border:2px solid #ccc;">
                                    <legend style="padding:4px 8px; border:2px solid #ccc;">Recievers Details</legend>
                                    <div class="row">
                                        <div class="input-field col s12 m4 l4">
                                            <input id="recievers_firstname" name="recievers_firstname" type="text">
                                            @if ($errors->has('recievers_firstname'))
                                                <span class="helper-text red-text" >
                                                    <strong>{{ $errors->first('recievers_firstname') }}</strong>
                                                </span>
                                            @endif
                                            <label for="recievers_firstname">Reciever's Firstname</label>
                                        </div>
                                        <div class="input-field col s12 m4 l4">
                                            <input id="recievers_lastname" name="recievers_lastname" type="text">
                                            @if ($errors->has('recievers_lastname'))
                                                <span class="helper-text red-text" >
                                                    <strong>{{ $errors->first('recievers_lastname') }}</strong>
                                                </span>
                                            @endif
                                            <label for="recievers_lastname">Reciever's Lastname</label>
                                        </div>
                                        <div class="input-field col s12 m4 l4">
                                            <input id="recievers_phone" name="recievers_phone" type="text">
                                            @if ($errors->has('recievers_phone'))
                                                <span class="helper-text red-text" >
                                                    <strong>{{ $errors->first('recievers_phone') }}</strong>
                                                </span>
                                            @endif
                                            <label for="recievers_phone">Reciever's Phone</label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="input-field col s12 m4 l4">
                                            <input id="bankName" name="bankName" type="text">
                                            @if ($errors->has('bankName'))
                                                <span class="helper-text red-text" >
                                                    <strong>{{ $errors->first('bankName') }}</strong>
                                                </span>
                                            @endif
                                            <label for="bankName">Bank Name</label>
                                        </div>
                                        <div class="input-field col s12 m4 l4">
                                            <input id="accountType" name="accountType" type="text">
                                            @if ($errors->has('accountType'))
                                                <span class="helper-text red-text" >
                                                    <strong>{{ $errors->first('accountType') }}</strong>
                                                </span>
                                            @endif
                                            <label for="accountType">Account Type</label>
                                        </div>
                                        <div class="input-field col s12 m4 l4">
                                            <input id="accountNumber" name="accountNumber" type="number">
                                            @if ($errors->has('accountNumber'))
                                                <span class="helper-text red-text" >
                                                    <strong>{{ $errors->first('accountNumber') }}</strong>
                                                </span>
                                            @endif
                                            <label for="accountNumber">Account Number</label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="input-field col s12 m3 l3">
                                            <input id="amount" name="amount" type="number">
                                            @if ($errors->has('amount'))
                                                <span class="helper-text red-text" >
                                                    <strong>{{ $errors->first('amount') }}</strong>
                                                </span>
                                            @endif
                                            <label for="amount">Amount (₦)</label>
                                        </div>
                                        <div class="input-field col s12 m6 l6">
                                            <i class="material-icons prefix">place</i>
                                            <textarea id="amountInWords" name="amountInWords" class="materialize-textarea"></textarea>
                                            @if ($errors->has('amountInWords'))
                                                <span class="helper-text red-text" >
                                                    <strong>{{ $errors->first('amountInWords') }}</strong>
                                                </span>
                                            @endif
                                            <label for="amountInWords">Amount in words</label>
                                        </div>
                                        <div class="input-field col s12 m3 l3">
                                            <input id="charge" name="charge" type="number">
                                            @if ($errors->has('charge'))
                                                <span class="helper-text red-text" >
                                                    <strong>{{ $errors->first('charge') }}</strong>
                                                </span>
                                            @endif
                                            <label for="charge">Charge (₦)</label>
                                        </div>
                                    </div>
                                </fieldset>
                            
                        </div>
                        <div class="modal-footer btnWrap" style="display:flex; justify-content:flex-end;">
                                <button id="addSalesBtn" class="addSaleSubmitBtn btn waves-effect waves-light" type="submit">Submit
                                    <i class="material-icons right">send</i>
                                </button>
                                    {{-- SPINNER --}}
                                @include('components.submitPreloader')
                        </div>
                    </form>
                </div>

                {{-- SALES HEADING --}}
                <h5 class="center salesHeading">Transfer Records</h5>

                {{-- SALES TABLE --}}
                <div class="salesTableWrap col s12">
                    <div class="salesTable col s12">
                        <table class="highlight centered responsive-table">
                            <thead>
                                <tr>
                                    <th>Depositor</th>
                                    <th>Reciever</th>
                                    <th>Bank</th>
                                    <th>Acc. Type</th>
                                    <th>Acc. Number.</th>
                                    <th>Amount</th>
                                    <th>Charge</th>
                                    <th>Status</th>
                                    <th>Time</th>
                                    <th>Reciept</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                            @foreach ($data['salesDetails'] as $sale)
                                <tr>
                                    <td>{{ $sale->firstname }} {{ $sale->lastname  }}</td>
                                    <td>{{ $sale->firstname }} {{ $sale->lastname  }}</td>
                                    <td>{{ $sale->productOrService }}</td>
                                    <td>{{ $sale->productOrService }}</td>
                                    <td>{{ $sale->productOrService }}</td>
                                    <td>₦{{ $sale->amount }}</td>
                                    <td>{{ $sale->productOrService }}</td>
                                    <td>{{ Carbon\Carbon::parse($sale->created_at)->diffForHumans() }}</td>
                                    <td><a class="recieptBtn" data-salesId="{{ $sale->id }}" href="#"><i class="material-icons">receipt</i></a></td>
                                    <td>
                                        <a class="delete deleteSale" href="#delete" data-salesId="{{ $sale->id }}">
                                            <i class="tiny material-icons">close</i>
                                        </a>
                                    </td>
                                    <td>
                                        <a class="delete deleteSale" href="#delete" data-salesId="{{ $sale->id }}">
                                            <i class="tiny material-icons">question_mark</i>
                                        </a>
                                    </td>

                                    {{-- CLEAR OUTSTANDING FORM --}}
                                    <form action="" method="post" id="clearOutstandingForm">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="salesId">
                                    </form>

                                    {{-- DELETE SALES FORM --}}
                                    <form action="" method="post" id="deleteSaleForm">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="saleId">
                                    </form>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        
                    </div>
                    <div class="col s12" style="padding:0;">
                        {{$data['salesDetails']->links('vendor.pagination.materializecss')}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
