@extends('layouts.app')

@section('content')
 
    <div class="my-content-wrapper">
        <div class="content-container">

            {{-- TOP STATS ROW --}}
            <div class="stats card row">
                <div class="stats-inner">
                    <div class="col s12 m4 l3">
                        <div class="info-box">
                        <span class="info-box-icon blue darken-1 white-text"><i class="material-icons">attach_money</i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">GROSS REVENUE <br />TODAY</span>
                            <span id="registered" class="info-box-number">
                                @if (count($data['todaysTransactions']['todaysSales']) > 0)
                                    <?php $totalAmount = 0 ?>
                                    <?php $totalChange = 0 ?>
                                    <?php $totalBalance = 0 ?>
                                    @foreach($data['todaysTransactions']['todaysSales'] as $sale)
                                        <?php $totalAmount += $sale->amount ?>
                                        <?php $totalBalance += $sale->balance ?>
                                        <?php $totalChange += $sale->change ?>
                                    @endforeach
                                    ₦{{ $totalAmount + $totalBalance - $totalChange }}
                                @else
                                    ₦0
                                @endif
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col s12 m4 l3">
                        <div class="info-box">
                        <span class="info-box-icon red darken-1 white-text"><i class="material-icons">money_off</i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">EXPENSES TODAY</span>
                            <span id="in_progress" class="info-box-number">
                                @if (count($data['todaysTransactions']['todaysExpenses']) > 0)
                                    <?php $totalCost = 0 ?>
                                    @foreach($data['todaysTransactions']['todaysExpenses'] as $expense)
                                        <?php $totalCost += $expense->cost ?>
                                    @endforeach
                                    ₦{{ $totalCost }}
                                @else
                                    ₦0
                                @endif
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->

                    <div class="col s12 m4 l3">
                        <div class="info-box">
                        <span class="info-box-icon teal darken-2 white-text"><i class="material-icons">done</i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">NET REVENUE <br />TODAY</span>
                            <span id="completed" class="info-box-number">

                                <?php $net = 0 ?>

                                @if (count($data['todaysTransactions']['todaysSales']) > 0)
                                    <?php $totalAmount = 0 ?>
                                    <?php $totalChange = 0 ?>
                                    <?php $totalBalance = 0 ?>
                                    @foreach($data['todaysTransactions']['todaysSales'] as $sale)
                                        <?php $totalAmount += $sale->amount ?>
                                        <?php $totalBalance += $sale->balance ?>
                                        <?php $totalChange += $sale->change ?>
                                    @endforeach
                                    {{-- TOTAL SALES AFTER ALL DEDUCTIONS --}}
                                    <?php $totalSales = $totalAmount + $totalBalance - $totalChange ?>
                                @else
                                    <?php $totalSales = 0 ?>
                                @endif

                                @if (count($data['todaysTransactions']['todaysExpenses']) > 0)
                                    <?php $totalCost = 0 ?>
                                    @foreach($data['todaysTransactions']['todaysExpenses'] as $expense)
                                        <?php $totalCost += $expense->cost ?>
                                    @endforeach
                                @else
                                    <?php $totalCost = 0 ?>
                                @endif
                                    
                                    {{-- NET REVENUE AFTER ALL DEDUCTIONS --}}
                                    <?php $net = $totalSales - $totalCost ?>
                                    ₦{{ $net }}
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col s12 m4 l3">
                        <div class="info-box">
                        <span class="info-box-icon yellow darken-4 white-text"><i class="material-icons">repeat</i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">TRANSACTION</span>
                            <span class="info-box-number">
                                <?php $transactions = count($data['todaysTransactions']['todaysSales']) + count($data['todaysTransactions']['todaysExpenses']) ?>
                                {{ $transactions }}
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                <!-- /.col -->
                </div>
            </div>

            {{-- TABLE RECORDS --}}
            <div class="row">
                <div class="tableWrap todaysSalesTable col s12 m12 l7">
                    <h5 class="center">Today's Sales</h5>
                    <table class="highlight centered responsive-table">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Product/Service</th>
                                <th>Paid</th>
                                <th>Time</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($data['todaysTransactions']['todaysSales'] as $sale)
                                <tr>
                                    <td>{{ $sale->firstname }} {{ $sale->lastname  }}</td>
                                    <td>{{ $sale->productOrService }}</td>
                                    <td>₦{{ $sale->amount }}</td>
                                    <td>{{ Carbon\Carbon::parse($sale->created_at)->diffForHumans() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tableWrap col s12 m12 l5">
                    <h5 class="center">Today's Expenses</h5>
                    <table class="highlight centered responsive-table">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Cost</th>
                                <th>Time</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($data['todaysTransactions']['todaysExpenses'] as $expense)
                                <tr>
                                    <td>{{ $expense->itemBought }}</td>
                                    <td>₦{{ $expense->cost }}</td>
                                    <td>{{ Carbon\Carbon::parse($sale->created_at)->diffForHumans() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
