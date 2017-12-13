@extends('layouts.outer-layout')

@section('content')
    <!-- Main Content -->
    <div class="page-wrapper pa-0 ma-0 auth-page">
        <div class="container-fluid">
            <!-- Row -->
            <div class="table-struct full-width full-height">
                <div class="table-cell vertical-align-middle auth-form-wrap">
                    <div class="auth-form  ml-auto mr-auto no-float">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <div class="mb-30">
                                    <h3 class="text-center txt-dark mb-10">Sign up to {{ env("APP_NAME", "Welory Solution") }}</h3>
                                    <h6 class="text-center nonecase-font txt-grey">Enter your details below</h6>
                                </div>  
                                <div class="form-wrap">
                                    @foreach($errors as $error)
                                        {{ $error }}
                                        @endforeach
                                    <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="form-group{{ $errors->has('name') ? ' has-error has-danger' : '' }}{{ $errors->has('name') ? ' has-error has-danger' : '' }}">
                                            <label class="control-label mb-10" for="name">Full name <span class="text-danger">*</span></label>
                                            <input value="{{ old('name') }}" type="name" name="name" class="form-control" required="" id="name" placeholder="Your name as per IC">
                                            @if($errors->has('name'))
                                                <div class="help-block with-errors">
                                                    <ul class="list-unstyled">
                                                        <li>{{ $errors->first('name') }}</li>
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="form-group{{ $errors->has('email') ? ' has-error has-danger' : '' }}">
                                            <label class="control-label mb-10" for="email">Email address <span class="text-danger">*</span></label>
                                            <input value="{{ old('email') }}" type="email" name="email" class="form-control" required="" id="email" placeholder="Enter email">
                                             @if($errors->has('email'))
                                                <div class="help-block with-errors">
                                                    <ul class="list-unstyled">
                                                        <li>{{ $errors->first('email') }}</li>
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="form-group{{ $errors->has('ic') ? ' has-error has-danger' : '' }}">
                                            <label class="pull-left control-label mb-10" for="ic-number">IC number <span class="text-danger">*</span></label>
                                            <input value="{{ old('ic') }}" type="text" name="ic" class="form-control" required="" id="ic-number" placeholder="Enter your IC number">
                                             @if($errors->has('ic'))
                                                <div class="help-block with-errors">
                                                    <ul class="list-unstyled">
                                                        <li>{{ $errors->first('ic') }}</li>
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="form-group{{ $errors->has('phone') ? ' has-error has-danger' : '' }}">
                                            <label class="pull-left control-label mb-10" for="phone-number">Phone number <span class="text-danger">*</span></label>
                                            <input value="{{ old('phone') }}" type="text" name="phone" class="form-control" required="" id="phone-number" placeholder="Enter your phone number">
                                             @if($errors->has('phone'))
                                                <div class="help-block with-errors">
                                                    <ul class="list-unstyled">
                                                        <li>{{ $errors->first('phone') }}</li>
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="form-group{{ $errors->has('bank_account_number') ? ' has-error has-danger' : '' }}">
                                            <label class="pull-left control-label mb-10" for="alt-name">Bank account number<span class="text-danger">*</span></label>
                                            <input value="{{ old('bank_account_number') }}" type="text" name="bank_account_number" class="form-control" required="" id="alt-phone" placeholder="Enter alternate contact phone number">
                                            @if($errors->has('bank_account_number'))
                                                <div class="help-block with-errors">
                                                    <ul class="list-unstyled">
                                                        <li>{{ $errors->first('bank_account_number') }}</li>
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="form-group{{ $errors->has('bank_name') ? ' has-error has-danger' : '' }}">
                                            <label class="pull-left control-label mb-10" for="alt-name">Bank name <span class="text-danger">*</span></label>
                                            <input value="{{ old('bank_name') }}" type="text" name="bank_name" class="form-control" required="" id="alt-phone" placeholder="Enter alternate contact phone number">
                                            @if($errors->has('bank_name'))
                                                <div class="help-block with-errors">
                                                    <ul class="list-unstyled">
                                                        <li>{{ $errors->first('bank_name') }}</li>
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="form-group{{ $errors->has('bitcoin_address') ? ' has-error has-danger' : '' }}">
                                            <label class="pull-left control-label mb-10" for="alt-name">Bitcoin address <span class="text-danger">*</span></label>
                                            <input value="{{ old('bitcoin_address') }}" type="text" name="bitcoin_address" class="form-control" required="" id="alt-phone" placeholder="Enter alternate contact phone number">
                                            @if($errors->has('bitcoin_address'))
                                                <div class="help-block with-errors">
                                                    <ul class="list-unstyled">
                                                        <li>{{ $errors->first('bitcoin_address') }}</li>
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="form-group{{ $errors->has('state_id') ? ' has-error has-danger' : '' }}">
                                            <label class="pull-left control-label mb-10" for="state_id">State <span class="text-danger">*</span></label>
                                                <select class="form-control select2" name="state_id" id="state_id">
                                                <option>Select area</option>
                                                @foreach( $states as $state )
                                                    <option value="{{ $state->id}}">{{ $state->name }}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('state_id'))
                                                <div class="help-block with-errors">
                                                    <ul class="list-unstyled">
                                                        <li>{{ $errors->first('state_id') }}</li>
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="form-group{{ $errors->has('alt_contact_name') ? ' has-error has-danger' : '' }}">
                                            <label class="pull-left control-label mb-10" for="alt-name">Alternate contact name <span class="text-danger">*</span></label>
                                            <input value="{{ old('alt_contact_name') }}" type="text" name="alt_contact_name" class="form-control" required="" id="alt-name" placeholder="Enter alternate contact name">
                                             @if($errors->has('alt_contact_name'))
                                                <div class="help-block with-errors">
                                                    <ul class="list-unstyled">
                                                        <li>{{ $errors->first('alt_contact_name') }}</li>
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="form-group{{ $errors->has('alt_contact_phone') ? ' has-error has-danger' : '' }}">
                                            <label class="pull-left control-label mb-10" for="alt-name">Alternate contact phone number <span class="text-danger">*</span></label>
                                            <input value="{{ old('alt_contact_phone') }}" type="text" name="alt_contact_phone" class="form-control" required="" id="alt-phone" placeholder="Enter alternate contact phone number">
                                            @if($errors->has('alt_contact_phone'))
                                                <div class="help-block with-errors">
                                                    <ul class="list-unstyled">
                                                        <li>{{ $errors->first('alt_contact_phone') }}</li>
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Start investor field -->
                                        @if( request()->input('as') == "investor" )
                                            <div class="form-group{{ $errors->has('payment_slip') ? ' has-error has-danger' : '' }} mb-30">
                                                <label class="control-label mb-10 text-left">Payment slip upload <span class="text-danger">*</span></label>
                                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                                    <div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                                    <span class="input-group-addon fileupload btn btn-info btn-anim btn-file"><i class="fa fa-upload"></i> <span class="fileinput-new btn-text">Select file</span> <span class="fileinput-exists btn-text">Change</span>
                                                    <input type="file" accept="image/*" name="payment_slip">
                                                    </span> <a href="#" class="input-group-addon btn btn-danger btn-anim fileinput-exists" data-dismiss="fileinput"><i class="fa fa-trash"></i><span class="btn-text"> Remove</span></a> 
                                                </div>
                                                @if($errors->has('payment_slip'))
                                                <div class="help-block with-errors">
                                                    <ul class="list-unstyled">
                                                        <li>{{ $errors->first('payment_slip') }}</li>
                                                    </ul>
                                                </div>
                                            @endif
                                            </div>
                                            <div class="form-group{{ $errors->has('contract_upload') ? ' has-error has-danger' : '' }} mb-30">
                                                <label class="control-label mb-10 text-left">Management agreement upload <span class="text-danger">*</span></label>
                                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                                    <div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                                    <span class="input-group-addon fileupload btn btn-info btn-anim btn-file"><i class="fa fa-upload"></i> <span class="fileinput-new btn-text">Select file</span> <span class="fileinput-exists btn-text">Change</span>
                                                    <input type="file" accept=".pdf" name="contract_upload">
                                                    </span> <a href="#" class="input-group-addon btn btn-danger btn-anim fileinput-exists" data-dismiss="fileinput"><i class="fa fa-trash"></i><span class="btn-text"> Remove</span></a> 
                                                </div>
                                                <div class="help block">
                                                    <ul class="list-unstyled">
                                                        <li>Please <a target="__blank" href="{{ url('/downloads/Management Agreement.pdf') }}" class="txt-primary">download</a> and upload the signed agreement</li>
                                                    </ul>
                                                </div>
                                                @if($errors->has('contract_upload'))
                                                <div class="help-block with-errors">
                                                    <ul class="list-unstyled">
                                                        <li>{{ $errors->first('contract_upload') }}</li>
                                                    </ul>
                                                </div>
                                            @endif
                                            </div>
                                        @endif
                                        <!-- End investor field -->

                                        <!-- Start agent field -->
                                        @if( request()->input('as') == "agent" )
                                            <div class="form-group{{ $errors->has('ic_copy') ? ' has-error has-danger' : '' }} mb-30">
                                                <label class="control-label mb-10 text-left">IC copy upload <span class="text-danger">*</span></label>
                                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                                    <div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                                    <span class="input-group-addon fileupload btn btn-info btn-anim btn-file"><i class="fa fa-upload"></i> <span class="fileinput-new btn-text">Select file</span> <span class="fileinput-exists btn-text">Change</span>
                                                    <input type="file" accept="image/*" name="ic_copy">
                                                    </span> <a href="#" class="input-group-addon btn btn-danger btn-anim fileinput-exists" data-dismiss="fileinput"><i class="fa fa-trash"></i><span class="btn-text"> Remove</span></a> 
                                                </div>
                                                @if($errors->has('ic_copy'))
                                                <div class="help-block with-errors">
                                                    <ul class="list-unstyled">
                                                        <li>{{ $errors->first('ic_copy') }}</li>
                                                    </ul>
                                                </div>
                                            @endif
                                            </div>
                                            <div class="form-group{{ $errors->has('terms') ? ' has-error has-danger' : '' }}">
                                                <div class="checkbox checkbox-primary pr-10 pull-left">
                                                    <input name="terms" id="terms" required="" type="checkbox">
                                                    <label for="terms"> I have read and agree to all <a target="__blank" href="{{ url('/downloads/Marketing Structure.pdf') }}" class="txt-primary">Terms and conditions</a> <span class="text-danger">*</span></label>
                                                     @if($errors->has('terms'))
                                                        <div class="help-block with-errors">
                                                            <ul class="list-unstyled">
                                                                <li>{{ $errors->first('terms') }}</li>
                                                            </ul>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        
                                        @endif
                                        <input type="hidden" name="type" value="{{ request()->input('as') }}">
                                        <!-- End agent field -->

                                        <!-- End all fields -->
                                        <div class="form-group text-center">
                                            <input type="hidden" name="referrer_user" value="{{ request()->input('r') }}">
                                            <button type="submit" class="btn btn-info btn-rounded">Sign Up</button>
                                        </div>
                                    </form>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Row -->   
        </div>
        
    </div>
    <!-- /Main Content -->
@endsection

@section('js')
    <script src="{{ asset('js/vendors/jasny-bootstrap/jasny-bootstrap.min.js') }}"></script>
    <script>
        $(".select2").select2();
    </script>
@endsection