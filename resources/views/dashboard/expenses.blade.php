@extends('layouts.app')

@section('content')

    <div class="my-content-wrapper">
        <div class="content-container">
            <div class="row expenseWrap">
                <h5 class="center expenseHeading">Expense Records</h5>
                <div class="expenseForm col s12 m6 l5">
                    <form action="{{ url('storeExpenses') }}" method="post" name="addSalesForm" class="addSalesForm">
                        @csrf
                        <div class="row">
                            <div class="input-field col s12 switch">
                                <label>
                                Service
                                <input type="checkbox" name="type" class="type">
                                <span class="lever"></span>
                                Product
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="itemBought" name="itemBought" type="text" class="validate">
                                @if ($errors->has('itemBought'))
                                    <span class="helper-text red-text" >
                                        <strong>{{ $errors->first('itemBought') }}</strong>
                                    </span>
                                @endif
                                <label for="itemBought">Service/Product Bought</label>
                            </div>
                            <div class="input-field col s12">
                                <input id="boughtFrom" name="boughtFrom" type="text" class="validate">
                                @if ($errors->has('boughtFrom'))
                                    <span class="helper-text red-text" >
                                        <strong>{{ $errors->first('boughtFrom') }}</strong>
                                    </span>
                                @endif
                                <label for="boughtFrom">Bought from?</label>
                            </div>
                            <div class="input-field col s12">
                                <input id="cost" name="cost" type="number" class="validate">
                                @if ($errors->has('cost'))
                                    <span class="helper-text red-text" >
                                        <strong>{{ $errors->first('cost') }}</strong>
                                    </span>
                                @endif
                                <label for="cost">Cost (₦)</label>
                            </div>
                        </div>
                        <div class="row center btnWrap" style="display:flex; justify-content:center;">
                            <button id="addExpensesBtn" class="addSaleSubmitBtn btn waves-effect waves-light" type="submit">Submit
                                <i class="material-icons right">send</i>
                            </button>
                            {{-- SPINNER --}}
                            @include('components.submitPreloader')
                        </div>
                    </form>
                </div>
                <div class="expenseTable col s12 m6 l7">
                    <table class="highlight centered responsive-table">
                        <thead>
                        <tr>
                            <th>Type</th>
                            <th>Item</th>
                            <th>Cost</th>
                            <th>Bought from</th>
                            <th>Date/Time</th>
                            <th></th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach ($data['expensesDetails'] as $expense)
                            <tr>
                                <td>{{ $expense->type }}</td>
                                <td>{{ $expense->itemBought }}</td>
                                <td>{{ $expense->boughtFrom }}</td>
                                <td>{{ $expense->cost }}</td>
                                <td>{{ Carbon\Carbon::parse($expense->created_at)->diffForHumans() }}</td>
                                <td>
                                    <a class="delete deleteExpense" data-expenseId="{{ $expense->id }}" href="#delete_forever">
                                        <i class="tiny material-icons">close</i>
                                    </a>
                                </td>
                                <form action="" method="post" id="deleteExpenseForm">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
