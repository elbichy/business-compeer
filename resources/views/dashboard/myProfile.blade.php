@extends('layouts.app')

@section('content')
<div class="my-content-wrapper">
    <div class="content-container">
        <div class="row profileWrap">
            <div class="focusArea col s12 m5 l5 z-depth-2">
                <div class="picArea">
                    @if($data['profileDatails']->gender == 'male')
                        <img src="{{ $data['profileDatails']->image !== NULL ? asset('storage/site/profile').'/'.$data['profileDatails']->image : asset('storage/site/avaterMale.jpg')}}" alt="profile">
                    @elseif($data['profileDatails']->gender == 'female')
                        <img src="{{ $data['profileDatails']->image !== NULL ? asset('storage/site/profile').'/'.$data['profileDatails']->image : asset('storage/site/avaterFemale.jpg')}}" alt="profile">
                    @endif
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
            <div class="detailsArea col s12 m7 l7">
                <form action="{{route('updateMyProfile')}}" method="post" name="updateStaffForm" class="updateStaffForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="input-field col s12 m8 l4">
                            <input id="firstname" name="firstname" type="text" class="validate" value="{{ $data['profileDatails']->firstname !== NULL ? $data['profileDatails']->firstname : '' }}">
                            @if ($errors->has('firstname'))
                                <span class="helper-text red-text" >
                                    <strong>{{ $errors->first('firstname') }}</strong>
                                </span>
                            @endif
                            <label for="firstname">Firstname</label>
                        </div>
                        <div class="input-field col s12 m8 l4">
                            <input id="lastname" name="lastname" required type="text" class="validate" value="{{ $data['profileDatails']->lastname !== NULL ? $data['profileDatails']->lastname : '' }}">
                            @if ($errors->has('lastname'))
                                <span class="helper-text red-text" >
                                    <strong>{{ $errors->first('lastname') }}</strong>
                                </span>
                            @endif
                            <label for="lastname">Lastname</label>
                        </div>
                        <div class="input-field col s12 m4 l4">
                            <select id="gender" name="gender" required>
                                <option value="" disabled selected>Choose an option</option>
                                <option value="male" {{ $data['profileDatails']->gender == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ $data['profileDatails']->gender == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ $data['profileDatails']->gender == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @if ($errors->has('gender'))
                                <span class="helper-text red-text" >
                                    <strong>{{ $errors->first('gender') }}</strong>
                                </span>
                            @endif
                            <label>Gender</label>
                        </div>

                        <div class="input-field col s12 m4 l4">
                            <input id="dob" name="dob" type="date" class="validate" value="{{ $data['profileDatails']->dob !== NULL ? $data['profileDatails']->dob : '' }}" required>
                            @if ($errors->has('dob'))
                                <span class="helper-text red-text" >
                                    <strong>{{ $errors->first('dob') }}</strong>
                                </span>
                            @endif
                            <label for="dob">Date of Birth</label>
                        </div>
                        <div class="input-field col s12 m4 l4">
                            <input id="email" name="email" type="email" class="validate" value="{{ $data['profileDatails']->email !== NULL ? $data['profileDatails']->email : '' }}" disabled>
                            @if ($errors->has('email'))
                                <span class="helper-text red-text" >
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                            <label for="email">E-Mail</label>
                        </div>
                        <div class="input-field col s12 m4 l4">
                            <input id="password" name="password" type="password" class="validate" value="{{ $data['profileDatails']->password !== NULL ? $data['profileDatails']->password : '' }}" required>
                            @if ($errors->has('password'))
                                <span class="helper-text red-text" >
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                            <label for="password">Password</label>
                        </div>

                        <div class="input-field col s12 m4 l4">
                            <input id="phone" name="phone" type="text" class="validate" value="{{ $data['profileDatails']->phone !== NULL ? $data['profileDatails']->phone : '' }}" required>
                            @if ($errors->has('phone'))
                                <span class="helper-text red-text" >
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                            <label for="phone">Phone</label>
                        </div>
                        <div class="input-field col s12 m4 l4">
                            <select id="soo" name="soo" required>
                                <option value="" disabled selected>Choose an option</option>
                                <option value="abuja">Abuja</option>
                                <option value="kano">Kano</option>
                                <option value="katsina">Katsina</option>
                            </select>
                            @if ($errors->has('soo'))
                                <span class="helper-text red-text" >
                                    <strong>{{ $errors->first('soo') }}</strong>
                                </span>
                            @endif
                            <label>State (origin)</label>
                        </div>
                        <div class="input-field col s12 m4 l4">
                            <select id="lgoo" name="lgoo" required>
                                <option value="" disabled selected>Choose an option</option>
                                <option value="bichi" >Bichi</option>
                                <option value="funtua">Funtua</option>
                                <option value="abaji">Abaji</option>
                            </select>
                            @if ($errors->has('lgoo'))
                                <span class="helper-text red-text" >
                                    <strong>{{ $errors->first('lgoo') }}</strong>
                                </span>
                            @endif
                            <label>LGA (origin)</label>
                        </div>

                        <div class="input-field col s12 m8 l8">
                            <input id="currentAddress" name="currentAddress" type="text" class="validate"  value="{{ $data['profileDatails']->currentAddress !== NULL ? $data['profileDatails']->currentAddress : '' }}" required>
                            @if ($errors->has('currentAddress'))
                                <span class="helper-text red-text" >
                                    <strong>{{ $errors->first('currentAddress') }}</strong>
                                </span>
                            @endif
                            <label for="currentAddress">Address (current)</label>
                        </div>
                        <div class="input-field col s12 m4 l4">
                            <select id="business_id" name="business_id" disabled>
                                <option value="" disabled selected>Choose an option</option>
                                @if(count($data['businessDetails'] ) > 0)
                                    @foreach ($data['businessDetails'] as $business)
                                        <option value="{{$business->id}}" {{ $data['profileDatails']->business_id == $business->id ? 'selected' : '' }}>{{ucfirst($business->name)}}</option> 
                                    @endforeach
                                @endif
                            </select>
                            @if ($errors->has('business_id'))
                                <span class="helper-text red-text" >
                                    <strong>{{ $errors->first('business_id') }}</strong>
                                </span>
                            @endif
                            <label>Company</label>
                        </div>

                        <div class="input-field col s12 m4 l4">
                            <select id="branch_id" name="branch_id" disabled>
                                <option value="" disabled selected>Choose an option</option>
                                @if(count($data['branchDetails'] ) > 0)
                                    @foreach ($data['branchDetails'] as $branch)
                                        <option value="{{$branch->id}}" {{ $data['profileDatails']->branch_id == $branch->id ? 'selected' : '' }}>{{ucfirst($branch->name)}} Branch</option> 
                                    @endforeach
                                @endif
                            </select>
                            @if ($errors->has('branch_id'))
                                <span class="helper-text red-text" >
                                    <strong>{{ $errors->first('branch_id') }}</strong>
                                </span>
                            @endif
                            <label>Branch</label>
                        </div>
                        <div class="input-field col s12 m4 l4">
                            <select id="role" name="role" disabled>
                                <option value="" disabled selected>Choose an option</option>
                                <option value="1" {{ $data['profileDatails']->role == 1 ? 'selected' : '' }}>Co-owner</option>
                                <option value="2" {{ $data['profileDatails']->role == 2 ? 'selected' : '' }}>Administrator</option>
                                <option value="3" {{ $data['profileDatails']->role == 3 ? 'selected' : '' }}>Manager</option>
                                <option value="4" {{ $data['profileDatails']->role == 4 ? 'selected' : '' }}>Sales Representative</option>
                            </select>
                            @if ($errors->has('role'))
                                <span class="helper-text red-text" >
                                    <strong>{{ $errors->first('role') }}</strong>
                                </span>
                            @endif
                            <label>Position</label>
                        </div>
                        <div class="input-field col s12 m4 l4">
                            <input id="identityType" name="identityType" type="text" class="validate"  value="{{ $data['profileDatails']->identityType !== NULL ? $data['profileDatails']->identityType : '' }}" required>
                            @if ($errors->has('identityType'))
                                <span class="helper-text red-text" >
                                    <strong>{{ $errors->first('identityType') }}</strong>
                                </span>
                            @endif
                            <label for="identityType">ID Type</label>
                        </div>

                        <div class="input-field col s12 m4 l4">
                            <input id="identityNumber" name="identityNumber" type="text" class="validate"  value="{{ $data['profileDatails']->identityNumber !== NULL ? $data['profileDatails']->identityNumber : '' }}" required>
                            @if ($errors->has('identityNumber'))
                                <span class="helper-text red-text" >
                                    <strong>{{ $errors->first('identityNumber') }}</strong>
                                </span>
                            @endif
                            <label for="identityNumber">ID Number</label>
                        </div>
                        <div class="file-field input-field col s12 m4 l4">
                            <div class="btn btn-small grey darken-1" style="width:100%;">
                                <span>Upload ID Card</span>
                                <input type="file" name="idCard" id="idCard" required>
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text">
                            </div>
                        </div>
                        <div class="file-field input-field col s12 m4 l4">
                            <div class="btn btn-small grey darken-1" style="width:100%;">
                                <span>Upload Photo</span>
                                <input type="file" name="photo" id="photo" required>
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text">
                            </div>
                        </div>
                        <div class="col s12" style="padding:0px;">
                            <div class="file-field input-field col s12 m6 l6">
                                <div class="btn btn-small grey darken-1" style="width:100%;">
                                    <span>Upload your Signature</span>
                                    <input type="file" name="signature" id="signature" required>
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text">
                                </div>
                            </div>
                            <div class="input-field btnWrap col s12 m6 l6" style="display:flex; justify-content:flex-end;">
                                <button id="staffSettingsBtn" class="right branchSubmitBtn btn waves-effect waves-light" type="submit">Submit
                                    <i class="material-icons right">send</i>
                                </button>
                                {{-- SPINNER --}}
                                @include('components.submitPreloader')
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection