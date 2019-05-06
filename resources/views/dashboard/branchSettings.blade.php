@extends('layouts.app')

@section('content')
    <div class="my-content-wrapper">
        <div class="content-container">
            <div class="row branchSettingsWrap">
                <h5 class="center branchSettingsHeading">Branch Settings</h5>
                <div class="branchSettingsForms col s12 m6 l6">
                    <form action="{{ url('storeBranchSettings') }}" method="post" name="branchSettingsForms" class="branchSettingsForms">
                        @csrf    
                        <div class="row">
                            <div class="input-field col s12 m6 l6">
                                <select id="business_id" name="business_id" class="validate">
                                    <option value="" disabled selected>Choose an option</option>
                                    @if (count($data['businessDetails']) == 1)
                                        @foreach ($data['businessDetails'] as $business)
                                            <option value="{{$business->id}}">{{$business->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <label for="business_id">Select Business</label>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <select id="name" name="name" class="validate">
                                    <option value="" disabled selected>Choose an option</option>
                                    <option value="head">Head Branch</option>
                                    <option value="second">2nd Branch</option>
                                    <option value="third">3rd Branch</option>
                                    <option value="fouth">4th Branch</option>
                                    <option value="fifth">5th Branch</option>
                                </select>
                                <label for="name">Select Branch</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12 m6 l6">
                                <input id="address" name="address" type="text" class="validate">
                                @if ($errors->has('address'))
                                    <span class="helper-text red-text" >
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                                <label for="address">Address</label>
                            </div>
                            <div class="input-field col s12 m3 l3">
                                <input id="latitude" name="latitude" type="text" class="validate">
                                @if ($errors->has('latitude'))
                                    <span class="helper-text red-text" >
                                        <strong>{{ $errors->first('latitude') }}</strong>
                                    </span>
                                @endif
                                <label for="latitude">Latitude</label>
                            </div>
                            <div class="input-field col s12 m3 l3">
                                <input id="longitude" name="longitude" type="text" class="validate">
                                @if ($errors->has('longitude'))
                                    <span class="helper-text red-text" >
                                        <strong>{{ $errors->first('longitude') }}</strong>
                                    </span>
                                @endif
                                <label for="longitude">Longitude</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12 m6 l6">
                                <input id="phone" name="phone" type="text" class="validate">
                                @if ($errors->has('phone'))
                                    <span class="helper-text red-text" >
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                                <label for="phone">Phone</label>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <input id="commissionDate" name="commissionDate" type="date" class="validate">
                                @if ($errors->has('commissionDate'))
                                    <span class="helper-text red-text" >
                                        <strong>{{ $errors->first('commissionDate') }}</strong>
                                    </span>
                                @endif
                                <label for="commissionDate">Commission Date</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12 m4 l4">
                                <input id="openHour" name="openHour" type="text" class="validate timepicker">
                                @if ($errors->has('openHour'))
                                    <span class="helper-text red-text" >
                                        <strong>{{ $errors->first('openHour') }}</strong>
                                    </span>
                                @endif
                                <label for="openHour">Opening Hour</label>
                            </div>
                            <div class="input-field col s12 m4 l4">
                                <input id="closeHour" name="closeHour" type="text" class="validate timepicker">
                                @if ($errors->has('closeHour'))
                                    <span class="helper-text red-text" >
                                        <strong>{{ $errors->first('closeHour') }}</strong>
                                    </span>
                                @endif
                                <label for="closeHour">Closing Hour</label>
                            </div>
                            <div class="input-field btnWrap col s4 m4 l4" style="display:flex; justify-content:center;">
                                <button id="branchSettingsBtn" class="right branchSubmitBtn btn waves-effect waves-light" type="submit">Submit
                                    <i class="material-icons right">send</i>
                                </button>
                                {{-- SPINNER --}}
                               @include('components.submitPreloader')
                            </div>
                        </div>
                    </form>
                </div>
                <div class="branchSettingsTable col s12 m6 l6">
                    <table class="highlight centered responsive-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Opens</th>
                                <th>Closes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['branchDetails'] as $branch)
                            <tr>
                                <td>{{ ucfirst($branch->name) }}</td>
                                <td>{{ $branch->address }}</td>
                                <td>{{ $branch->phone }}</td>
                                <td>{{ $branch->openHour }}</td>
                                <td>{{ $branch->closeHour }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endsection