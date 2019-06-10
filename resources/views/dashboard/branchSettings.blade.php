@extends('layouts.app')

@section('content')
    <div class="my-content-wrapper">
        <div class="content-container">
            <div class="row branchSettingsWrap">
                <h5 class="center branchSettingsHeading">Branch Settings</h5>
                <div class="branchSettingsForms col s12 m6 l6">
                    <form action="{{ route('storeBranchSettings') }}" method="post" name="branchSettingsForms" class="branchSettingsForms">
                        @csrf    
                        <div class="row">
                            <div class="input-field col s12 m6 l6">
                                <select id="business_id" name="business_id" class="validate" required>
                                    <option value="" disabled selected>Choose an option</option>
                                    @if (count($data['businessDetails']) == 1)
                                        @foreach ($data['businessDetails'] as $business)
                                            <option value="{{$business->id}}" selected>{{$business->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <label for="business_id">Select Business</label>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <select id="name" name="name" class="validate" required>
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
                            <div class="input-field col s12">
                                <input id="address" name="address" type="text" required>
                                @if ($errors->has('address'))
                                    <span class="helper-text red-text" >
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                                <label for="address">Address</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12 m4 l6" style="display:flex; justify-content:center;">
                                <button class="getCoordinates btn right blue waves-effect waves-light" type="button">
                                    Generate Coordinates
                                </button>
                            </div>
                            <div class="input-field col s12 m3 l3">
                                <input id="latitude" name="latitude" type="text" value="0" readonly>
                                @if ($errors->has('latitude'))
                                    <span class="helper-text red-text" >
                                        <strong>{{ $errors->first('latitude') }}</strong>
                                    </span>
                                @endif
                                <label for="latitude">Latitude</label>
                            </div>
                            <div class="input-field col s12 m3 l3">
                                <input id="longitude" name="longitude" type="text" value="0" readonly>
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
                                <input id="commissionDate" name="commissionDate" type="date">
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
                                <input id="openHour" name="openHour" type="text" class="validate timepicker" required>
                                @if ($errors->has('openHour'))
                                    <span class="helper-text red-text" >
                                        <strong>{{ $errors->first('openHour') }}</strong>
                                    </span>
                                @endif
                                <label for="openHour">Opening Hour</label>
                            </div>
                            <div class="input-field col s12 m4 l4">
                                <input id="closeHour" name="closeHour" type="text" class="validate timepicker" required>
                                @if ($errors->has('closeHour'))
                                    <span class="helper-text red-text" >
                                        <strong>{{ $errors->first('closeHour') }}</strong>
                                    </span>
                                @endif
                                <label for="closeHour">Closing Hour</label>
                            </div>
                            <div class="input-field btnWrap col s12 m4 l4" style="display:flex; justify-content:center;">
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
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['branchDetails'] as $branch)
                            <tr>
                                <td>{{ ucfirst($branch->name) }}</td>
                                <td>{{ $branch->address }}</td>
                                <td><a href="{{url('/dashboard/viewBranch').'/'.$branch->id}}">View</a></td>
                                <td>
                                    <a class="edit editBranch" href="{{url('/dashboard/editBranch').'/'.$branch->id}}">
                                        <i class="tiny material-icons">edit</i>
                                    </a>
                                </td>
                                <td>
                                    <a class="delete deleteBranch" href="#delete" data-branchId="{{ $branch->id }}">
                                        <i class="tiny material-icons">close</i>
                                    </a>
                                </td>

                                {{-- DELETE SALES FORM --}}
                                <form action="" method="post" id="deleteBranchForm">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="branchId">
                                </form>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endsection