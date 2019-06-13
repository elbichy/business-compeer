@extends('layouts.app')

@section('content')
    <div class="my-content-wrapper">
        <div class="content-container">
            <div class="row stockWrap">
                <h5 class="center stockHeading">Stock Records</h5>
                <div class="stockForm col s12 m6 l5">
                    <form action="{{ route('storeStock') }}" method="post" name="addStockForm" class="addStockForm">
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
                                <input id="item" name="item" type="text" class="validate">
                                @if ($errors->has('item'))
                                    <span class="helper-text red-text" >
                                        <strong>{{ $errors->first('item') }}</strong>
                                    </span>
                                @endif
                                <label for="item">Product/Service</label>
                            </div>

                            <div class="input-field col s12 m4 l4">
                                <input id="unitPrice" name="unitPrice" type="number" class="validate">
                                @if ($errors->has('unitPrice'))
                                    <span class="helper-text red-text" >
                                        <strong>{{ $errors->first('unitPrice') }}</strong>
                                    </span>
                                @endif
                                <label for="unitPrice">Unit Price (₦)</label>
                            </div>
                            <div class="input-field col s12 m4 l4">
                                <input id="bulkUnit" name="bulkUnit" type="number" class="validate">
                                @if ($errors->has('bulkUnit'))
                                    <span class="helper-text red-text" >
                                        <strong>{{ $errors->first('bulkUnit') }}</strong>
                                    </span>
                                @endif
                                <label for="bulkUnit">Bulk Unit</label>
                            </div>
                            <div class="input-field col s12 m4 l4">
                                <input id="bulkUnitPrice" name="bulkUnitPrice" type="number" class="validate">
                                @if ($errors->has('bulkUnitPrice'))
                                    <span class="helper-text red-text" >
                                        <strong>{{ $errors->first('bulkUnitPrice') }}</strong>
                                    </span>
                                @endif
                                <label for="bulkUnitPrice">Bulk Unit Price (₦)</label>
                            </div>
                            <div class="input-field col s12">
                                <input id="availableUnits" name="availableUnits" type="text" value="NA" class="validate">
                                @if ($errors->has('availableUnits'))
                                    <span class="helper-text red-text" >
                                        <strong>{{ $errors->first('availableUnits') }}</strong>
                                    </span>
                                @endif
                                <label for="availableUnits">Available Units</label>
                            </div>
                        </div>
                        <div class="row center btnWrap" style="display:flex; justify-content:center;">
                            <button id="addStockBtn" class="addSaleSubmitBtn btn waves-effect waves-light" type="submit">Submit
                                <i class="material-icons right">send</i>
                            </button>
                            {{-- SPINNER --}}
                           @include('components.submitPreloader')
                        </div>
                    </form>
                </div>
                <div class="stockTable col s12 m6 l7">
                    <table class="highlight centered responsive-table">
                        <thead>
                        <tr>
                            <th>Item</th>
                            <th>Unit cost</th>
                            <th>Bulk unit</th>
                            <th>Bulk price</th>
                            <th>Category</th>
                            <th>In-stock</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach ($data['stockDetails'] as $stock)
                            <tr>
                                <td>{{ $stock->item }}</td>
                                <td>{{ $stock->unitPrice }}</td>
                                <td>{{ $stock->bulkUnit }}</td>
                                <td>{{ $stock->bulkUnitPrice }}</td>
                                <td>{{ $stock->type }}</td>
                                <td>{{ $stock->availableUnits }}</td>
                                <td>
                                    <a class="delete deleteStock" data-stockId="{{ $stock->id }}" href="#delete">
                                        <i class="tiny material-icons">close</i>
                                    </a>
                                </td>
                                <form action="" method="post" id="deleteStockForm">
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
        <div class="footer z-depth-1">
            <p>&copy; 2019 Bits Infotech solution</p>
        </div>
    </div>
@endsection
