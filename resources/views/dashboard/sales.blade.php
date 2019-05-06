@extends('layouts.app')

@section('content')

    <div class="my-content-wrapper">
        <div class="content-container">
            <div class="row salesWrap">
                {{-- MODAL TRIGGER --}}
                <a href="#addSaleDialog" class="addSaleBtn hide-on-small-only-old modal-trigger btn-floating btn-large waves-effect waves-light red darken-2"><i class="material-icons">add</i></a>
                {{-- MODAL BODY --}}
                <div id="addSaleDialog" class="modal">
                    <div class="modal-content">
                        <h5>New Transaction</h5>
                        <form action="{{ url('storeSales') }}" method="post" name="addSalesForm" class="addSalesForm">
                            @csrf
                            <div class="row">
                                <div class="input-field col s12 m4 l4 switch">
                                    <label>
                                    Service
                                    <input type="checkbox" name="type" class="type">
                                    <span class="lever"></span>
                                    Product
                                    </label>
                                </div>
                                <div class="input-field col s12 m4 l4">
                                    <input id="firstname" name="firstname" type="text" class="validate">
                                    @if ($errors->has('firstname'))
                                        <span class="helper-text red-text" >
                                            <strong>{{ $errors->first('firstname') }}</strong>
                                        </span>
                                    @endif
                                    <label for="firstname">Customer Firstname</label>
                                </div>
                                <div class="input-field col s12 m4 l4">
                                    <input id="lastname" name="lastname" type="text" class="validate">
                                    @if ($errors->has('lastname'))
                                        <span class="helper-text red-text" >
                                            <strong>{{ $errors->first('lastname') }}</strong>
                                        </span>
                                    @endif
                                    <label for="lastname">Customer Lastname</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12 m4 l4">
                                    <input id="phone" name="phone" type="text" class="validate">
                                    @if ($errors->has('phone'))
                                        <span class="helper-text red-text" >
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                    @endif
                                    <label for="phone">Customer Phone</label>
                                </div>
                                <div class="input-field col s12 m4 l4">
                                    <i class="material-icons prefix">place</i>
                                    <textarea id="location" name="location" class="materialize-textarea"></textarea>
                                    @if ($errors->has('location'))
                                        <span class="helper-text red-text" >
                                            <strong>{{ $errors->first('location') }}</strong>
                                        </span>
                                    @endif
                                    <label for="location">Location</label>
                                </div>
                                <div class="input-field col s12 m4 l4">
                                    <input id="productOrService" name="productOrService" type="text" class="autocomplete validate">
                                    @if($data['stockDetails'] !== '')
                                        <script>
                                            // AUTO COMPLETE
                                            const data = '{!! $data['stockDetails'] !!}';
                                            var items = $.parseJSON(data);
                                            
                                            let result = {} 
                                            items.forEach(i => { result[i.item] = [i.unitPrice] })
                                            $('input.autocomplete').autocomplete({
                                                data: result,
                                                limit: 3,
                                                onAutocomplete: function(opt){
                                                    $('#amount').prop("disabled", true);
                                                    $('#balance').prop("readonly", true);
                                                    $('#change').prop("readonly", true);
                                                }
                                            });
                                        </script>
                                    @endif
                                    @if ($errors->has('productOrService'))
                                        <span class="helper-text red-text" >
                                            <strong>{{ $errors->first('productOrService') }}</strong>
                                        </span>
                                    @endif
                                    <label for="productOrService">Product/Service offered</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12 m3 l3">
                                    <input id="units" name="units" type="number" class="validate" value="1">
                                    @if ($errors->has('units'))
                                        <span class="helper-text red-text" >
                                            <strong>{{ $errors->first('units') }}</strong>
                                        </span>
                                    @endif
                                    <label for="units">Units</label>
                                </div>
                                <div class="input-field col s12 m3 l3">
                                    <input id="amount" name="amount" type="number" class="validate">
                                    @if ($errors->has('amount'))
                                        <span class="helper-text red-text" >
                                            <strong>{{ $errors->first('amount') }}</strong>
                                        </span>
                                    @endif
                                    <label for="amount">Amount (₦)</label>
                                </div>
                                <div class="input-field col s12 m3 l3">
                                    <input id="balance" name="balance" type="number" class="validate" value="0">
                                    @if ($errors->has('balance'))
                                        <span class="helper-text red-text" >
                                            <strong>{{ $errors->first('balance') }}</strong>
                                        </span>
                                    @endif
                                    <label for="balance">Balance (₦ if any)</label>
                                </div>
                                <div class="input-field col s12 m3 l3">
                                    <input id="change" name="change" type="number" class="validate" value="0">
                                    @if ($errors->has('change'))
                                        <span class="helper-text red-text" >
                                            <strong>{{ $errors->first('change') }}</strong>
                                        </span>
                                    @endif
                                    <label for="change">Change (₦ if any)</label>
                                </div>
                            </div>
                            <div class="row right btnWrap" style="display:flex; justify-content:center;">
                                <button id="addSalesBtn" class="addSaleSubmitBtn btn waves-effect waves-light" type="submit">Submit
                                    <i class="material-icons right">send</i>
                                </button>
                                 {{-- SPINNER --}}
                                @include('components.submitPreloader')
                            </div>
                        </form>
                    </div>
                </div>

                {{-- SALES HEADING --}}
                <h5 class="center salesHeading">Sales Records</h5>

                {{-- SALES TABLE --}}
                <div class="salesTable col s12 m6 l8">
                    <table class="highlight centered responsive-table">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Product/Service</th>
                                <th>Paid</th>
                                <th>Outstanding</th>
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
                                <td>{{ $sale->productOrService }}</td>
                                <td>₦{{ $sale->amount }}</td>
                                @if ($sale->balance > 0)
                                    <td class="clearOutstanding blue-text" data-salesId="{{ $sale->id }}">+ ₦{{ $sale->balance }} Bal</td>
                                @elseif($sale->change > 0)
                                    <td class="clearOutstanding red-text" data-salesId="{{ $sale->id }}">- ₦{{ $sale->change }} Chg</td>
                                @else
                                    <td> NIL </td>
                                @endif
                                <td>{{ Carbon\Carbon::parse($sale->created_at)->diffForHumans() }}</td>
                                <td><a class="recieptBtn" data-salesId="{{ $sale->id }}" href="#"><i class="material-icons">receipt</i></a></td>
                                <td>
                                    <a class="delete deleteSale" href="#delete" data-salesId="{{ $sale->id }}">
                                        <i class="tiny material-icons">close</i>
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

                {{-- SALES RECIEPT --}}
                <div class="salesRecieptArea col s12 m6 l4">
                    <div class="reciept">
                        <h5 class="noReciept">
                            Transaction Reciept
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
