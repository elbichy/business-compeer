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
                                <input id="name" name="name" type="text" class="validate" required value="{{ count($data['businessDetails']) > 0 ? $data['businessDetails'][0]->name : '' }}">
                                    @if ($errors->has('name'))
                                        <span class="helper-text red-text" >
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                    <label for="name">Business Name</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                    <input id="cac" name="cac" type="number" class="validate" required value="{{ count($data['businessDetails']) > 0 ? $data['businessDetails'][0]->cac : '' }}">
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
                                    <input id="nature" name="nature" type="text" class="validate" required value="{{ count($data['businessDetails']) > 0 ? $data['businessDetails'][0]->nature : '' }}">
                                    @if ($errors->has('nature'))
                                        <span class="helper-text red-text" >
                                            <strong>{{ $errors->first('nature') }}</strong>
                                        </span>
                                    @endif
                                    <label for="nature">Nature of Business</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                    <input id="website" name="website" type="text" value="{{ count($data['businessDetails']) > 0 ? $data['businessDetails'][0]->website : '' }}">
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
                                    <input id="phone" name="phone" type="text" value="{{ count($data['businessDetails']) > 0 ? $data['businessDetails'][0]->phone : '' }}">
                                    @if ($errors->has('phone'))
                                        <span class="helper-text red-text" >
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                    @endif
                                    <label for="phone">Phone</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="file-field input-field col s12 m8 l8">
                                    <div class="btn btn-small blue" style="width:100%;">
                                        <span>Upload logo</span>
                                        {!! count($data['businessDetails']) != 0 && $data['businessDetails'][0]->logo !=NULL ? '<i class="material-icons right">done_all</i>' : '' !!}
                                        <input type="file" name="logo" id="logo">
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
                        <thead>
                            <tr>
                                <th>Business Name</th>
                                <th>CAC Number</th>
                                <th>Nature of business</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['businessDetails'] as $business)
                            <tr>
                                <td><a href="#">{{ ucfirst($business->name) }}</a></td>
                                <td>{{ $business->cac }}</td>
                                <td>{{ $business->nature }}</td>
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
