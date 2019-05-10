@extends('layouts.app')

@section('content')
<div class="my-content-wrapper">
    <div class="content-container">
        <div class="row profileWrap">
            <div class="focusArea col s12 m5 l5 z-depth-2">
                <div class="picArea">
                    <img src="{{asset('storage/yuna.jpg')}}" alt="profile">
                    <p><strong>Suleiman Abdulrazaq</strong></p>
                    <div class="row fRow">
                        <small class="col s12 m5 l5 center-align">Sales Representative</small>
                        <small class="col s12 m7 l7 center-align">Employed on 12th Jan, 2019</small>
                    </div>
                    <div class="row">
                        <small class="col s12 m4 l4 center-align">08050811702</small>
                        <small class="col s12 m8 l8 center-align">08 KB Aliyu street PDP Quarters</small>
                    </div>
                </div>
                <div class="salesMadeArea">
                    <h5 class="salesMadeHeading">
                        Amount of Sales Made
                    </h5>
                    <h2 class="salesMade">
                        ₦20000
                    </h2>
                </div>
            </div>
            <div class="detailsArea col s12 m7 l7">

            </div>
        </div>
    </div>
</div>
@endsection