@extends('layouts.app')

@section('content')
    <div class="my-content-wrapper">
        <div class="content-container">
            <div class="row salesWrap">
                    
                {{-- MODAL BODY --}}
                <div id="processTransfer" class="modal modal-fixed-footer">
                        <div class="modal-content processTransfer">
                            <h5>Transaction Details</h5>
                            <div class="progress">
                                <div class="indeterminate"></div>
                            </div>
                            <div class="transferContent">
                            </div>
                        </div>
                        <div class="modal-footer btnWrap" style="display:flex; justify-content:flex-end;">
                            <button onclick="declineTransfer(event)" id="declineBtn" class="declineBtn red btn waves-effect waves-light disabled" type="submit" >Decline
                                <i class="material-icons right">close</i>
                            </button>
                            <button onclick="approveTransfer(event)" id="approveBtn" class="approveBtn green btn waves-effect waves-light disabled" type="submit">Approve
                                <i class="material-icons right">done</i>
                            </button>
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
                                
                            @if(count($data['notifications']) > 0)
                                @foreach ($data['notifications'] as $notif)
                                    <tr>
                                        <td>{{ $notif->data['data']['branch'] }}</td>
                                        <td>{{ $notif->data['data']['staffName']  }}</td>
                                        <td>{{ $notif->data['data']['depositor']  }}</td>
                                        <td>{{ $notif->data['data']['reciepient'] }}</td>
                                        <td>{{ $notif->data['data']['bankName'] }}</td>
                                        <td>{{ $notif->data['data']['accountNumber'] }}</td>
                                        <td>₦{{ number_format($notif->data['data']['amount']) }}</td>
                                        <td>{{ Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}</td>
                                        <td>
                                            <a onclick="getTransferDetails(event)" href="#processTransfer" data-transferId="{{ $notif->data['data']['refNumber'] }}" data-notification_id="{{ $notif->id }}" class="waves-effect modal-trigger waves-light btn blue">view</a>
                                        </td>
                                        <td>
                                            <a class="delete deleteSale" href="#delete" data-salesId="{{ $notif->data['data']['refNumber'] }}">
                                                <i class="tiny material-icons">close</i>
                                            </a>
                                        </td>

                                        {{-- DELETE SALES FORM --}}
                                        <form action="" method="post" id="deleteSaleForm">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="saleId">
                                        </form>

                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="footer z-depth-1">
            <p>&copy; 2019 Bits Infotech solution</p>
        </div>
    </div>
@endsection
