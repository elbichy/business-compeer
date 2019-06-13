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
                    <form action="{{ url('storeSales') }}" method="post" name="addSalesForm" onsubmit="submitSale(event)" class="addSalesForm" id="addSalesForm">
                        <div class="modal-content">
                            <h5>New Money Transfer</h5>
                                @csrf
                                <input type="hidden" name="transferTransaction">
                                <div class="row">
                                    <div class="firstnameErr input-field col s12 m4 l4">
                                        <input id="firstname" name="firstname" type="text">
                                        <label for="firstname">Depositor's Firstname</label>
                                    </div>
                                    <div class="lastnameErr input-field col s12 m4 l4">
                                        <input id="lastname" name="lastname" type="text">
                                        <label for="lastname">Depositor's Lastname</label>
                                    </div>
                                    <div class="phoneErr input-field col s12 m4 l4">
                                        <input id="phone" name="phone" type="text">
                                        <label for="phone">Depositor's Phone</label>
                                    </div>
                                    <div class="locationErr input-field col s12 m12 l12">
                                        <i class="material-icons prefix">place</i>
                                        <textarea id="location" name="location" class="materialize-textarea"></textarea>
                                        <label for="location"> Depositor's Address</label>
                                    </div>
                                </div>

                                <fieldset style="border:2px solid #ccc;">
                                    <legend style="padding:4px 8px; border:2px solid #ccc;">Recievers Details</legend>
                                    <div class="row">
                                        <div class="recievers_firstnameErr input-field col s12 m4 l4">
                                            <input id="recievers_firstname" name="recievers_firstname" type="text">
                                            <label for="recievers_firstname">Reciever's Firstname</label>
                                        </div>
                                        <div class="recievers_lastnameErr input-field col s12 m4 l4">
                                            <input id="recievers_lastname" name="recievers_lastname" type="text">
                                            <label for="recievers_lastname">Reciever's Lastname</label>
                                        </div>
                                        <div class="recievers_phoneErr input-field col s12 m4 l4">
                                            <input id="recievers_phone" name="recievers_phone" type="text">
                                            <label for="recievers_phone">Reciever's Phone</label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="bankNameErr input-field col s12 m4 l4">
                                            <input id="bankName" name="bankName" type="text">
                                            <label for="bankName">Bank Name</label>
                                        </div>
                                        <div class="accountTypeErr input-field col s12 m4 l4">
                                            <input id="accountType" name="accountType" type="text">
                                            <label for="accountType">Account Type</label>
                                        </div>
                                        <div class="accountNumberErr input-field col s12 m4 l4">
                                            <input id="accountNumber" name="accountNumber" type="number">
                                            <label for="accountNumber">Account Number</label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="amountErr input-field col s12 m6 l6">
                                            <input id="amount" name="amount" type="number">
                                            <label for="amount">Amount (₦)</label>
                                        </div>
                                        <div class="chargeErr input-field col s12 m6 l6">
                                            <input id="charge" name="charge" type="number">
                                            <label for="charge">Charge (₦)</label>
                                        </div>
                                    </div>
                                </fieldset>
                            
                        </div>
                        <div class="modal-footer">
                                <button id="addSalesBtn" class="addSaleSubmitBtn btn waves-effect waves-light" type="submit">Submit<i class="material-icons right">send</i></button>
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
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th>Reciept</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody class="transferRecordsWrap">
                            @foreach ($data['salesDetails'] as $sale)
                                @if($sale->transfer !== NULL)
                                    @if($sale->status == 0)
                                    <tr>
                                        <td>{{ $sale->firstname }} {{ $sale->lastname  }}</td>
                                        <td>{{ $sale->transfer->recievers_firstname }} {{ $sale->transfer->recievers_lastname  }}</td>
                                        <td>{{ $sale->transfer->bankName }}</td>
                                        <td>{{ $sale->transfer->accountType }}</td>
                                        <td>{{ $sale->transfer->accountNumber }}</td>
                                        <td>₦{{ number_format($sale->transfer->amount) }}</td>
                                        <td>₦{{ number_format($sale->amount) }}</td>
                                        <td>{{ Carbon\Carbon::parse($sale->created_at)->diffForHumans() }}</td>
                                        <td>
                                            {!! $sale->transfer->status == 0 ? '<i class="material-icons orange-text tooltipped" data-position="right" data-tooltip="pending">autorenew</i>' : '<i class="material-icons green-text tooltipped" data-position="right" data-tooltip="completed">done_all</i>' !!}
                                        </td>
                                        <td><a class="recieptBtn" data-salesId="{{ $sale->id }}" href="#"><i class="material-icons">receipt</i></a></td>
                                        <td>
                                            <a class="delete deleteSale" href="#delete" data-salesId="{{ $sale->id }}">
                                                <i class="tiny material-icons">close</i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="#">
                                                <i class="tiny material-icons">question_answer</i>
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
                                    @endif
                                @endif
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
        <div class="footer z-depth-1">
            <p>&copy; 2019 Bits Infotech solution</p>
        </div>
    </div>
@endsection
