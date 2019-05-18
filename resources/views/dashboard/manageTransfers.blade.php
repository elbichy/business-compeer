@extends('layouts.app')

@section('content')
    
    <div class="my-content-wrapper">
        <div class="content-container">
            <div class="row salesWrap">

                {{-- SALES HEADING --}}
                <h5 class="center salesHeading">Manage Transfers</h5>

                {{-- SALES TABLE --}}
                <div class="salesTableWrap col s12 m6 l6">
                    <div class="salesTable col s12">
                        <table class="highlight centered responsive-table">
                            <thead>
                                <tr>
                                    <th>Branch</th>
                                    <th>Staff</th>
                                    <th>Ref No.</th>
                                    <th>Time</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                            @foreach ($data['salesDetails'] as $sale)
                                <tr>
                                    <td>{{ $sale->firstname }} {{ $sale->lastname  }}</td>
                                    <td>{{ $sale->firstname }} {{ $sale->lastname  }}</td>
                                    <td>{{ $sale->transfer->refNumber }}</td>
                                    <td>{{ Carbon\Carbon::parse($sale->created_at)->diffForHumans() }}</td>
                                    <td>
                                        <a href="#delete">view</a>
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
                            @endforeach
                            </tbody>
                        </table>
                        
                    </div>
                    <div class="col s12" style="padding:0;">
                        {{$data['salesDetails']->links('vendor.pagination.materializecss')}}
                    </div>
                </div>

                {{-- SALES TABLE --}}
                <div class="salesTableWrap col s12 m6 l6">
                </div>
            </div>
        </div>
    </div>
@endsection
