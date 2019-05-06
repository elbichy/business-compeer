@extends('layouts.app')

@section('content')

    <div class="my-content-wrapper">
        <div class="content-container">
            <div class="row staffSettingsWrap">
                <h5 class="center staffSettingsHeading">Staff Settings</h5>
                <div class="staffSettingsForms col s12 m6 l6">
                    <form action="{{url('storeStaffSettings')}}" method="post" name="staffSettingsForm" class="staffSettingsForm">
                        @csrf
                        <div class="row">
                            <div class="input-field col s12 m8 l4">
                                <input id="firstname" name="firstname" type="text" class="validate">
                                @if ($errors->has('firstname'))
                                    <span class="helper-text red-text" >
                                        <strong>{{ $errors->first('firstname') }}</strong>
                                    </span>
                                @endif
                                <label for="firstname">Firstname</label>
                            </div>
                            <div class="input-field col s12 m8 l4">
                                <input id="lastname" name="lastname" type="text" class="validate">
                                @if ($errors->has('lastname'))
                                    <span class="helper-text red-text" >
                                        <strong>{{ $errors->first('lastname') }}</strong>
                                    </span>
                                @endif
                                <label for="lastname">Lastname</label>
                            </div>
                            <div class="input-field col s12 m4 l4">
                                <select id="gender" name="gender">
                                    <option value="" disabled selected>Choose an option</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                                @if ($errors->has('gender'))
                                    <span class="helper-text red-text" >
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                @endif
                                <label>Gender</label>
                            </div>

                            <div class="input-field col s12 m4 l4">
                                <input id="dob" name="dob" type="date" class="validate">
                                @if ($errors->has('dob'))
                                    <span class="helper-text red-text" >
                                        <strong>{{ $errors->first('dob') }}</strong>
                                    </span>
                                @endif
                                <label for="dob">Date of Birth</label>
                            </div>
                            <div class="input-field col s12 m4 l4">
                                <input id="email" name="email" type="email" class="validate">
                                @if ($errors->has('email'))
                                    <span class="helper-text red-text" >
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                                <label for="email">E-Mail</label>
                            </div>
                            <div class="input-field col s12 m4 l4">
                                <input id="password" name="password" type="password" class="validate">
                                @if ($errors->has('password'))
                                    <span class="helper-text red-text" >
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                                <label for="password">Password</label>
                            </div>

                            <div class="input-field col s12 m4 l4">
                                <input id="phone" name="phone" type="text" class="validate">
                                @if ($errors->has('phone'))
                                    <span class="helper-text red-text" >
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                                <label for="phone">Phone</label>
                            </div>
                            <div class="input-field col s12 m4 l4">
                                <select id="soo" name="soo">
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
                                <select id="lgoo" name="lgoo">
                                    <option value="" disabled selected>Choose an option</option>
                                    <option value="bichi">Bichi</option>
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
                                <input id="currentAddress" name="currentAddress" type="text" class="validate">
                                @if ($errors->has('currentAddress'))
                                    <span class="helper-text red-text" >
                                        <strong>{{ $errors->first('currentAddress') }}</strong>
                                    </span>
                                @endif
                                <label for="currentAddress">Address (current)</label>
                            </div>
                            <div class="input-field col s12 m4 l4">
                                <select id="business_id" name="business_id">
                                    <option value="" disabled selected>Choose an option</option>
                                    @if(count($data['businessDetails'] ) > 0)
                                        @foreach ($data['businessDetails'] as $business)
                                            <option value="{{$business->id}}">{{ucfirst($business->name)}}</option> 
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
                                <select id="branch_id" name="branch_id">
                                    <option value="" disabled selected>Choose an option</option>
                                    @if(count($data['branchDetails'] ) > 0)
                                        @foreach ($data['branchDetails'] as $branch)
                                            <option value="{{$branch->id}}">{{ucfirst($branch->name)}} Branch</option> 
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
                                <select id="role" name="role">
                                    <option value="" disabled selected>Choose an option</option>
                                    <option value="1">Co-owner</option>
                                    <option value="2">Administrator</option>
                                    <option value="3">Manager</option>
                                    <option value="4">Sales Representative</option>
                                </select>
                                @if ($errors->has('role'))
                                    <span class="helper-text red-text" >
                                        <strong>{{ $errors->first('role') }}</strong>
                                    </span>
                                @endif
                                <label>Position</label>
                            </div>
                            <div class="input-field btnWrap col s12 m4 l4" style="display:flex; justify-content:center;">
                                <button id="staffSettingsBtn" class="right branchSubmitBtn btn waves-effect waves-light" type="submit">Submit
                                    <i class="material-icons right">send</i>
                                </button>
                                {{-- SPINNER --}}
                               @include('components.submitPreloader')
                            </div>
                        </div>
                    </form>
                </div>
                <div class="staffSettingsTable col s12 m6 l6">
                    <table class="highlight centered responsive-table">
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Branch</th>
                                <th>Position</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['staffDetails'] as $staff)
                                <tr>
                                    <td>{{$staff->firstname}} {{$staff->lastname}}</td>
                                    <td>{{ $staff->branchName }} Branch</td>
                                    <td>
                                        @if ($staff->role == 1)
                                            Owner
                                        @elseif($staff->role == 2)
                                            Admin
                                        @elseif($staff->role == 3)
                                            Manager
                                        @elseif($staff->role == 4)
                                            Sales Rep
                                        @endif
                                    </td>
                                    <td><a href="#">View</a></td>
                                    <td>
                                        <a class="edit editCustomer" href="#edit">
                                            <i class="tiny material-icons">edit</i>
                                        </a>
                                    </td>
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
            </div>
        </div>
    </div>
@endsection
