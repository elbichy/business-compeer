@extends('layouts.app')

@section('content')
    <div class="my-content-wrapper">
        <div class="content-container">
            <div class="row customersWrap">
                <h5 class="center customersHeading">Customers Base</h5>
                <div class="customersTableWrap col s12">
                    <div class="customersTable col s12">
                        <table class="highlight centered responsive-table">
                            <thead>
                            <tr>
                                <th>Customer Name</th>
                                <th>Phone</th>
                                <th>Location</th>
                                <th>Patron since</th>
                                <th>Amount spent</th>
                                <th></th>
                            </tr>
                            </thead>

                            <tbody>
                        @foreach($data['salesDetails'] as $customer)
                            <tr>
                                <td>{{$customer->firstname}} {{$customer->lastname}}</td>
                                <td>{{$customer->phone}}</td>
                                <td>{{$customer->location}}</td>
                                <td>{{$customer->created_at}}</td>
                                <td>₦{{$customer->amount}}</td>
                                <td>
                                    <a class="delete deleteCustomer" href="#delete">
                                        <i class="tiny material-icons">close</i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col s12" style="padding:15px 0 0 0;">
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
