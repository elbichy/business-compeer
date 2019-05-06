@extends('layouts.app')

@section('content')

    <div class="my-content-wrapper">
        <div class="content-container">
            <div class="row businessSettingsWrap">
                <h5 class="center businessSettingsHeading">Business Settings</h5>
                <div class="businessSettingsForms col s12 m6 l6">
                    {{-- BUSINESS INFO FORM --}}
                    <div id="businessDetailsForm" class="col s12">
                        <form enctype="multipart/form-data" action="{{ url('storeBusinessSettings') }}" method="post" name="businessSettingsForms" class="businessSettingsForm">
                            @csrf
                            <div class="row">
                                <div class="input-field col s12 m6 l6">
                                <input id="name" name="name" type="text" class="validate" value="{{ count($data['businessDetails']) > 0 ? $data['businessDetails'][0]->name : '' }}">
                                    @if ($errors->has('name'))
                                        <span class="helper-text red-text" >
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                    <label for="name">Business Name</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                    <input id="cac" name="cac" type="number" class="validate" value="{{ count($data['businessDetails']) > 0 ? $data['businessDetails'][0]->cac : '' }}">
                                    @if ($errors->has('cac'))
                                        <span class="helper-text red-text" >
                                            <strong>{{ $errors->first('cac') }}</strong>
                                        </span>
                                    @endif
                                    <label for="cac">CAC Reg Number</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s12 m6 l6">
                                    <input id="nature" name="nature" type="text" class="validate" value="{{ count($data['businessDetails']) > 0 ? $data['businessDetails'][0]->nature : '' }}">
                                    @if ($errors->has('nature'))
                                        <span class="helper-text red-text" >
                                            <strong>{{ $errors->first('nature') }}</strong>
                                        </span>
                                    @endif
                                    <label for="nature">Nature of Business</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                    <input id="website" name="website" type="text" class="validate" value="{{ count($data['businessDetails']) > 0 ? $data['businessDetails'][0]->website : '' }}">
                                    @if ($errors->has('website'))
                                        <span class="helper-text red-text" >
                                            <strong>{{ $errors->first('website') }}</strong>
                                        </span>
                                    @endif
                                    <label for="website">Website</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s12 m6 l6">
                                    <input id="email" name="email" type="email" class="validate" value="{{ count($data['businessDetails']) > 0 ? $data['businessDetails'][0]->email : '' }}">
                                    @if ($errors->has('email'))
                                        <span class="helper-text red-text" >
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                    <label for="email">E-mail Address</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                    <input id="phone" name="phone" type="text" class="validate" value="{{ count($data['businessDetails']) > 0 ? $data['businessDetails'][0]->phone : '' }}">
                                    @if ($errors->has('phone'))
                                        <span class="helper-text red-text" >
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                    @endif
                                    <label for="phone">Phone</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="file-field input-field col s6 m8 l8">
                                    <div class="btn btn-small blue">
                                        <span>Upload logo</span>
                                        <input type="file" name="logo" id="logo" required>
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate" type="text">
                                    </div>
                                </div>
                                <div class="input-field btnWrap col s12 m4 l4" style="display:flex; justify-content:center;">
                                    <button id="businessSettingsBtn" class="right addSaleSubmitBtn btn waves-effect waves-light" type="submit" name="action">Submit
                                        <i class="material-icons right">send</i>
                                    </button>
                                    {{-- SPINNER --}}
                                   @include('components.submitPreloader')
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="businessSettingsTable col s12 m6 l6">
                    <table>
                        <tbody>
                            <tr>
                                <td colspan="2">
                                    @if (count($data['businessDetails']) == 1)
                                        @foreach ($data['businessDetails'] as $business)
                                            <img class="circle" src="{{asset('storage').'/site/'.$business->logo}}" class="left">
                                        @endforeach    
                                    @else
                                        <img class="circle" src="{{asset('storage/logo.jpg')}}" class="left">
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Business Name:</td>
                                <td>
                                    @if (count($data['businessDetails']) == 1)
                                        @foreach ($data['businessDetails'] as $business)
                                            {{$business->name}}
                                        @endforeach    
                                    @else
                                        Business Name here
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>CAC Number:</td>
                                <td>
                                    @if (count($data['businessDetails']) == 1)
                                        @foreach ($data['businessDetails'] as $business)
                                            {{$business->cac}}
                                        @endforeach    
                                    @else
                                        CAC Number here
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Nature of business:</td>
                                <td>
                                    @if (count($data['businessDetails']) == 1)
                                        @foreach ($data['businessDetails'] as $business)
                                            {{$business->nature}}
                                        @endforeach    
                                    @else
                                        Nature of Business here
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Website:</td>
                                <td>
                                    @if (count($data['businessDetails']) == 1)
                                        @foreach ($data['businessDetails'] as $business)
                                            {{$business->website}}
                                        @endforeach    
                                    @else
                                        Website here
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Email:</td>
                                <td>
                                    @if (count($data['businessDetails']) == 1)
                                        @foreach ($data['businessDetails'] as $business)
                                            {{$business->email}}
                                        @endforeach    
                                    @else
                                        Email here
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Phone:</td>
                                <td>
                                    @if (count($data['businessDetails']) == 1)
                                        @foreach ($data['businessDetails'] as $business)
                                            {{$business->phone}}
                                        @endforeach    
                                    @else
                                        Phone here
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
