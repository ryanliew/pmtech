@extends('layouts.app')

@section('content')
	<!-- header -->
	<div class="row heading-bg">
		
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h5 class="txt-dark">Create user</h5>
		</div>

		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
		  	<ol class="breadcrumb">
				<li><a href="{{ route('home') }}">Dashboard</a></li>
				<li class="active"><span>Create user</span></li>
		  	</ol>
		</div>
	</div>
	<!-- end header -->
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
			    @component('components.input') 
				    	@slot('input_name')
				    		bank_name
				    	@endslot
				    
				    	@slot('input_type')
				    		text
				    	@endslot
				    
				    	@slot('input_value')
				    	@endslot
				    
				    	@slot('input_placeholder')
				    		Enter bank name
				    	@endslot
				    	
				    	Bank name <span class="text-danger">*</span>
				    
				    	@slot('show_only')
				    		false
				    	@endslot
				    @endcomponent

				    @component('components.input') 
				    	@slot('input_name')
				    		bank_account_number
				    	@endslot
				    
				    	@slot('input_type')
				    		text
				    	@endslot
				    
				    	@slot('input_value')
				    	@endslot
				    
				    	@slot('input_placeholder')
				    		Enter bank account number
				    	@endslot
				    	
				    	Bank account number <span class="text-danger">*</span>
				    
				    	@slot('show_only')
				    		false
				    	@endslot
				    @endcomponent

				    @component('components.input') 
				    	@slot('input_name')
				    		bitcoin_address
				    	@endslot
				    
				    	@slot('input_type')
				    		text
				    	@endslot
				    
				    	@slot('input_value')
				    	@endslot
				    
				    	@slot('input_placeholder')
				    		Enter bitcoin address
				    	@endslot
				    	
				    	Bitcoin address <span class="text-danger">*</span>
				    
				    	@slot('show_only')
				    		false
				    	@endslot
				    @endcomponent
			    <div class="form-group{{ $errors->has('state_id') ? ' has-error has-danger' : '' }}">
                    <label class="pull-left control-label mb-10" for="state_id">Area <span class="text-danger">*</span></label>
                    <select class="form-control select2" name="state_id" id="state_id">
                        <option>Select area</option>
                        @foreach( $states as $state )
                            <option value="{{ $state->id }}">{{ $state->name }}</option>
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
		        <div class="form-group mb-30">
		            <label class="control-label mb-10 text-left">Payment slip upload</label>
		            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
		                <div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
		                <span class="input-group-addon fileupload btn btn-info btn-anim btn-file"><i class="fa fa-upload"></i> <span class="fileinput-new btn-text">Select file</span> <span class="fileinput-exists btn-text">Change</span>
		                <input type="file" accept="image/*" name="payment_slip">
		                </span> <a href="#" class="input-group-addon btn btn-danger btn-anim fileinput-exists" data-dismiss="fileinput"><i class="fa fa-trash"></i><span class="btn-text"> Remove</span></a> 
		            </div>
		        </div>

		        @if( empty( $user->investor_agreement_path ) )

			        <div class="form-group mb-30">
			            <label class="control-label mb-10 text-left">Management agreement upload</label>
			            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
			                <div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
			                <span class="input-group-addon fileupload btn btn-info btn-anim btn-file"><i class="fa fa-upload"></i> <span class="fileinput-new btn-text">Select file</span> <span class="fileinput-exists btn-text">Change</span>
			                <input type="file" accept=".pdf" name="contract_upload">
			                </span> <a href="#" class="input-group-addon btn btn-danger btn-anim fileinput-exists" data-dismiss="fileinput"><i class="fa fa-trash"></i><span class="btn-text"> Remove</span></a> 
			            </div>
			        </div>

				@endif
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
			        <button type="submit" class="btn btn-info btn-rounded">Add user</button>
			    </div>
			</form>
		</div>
	</div>
@endsection

@section('js')
    <script src="{{ asset('js/vendors/jasny-bootstrap/jasny-bootstrap.min.js') }}"></script>
    <script>
    	$(".select2").select2();
    </script>
@endsection