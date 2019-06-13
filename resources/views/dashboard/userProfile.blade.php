@extends('layouts.app')

@section('content')
<div class="my-content-wrapper">
    <div class="content-container">
        <div class="row profileWrap">
            <div class="focusArea col s12 m5 l5 z-depth-2">
                <div class="picArea">
                    @if($data['profileDatails']->gender == 'male')
                        <img class="materialboxed" src="{{ $data['profileDatails']->image !== NULL ? asset('storage/site').'/'.$data['businessDetails'][0]->name.'/profile'.'/'.$data['profileDatails']->image : asset('storage/site/avaterMale.jpg')}}" alt="profile">
                    @elseif($data['profileDatails']->gender == 'female')
                        <img class="materialboxed" src="{{ $data['profileDatails']->image !== NULL ? asset('storage/site').'/'.$data['businessDetails'][0]->name.'/profile'.'/'.$data['profileDatails']->image : asset('storage/site/avaterFemale.jpg')}}" alt="profile">
                    @elseif($data['profileDatails']->gender == NULL)
                        <img class="materialboxed" src="{{asset('storage/site/no-pic-no-gender.jpg')}}" alt="profile">
                    @endif
                    <p><strong>{{ $data['profileDatails']->firstname  }} {{ $data['profileDatails']->lastname  }}</strong></p>
                    <div class="row fRow">
                        <small class="col s12 m5 l5 center-align">
                            @if($data['profileDatails']->role == 4)
                                <strong>Sales Representative</strong>
                            @elseif($data['profileDatails']->role == 3)
                                <strong>Manager</strong>
                            @elseif($data['profileDatails']->role == 2)
                                <strong>Administrator</strong>
                            @elseif($data['profileDatails']->role == 1)
                                <strong>Owner (C.E.O)</strong>
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
            <div class="detailsArea col s12 m7 l7">
                <div class="detailsWrap">
                    <div class="col s12 m4 l4">
                        <div class="label">Firstname</div>
                        <div class="info">{{$data['profileDatails']->firstname}}</div>
                    </div>
                    <div class="col s12 m4 l4">
                        <div class="label">Lastname</div>
                        <div class="info">{{$data['profileDatails']->lastname}}</div>
                    </div>
                    <div class="col s12 m4 l4">
                        <div class="label">Gender</div>
                        <div class="info">{{$data['profileDatails']->gender}}</div>
                    </div>
                    
                    <div class="col s12 m4 l3">
                        <div class="label">Date of Birth</div>
                        <div class="info">{{$data['profileDatails']->dob}}</div>
                    </div>
                    <div class="col s12 m4 l6">
                        <div class="label">E-mail</div>
                        <div class="info">{{$data['profileDatails']->email}}</div>
                    </div>
                    <div class="col s12 m4 l3">
                        <div class="label">Phone</div>
                        <div class="info">{{$data['profileDatails']->phone}}</div>
                    </div>
                    
                    <div class="col s12">
                        <div class="label">Full Address (Current)</div>
                        <div class="info">{{$data['profileDatails']->currentAddress}}</div>
                    </div>
                    <div class="col s12">
                        <div class="label">Full Address (Origin)</div>
                        <div class="info">{{$data['profileDatails']->permanentAddress}}</div>
                    </div>

                    <div class="col s12 m6 l6">
                        <div class="label">Company</div>
                        <div class="info">
                            {{ ucfirst($data['userBusinessDetails']->name) }}
                        </div>
                    </div>
                    <div class="col s12 m6 l6">
                        <div class="label">Branch</div>
                        <div class="info">
                            {{ ucfirst($data['userBranchDetails']->name) }}
                        </div>
                    </div>

                    <div class="col s12 m4 l4">
                        <div class="label">Role</div>
                        <div class="info">
                            @switch($data['profileDatails']->role)
                                @case(1)
                                    Owner
                                    @break
                                @case(2)
                                    Administrator
                                    @break
                                @case(3)
                                    Manager
                                    @break
                                @case(4)
                                    Sales Representative
                                    @break
                                @default
                                    User
                            @endswitch
                        </div>
                    </div>
                    <div class="col s12 m4 l4">
                        <div class="label">ID Type</div>
                        <div class="info">{{$data['profileDatails']->identityType}}</div>
                    </div>
                    <div class="col s12 m4 l4">
                        <div class="label">ID Number</div>
                        <div class="info">{{$data['profileDatails']->identityNumber}}</div>
                    </div>
                    
                    <div class="col s12 m6 l6">
                        <div class="label">ID Card</div>
                        <div class="info">
                            @if($data['profileDatails']->idCard !== NULL)
                                <img class="materialboxed" src="{{ asset('storage/site').'/'.$data['businessDetails'][0]->name.'/idCards'.'/'.$data['profileDatails']->idCard}}" alt="ID Card">
                            @else
                                Yet to upload
                            @endif
                        </div>
                    </div>
                    <div class="col s12 m6 l6">
                        <div class="label">Signature</div>
                        <div class="info">
                            @if($data['profileDatails']->signature !== NULL)
                                <img class="materialboxed" src="{{ asset('storage/site').'/'.$data['businessDetails'][0]->name.'/signatures'.'/'.$data['profileDatails']->signature}}" alt="Signature">
                            @else
                                Yet to upload
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer z-depth-1">
        <p>&copy; 2019 Bits Infotech solution</p>
    </div>
</div>
@endsection