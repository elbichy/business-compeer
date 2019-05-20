@extends('layouts.app')

@section('content')
    
    <div class="my-content-wrapper">
        <div class="content-container">
            <div class="row salesWrap">


                {{-- MODAL BODY --}}
                <div id="addSaleDialog" class="modal modal-fixed-footer">
                        <div class="modal-content">
                            <h5>New Transaction</h5>
                            <p>Content goes here...</p>
                        </div>
                        <div class="modal-footer btnWrap" style="display:flex; justify-content:flex-end;">
                            <button id="addSalesBtn" class="addSaleSubmitBtn btn waves-effect waves-light" type="submit">Submit
                                <i class="material-icons right">send</i>
                            </button>
                                {{-- SPINNER --}}
                            @include('components.submitPreloader')
                        </div>
                </div>
                {{-- SALES HEADING --}}
                <h5 class="center salesHeading">Manage Transfers</h5>

                {{-- SALES TABLE --}}
                <div class="salesTableWrap col s12">
                    <div class="salesTable col s12">
                        <table class="highlight centered responsive-table">
                            <thead>
                                <tr>
                                    <th>Branch</th>
                                    <th>Staff</th>
                                    <th>Depositor</th>
                                    <th>Reciepient</th>
                                    <th>Bank</th>
                                    <th>Acc No.</th>
                                    <th>Amount</th>
                                    <th>Time</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                            @foreach ($data['salesDetails'] as $sale)
                                @if($sale->transfer->status == 0)
                                    <tr>
                                        <td>{{ $sale->branch->name }}</td>
                                        <td>{{ $sale->user->firstname }} {{ $sale->user->lastname  }}</td>
                                        <td>{{ $sale->firstname }} {{ $sale->lastname  }}</td>
                                        <td>{{ $sale->transfer->recievers_firstname }} {{ $sale->transfer->recievers_lastname  }}</td>
                                        <td>{{ $sale->transfer->bankName }}</td>
                                        <td>{{ $sale->transfer->accountNumber }}</td>
                                        <td>₦{{ number_format($sale->transfer->amount) }}</td>
                                        <td>{{ Carbon\Carbon::parse($sale->created_at)->diffForHumans() }}</td>
                                        <td>
                                            <a href="#addSaleDialog" class="waves-effect modal-trigger waves-light btn blue">view</a>
                                        </td>
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
    </div>
@endsection
