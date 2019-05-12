@extends('layouts.app')

@section('content')
<div class="my-content-wrapper">
    <div class="content-container">
        <div class="row profileWrap">
            <div class="focusArea col s12 m5 l5 z-depth-2">
                <div class="picArea">
                    <img src="{{asset('storage/yuna.jpg')}}" alt="profile">
                    <p><strong>{{ $data['profileDatails']->firstname  }} {{ $data['profileDatails']->lastname  }}</strong></p>
                    <div class="row fRow">
                        <small class="col s12 m5 l5 center-align">
                            @if($data['profileDatails']->role == 4)
                                Sales Representative
                            @elseif($data['profileDatails']->role == 3)
                                Manager
                            @elseif($data['profileDatails']->role == 2)
                                Administrator
                            @elseif($data['profileDatails']->role == 1)
                                Owner (C.E.O)
                            @endif
                        </small>
                        <small class="col s12 m7 l7 center-align">
                            @if($data['profileDatails']->role == 1)
                                Started business {{ Carbon\Carbon::parse($data['profileDatails']->created_at)->diffForHumans() }}
                            @else
                                Employed {{ Carbon\Carbon::parse($data['profileDatails']->created_at)->diffForHumans() }}
                            @endif
                        </small>
                    </div>
                    <div class="row">
                        <small class="col s12 m4 l4 center-align">{{ $data['profileDatails']->phone  }}</small>
                        <small class="col s12 m8 l8 center-align">{{ $data['profileDatails']->currentAddress  }}</small>
                    </div>
                </div>
                <div class="salesMadeArea">
                    <h5 class="salesMadeHeading">
                        Total Sales Made
                    </h5>
                    <div style="width: 80%; display:flex; padding:6px; justify-content:center; align-items:center;">
                        <h2 style="height:80px; flex:1; background: #0fb13b" class="salesMade white-text">{{$data['totalSalesCount']}}</h2>
                        <h4 style="padding:6px; border:4px solid #0fb13b; margin:0; height:80px; flex:2; display:flex; padding:6px; justify-content:center; align-items:center; color:#0fb13b;">₦{{$data['totalSales']}}</h4>
                    </div>
                    
                </div>
            </div>
            <div class="detailsArea col s12 m7 l7" style="border:2px solid red;">

            </div>
        </div>
    </div>
</div>
@endsection