@extends('layouts.app')

@section('content')
    <div class="my-content-wrapper">
        <div class="content-container">
            <div class="row salesWrap">
                {{-- MODAL TRIGGER --}}
                <a href="#addSaleDialog" class="addSaleBtn hide-on-small-only-old modal-trigger btn-floating btn-large waves-effect waves-light red darken-2"><i class="material-icons">add</i></a>
                {{-- MODAL BODY --}}
                <div id="addSaleDialog" class="modal modal-fixed-footer">
                    <div class="progress" style="margin:0; height:6px; display:none;">
                        <div class="indeterminate" style="width: 70%"></div>
                    </div>
                    <form action="{{ url('storeSales') }}" method="post" onsubmit="submitSale(event)" name="addSalesForm" class="addSalesForm" id="addSalesForm">
                        <div class="modal-content">
                            <h5>New Transaction</h5>
                            @csrf
                            <input type="hidden" name="transactionForm" value="sales">
                            <div class="row">
                                <div class="col s12 m4 l4 switch" style="    margin-top: 2rem; margin-bottom: 1rem;">
                                    <label>
                                    Service
                                    <input type="checkbox" name="type" class="type" id="type">
                                    <span class="lever"></span>
                                    Product
                                    </label>
                                </div>
                                <div class="input-field col s12 m4 l4">
                                    <input id="firstname" name="firstname" type="text">
                                    <label for="firstname">Customer Firstname</label>
                                </div>
                                <div class="input-field col s12 m4 l4">
                                    <input id="lastname" name="lastname" type="text">
                                    <label for="lastname">Customer Lastname</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="phoneErr input-field col s12 m4 l4">
                                    <input id="phone" name="phone" type="text">
                                    <label for="phone">Customer Phone</label>
                                </div>
                                <div class="locationErr input-field col s12 m4 l4">
                                    <i class="material-icons prefix">place</i>
                                    <input id="location" name="location" type="text">
                                    <label for="location">Location</label>
                                </div>
                                <div class="productOrServiceErr input-field col s12 m4 l4">
                                    <input id="productOrService" name="productOrService" type="text" class="autocomplete validate" required>
                                    @if($data['stockDetails'] !== '')
                                        <script>
                                            // AUTO COMPLETE
                                            const data = '{!! $data['stockDetails'] !!}';
                                            var items = $.parseJSON(data);
                                            // var items = JSON.parse(data);
                                            
                                            let result = {} 
                                            items.forEach(i => { result[i.item] = [i.unitPrice] })
                                            $(document).ready(function(){
                                                $('input.autocomplete').autocomplete({
                                                    data: result,
                                                    limit: 3,
                                                    onAutocomplete: function(opt){
                                                        $('#amount').prop("disabled", true);
                                                        $('#balance').prop("readonly", true);
                                                        $('#change').prop("readonly", true);
                                                    }
                                                });
                                            });
                                        </script>
                                    @endif
                                    <label for="productOrService">Product/Service offered</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12 m3 l3">
                                    <input id="units" name="units" type="number" class="validate" value="1" required>
                                    <label for="units">Units</label>
                                </div>
                                <div class="input-field col s12 m3 l3">
                                    <input id="amount" name="amount" type="number" class="validate" required>
                                    <label for="amount">Amount (₦)</label>
                                </div>
                                <div class="input-field col s12 m3 l3">
                                    <input id="balance" name="balance" type="number" value="0">
                                    <label for="balance">Balance (₦ if any)</label>
                                </div>
                                <div class="input-field col s12 m3 l3">
                                    <input id="change" name="change" type="number" value="0">
                                    <label for="change">Change (₦ if any)</label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="addSalesBtn" class="addMainSaleSubmitBtn btn waves-effect waves-light" type="submit">Submit<i class="material-icons right">send</i></button>
                        </div>
                    </form>
                </div>

                {{-- SALES HEADING --}}
                <h5 class="center salesHeading">Sales Records</h5>

                {{-- SALES TABLE --}}
                <div class="salesTableWrap col s12 m6 l8">
                    <div class="salesTable col s12">
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

                            <tbody class="salesRecordsWrap">
                            @foreach ($data['salesDetails'] as $sale)
                                <tr>
                                    <td>{{ $sale->firstname }} {{ $sale->lastname  }}</td>
                                    <td>{{ $sale->productOrService }}</td>
                                    <td>₦{{ number_format($sale->amount) }}</td>
                                    @if ($sale->balance > 0)
                                        <td onclick="clearOutstanding(event)" class="clearOutstanding blue-text" data-salesId="{{ $sale->id }}">+ ₦{{ $sale->balance }} Bal</td>
                                    @elseif($sale->change > 0)
                                        <td onclick="clearOutstanding(event)" class="clearOutstanding red-text" data-salesId="{{ $sale->id }}">- ₦{{ $sale->change }} Chg</td>
                                    @else
                                        <td> NIL </td>
                                    @endif
                                    <td>{{ Carbon\Carbon::parse($sale->created_at)->diffForHumans() }}</td>
                                    <td><a href="#salesRecieptArea" onclick="loadReciept(event)" class="recieptBtn" data-salesId="{{ $sale->id }}" href="#"><i class="material-icons">receipt</i></a></td>
                                    <td>
                                        <a onclick="deleteSale(event, this.dataset.salesid)" class="delete deleteSale" href="#delete" data-salesId="{{ $sale->id }}">
                                            <i class="tiny material-icons">close</i>
                                        </a>
                                    </td>

                                    {{-- CLEAR OUTSTANDING FORM --}}
                                    <form action="#" method="post" id="clearOutstandingForm">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="salesId">
                                    </form>

                                    {{-- DELETE SALES FORM --}}
                                    <form action="#" method="post" id="deleteSaleForm">
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

                {{-- SALES RECIEPT --}}
                <div class="salesRecieptArea col s12 m6 l4">
                    <div class="reciept" id="salesRecieptArea">
                        <h5 class="noReciept">
                            Transaction Reciept
                        </h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer z-depth-1">
            <p>&copy; 2019 Bits Infotech solution</p>
        </div>
    </div>
@endsection
