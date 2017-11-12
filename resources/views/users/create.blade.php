@extends('layouts.app')

@section('content')
	<div class="row">
		<div class="col-md-12">
			<form action="{{ route('user.create') }}" method="POST" enctype="multipart/form-data">
			    {{ csrf_field() }}
			    <div class="form-group{{ $errors->has('name') ? ' has-error has-danger' : '' }}{{ $errors->has('name') ? ' has-error has-danger' : '' }}">
			        <label class="control-label mb-10" for="name">Full name <span class="text-danger">*</span></label>
			        <input value="{{ old('name') }}" type="name" name="name" class="form-control" required="" id="name" placeholder="Name as per IC">
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
			        <input value="{{ old('ic') }}" type="text" name="ic" class="form-control" required="" id="ic-number" placeholder="Enter IC number">
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
			        <input value="{{ old('phone') }}" type="text" name="phone" class="form-control" required="" id="phone-number" placeholder="Enter phone number">
			         @if($errors->has('phone'))
			            <div class="help-block with-errors">
			                <ul class="list-unstyled">
			                    <li>{{ $errors->first('phone') }}</li>
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
		        <div class="form-group mb-30">
		            <label class="control-label mb-10 text-left">Payment slip upload</label>
		            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
		                <div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
		                <span class="input-group-addon fileupload btn btn-info btn-anim btn-file"><i class="fa fa-upload"></i> <span class="fileinput-new btn-text">Select file</span> <span class="fileinput-exists btn-text">Change</span>
		                <input type="file" accept="image/*" name="payment_slip">
		                </span> <a href="#" class="input-group-addon btn btn-danger btn-anim fileinput-exists" data-dismiss="fileinput"><i class="fa fa-trash"></i><span class="btn-text"> Remove</span></a> 
		            </div>
		        </div>
			    <!-- End investor field -->

			    <!-- Start agent field -->
		        <div class="form-group mb-30">
		            <label class="control-label mb-10 text-left">IC copy upload</label>
		            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
		                <div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
		                <span class="input-group-addon fileupload btn btn-info btn-anim btn-file"><i class="fa fa-upload"></i> <span class="fileinput-new btn-text">Select file</span> <span class="fileinput-exists btn-text">Change</span>
		                <input type="file" accept="image/*" name="ic_copy">
		                </span> <a href="#" class="input-group-addon btn btn-danger btn-anim fileinput-exists" data-dismiss="fileinput"><i class="fa fa-trash"></i><span class="btn-text"> Remove</span></a> 
		            </div>
		        </div>
			    <!-- End agent field -->

			    <!-- End all fields -->
			    <div class="form-group">
			        <div class="checkbox checkbox-primary pr-10 pull-left">
			            <input name="verified" id="verified" type="checkbox">
			            <label for="verified"> Is user verified</label>
			        </div>
			        <div class="clearfix"></div>
			    </div>
			    <div class="form-group">
			        <button type="submit" class="btn btn-info btn-rounded">Add user</button>
			    </div>
			</form>
		</div>
	</div>
@endsection

@section('js')
    <script src="{{ asset('js/vendors/jasny-bootstrap/jasny-bootstrap.min.js') }}"></script>
@endsection