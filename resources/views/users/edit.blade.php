@extends('layouts.app')

@section('content')
	<!-- header -->
	<div class="row heading-bg">
		
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h5 class="txt-dark">My profile</h5>
		</div>

		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
		  	<ol class="breadcrumb">
				<li><a href="{{ route('home') }}">Dashboard</a></li>
				<li class="active"><span>My profile</span></li>
		  	</ol>
		</div>
	</div>
	<!-- end header -->
	<div class="row">
		<div class="col-md-6">
			@component('components.panel')
				@slot('heading')
					Information
				@endslot

				<form action="@if(auth()->user()->is_admin){{ route('user.edit', $user->id) }} @else {{ route('user.profile') }} @endif" method="POST" enctype="multipart/form-data">
				    {{ csrf_field() }}
				   	@component('components.input') 
						@slot('input_name')
							name
						@endslot

						@slot('input_type')
							text
						@endslot

						@slot('input_value')
							{{ $user->name }}
						@endslot

						@slot('input_placeholder')
							Full name as per IC
						@endslot

						Full name <span class="text-danger">*</span>

						@slot('show_only')
							@if( $user->is_verified && !auth()->user()->is_admin ) true @endif
						@endslot
				   	@endcomponent

				   	@component('components.input') 
				   		@slot('input_name')
				   			email
				   		@endslot
				   	
				   		@slot('input_type')
				   			email
				   		@endslot
				   	
				   		@slot('input_value')
				   			{{ $user->email }}
				   		@endslot
				   		
				   		@slot('input_placeholder')
							Email address 
						@endslot

				   		Email address <span class="text-danger">*</span>

				   		@slot('show_only')
							@if( $user->is_verified && !auth()->user()->is_admin ) true @endif
						@endslot
				   	@endcomponent
				    
				    @component('components.input') 
				    	@slot('input_name')
				    		ic
				    	@endslot
				    
				    	@slot('input_type')
				    		text
				    	@endslot
				    
				    	@slot('input_value')
				    		{{ $user->ic }}
				    	@endslot
				    
				    	@slot('input_placeholder')
				    		Enter IC number
				    	@endslot
				    	
				    	IC number <span class="text-danger">*</span>
				    
				    	@slot('show_only')
				    		@if( $user->is_verified && !auth()->user()->is_admin ) true @endif
				    	@endslot
				    @endcomponent

				    @component('components.input') 
				    	@slot('input_name')
				    		phone
				    	@endslot
				    
				    	@slot('input_type')
				    		text
				    	@endslot
				    
				    	@slot('input_value')
				    		{{ $user->phone }}
				    	@endslot
				    
				    	@slot('input_placeholder')
				    		Enter phone number
				    	@endslot
				    	
				    	Phone number <span class="text-danger">*</span>
				    
				    	@slot('show_only')
				    		@if( $user->is_verified && !auth()->user()->is_admin ) true @endif
				    	@endslot
				    @endcomponent

				    @component('components.input') 
				    	@slot('input_name')
				    		bank_name
				    	@endslot
				    
				    	@slot('input_type')
				    		text
				    	@endslot
				    
				    	@slot('input_value')
				    		{{ $user->bank_name }}
				    	@endslot
				    
				    	@slot('input_placeholder')
				    		Enter bank name
				    	@endslot
				    	
				    	Bank name <span class="text-danger">*</span>
				    
				    	@slot('show_only')
				    		@if( $user->is_verified && !auth()->user()->is_admin ) true @endif
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
				    		{{ $user->bank_account_number }}
				    	@endslot
				    
				    	@slot('input_placeholder')
				    		Enter bank account number
				    	@endslot
				    	
				    	Bank account number <span class="text-danger">*</span>
				    
				    	@slot('show_only')
				    		@if( $user->is_verified && !auth()->user()->is_admin ) true @endif
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
				    		{{ $user->bitcoin_address }}
				    	@endslot
				    
				    	@slot('input_placeholder')
				    		Enter bitcoin address
				    	@endslot
				    	
				    	Bitcoin address <span class="text-danger">*</span>
				    
				    	@slot('show_only')
				    		@if( $user->is_verified && !auth()->user()->is_admin ) true @endif
				    	@endslot
				    @endcomponent
				    
				    <div class="form-group{{ $errors->has('state_id') ? ' has-error has-danger' : '' }}">
	                    <label class="pull-left control-label mb-10" for="state_id">Area <span class="text-danger">*</span></label>
	                    <select class="form-control select2" name="state_id" id="state_id">
	                        <option>Select area</option>
	                        @foreach( $states as $state )
	                            <option @if(isset($user) && $user->state_id == $state->id) selected @endif value="{{ $state->id }}">{{ $state->name }}</option>
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
				        <input value="{{ $user->alt_contact_name }}" type="text" name="alt_contact_name" class="form-control" required="" id="alt-name" placeholder="Enter alternate contact name">
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
				        <input value="{{ $user->alt_contact_phone }}" type="text" name="alt_contact_phone" class="form-control" required="" id="alt-phone" placeholder="Enter alternate contact phone number">
				         @if($errors->has('alt_contact_phone'))
				            <div class="help-block with-errors">
				                <ul class="list-unstyled">
				                    <li>{{ $errors->first('alt_contact_phone') }}</li>
				                </ul>
				            </div>
				        @endif
				    </div>

				    @if( empty( $user->investor_agreement_path ) )
				    <!-- Start investor field -->
				        <div class="form-group mb-30">
				            <label class="control-label mb-10 text-left">Management agreement upload</label>
				            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
				                <div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
				                <span class="input-group-addon fileupload btn btn-info btn-anim btn-file"><i class="fa fa-upload"></i> <span class="fileinput-new btn-text">Select file</span> <span class="fileinput-exists btn-text">Change</span>
				                <input type="file" accept=".pdf" name="investor_agreement_path">
				                </span> <a href="#" class="input-group-addon btn btn-danger btn-anim fileinput-exists" data-dismiss="fileinput"><i class="fa fa-trash"></i><span class="btn-text"> Remove</span></a> 
				            </div>
				        </div>
				    <!-- End investor field -->
					@endif
					
					@if( empty( $user->ic_image_path ) )
				    <!-- Start agent field -->
				        <div class="form-group mb-30">
				            <label class="control-label mb-10 text-left">IC copy upload</label>
				            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
				                <div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
				                <span class="input-group-addon fileupload btn btn-info btn-anim btn-file"><i class="fa fa-upload"></i> <span class="fileinput-new btn-text">Select file</span> <span class="fileinput-exists btn-text">Change</span>
				                <input type="file" accept="image/*" name="ic_image_path">
				                </span> <a href="#" class="input-group-addon btn btn-danger btn-anim fileinput-exists" data-dismiss="fileinput"><i class="fa fa-trash"></i><span class="btn-text"> Remove</span></a> 
				            </div>
				        </div>
				        <div class="form-group{{ $errors->has('terms') ? ' has-error has-danger' : '' }}">
                            <div class="checkbox checkbox-primary pr-10 pull-left">
                                <input name="terms" id="terms" type="checkbox">
                                <label for="terms"> I have read and agree to all <a target="__blank" href="{{ url('/downloads/Marketing Structure.pdf') }}" class="txt-primary">Terms and conditions</a> </label>
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
				    <!-- End agent field -->
					@endif

				    <!-- End all fields -->
				    <div class="form-group">
				        <button type="submit" class="btn btn-info btn-rounded">Update profile</button>
				    </div>
				</form>

			@endcomponent
		</div>
		<div class="col-md-6">
			@component('components.panel')
				@slot('heading')
					Payments
				@endslot
			
				@component('components.modal')
					@slot('button')
						Add payment
					@endslot

					@slot('title')
						Add payment
					@endslot

					@slot('modal_id')
						add-payment
					@endslot

					@slot('action_button')
						<button type="button" class="btn btn-success" onclick="$('#add-payment-form').submit()">Confirm payment</button>
					@endslot

					<form action="{{ route('payments') }}" method="POST" id="add-payment-form" enctype="multipart/form-data">
						{{ csrf_field() }}
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

                        	@if(request()->is('user/*')) 
								<input type="hidden" name="user_id" value="{{ $user->id }}">
                        	@endif
                        </div>
					</form>
				@endcomponent

				<div class="table-wrap">
					<div class="mt-40">
						<table class="tablesaw table-bordered table-hover table" data-tablesaw-mode="swipe" data-tablesaw-sortable data-tablesaw-sortable-switch data-tablesaw-minimap data-tablesaw-mode-switch>
							<thead>
								<tr>
								 	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Payment ID</th>
								  	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Amount</th>
								  	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Date</th>
								  	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Actions</th>
								</tr>
							</thead>
							<tbody>
								@foreach( $user->payments as $payment )
									<tr>
									  	<td class="title">{{ $payment->id }}</td>
									  	<td>@if($payment->amount > 0){{ $payment->amount }}@else Pending verification @endif</td>
									  	<td>{{ $payment->created_at->toDateString() }}</td>
									  	<td>
									  		<div class="button-list">
									  			@component('components.modal')
													@slot('button')
														View payment slip
													@endslot

													@slot('modal_id')
														payment-modal-{{ $payment->id }}
													@endslot

													@slot('title')
														Payment {{ $payment->id }}
													@endslot

													<div class="row">
														<div class="col-md-12">
															<img src="{{ $payment->payment_slip_path }}" class="img-responsive">										
														</div>
													</div>

													@slot('action_button')
														
													@endslot
									  			@endcomponent
											</div>
									  	</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			@endcomponent

			@component('components.panel')
				@slot('heading')
					Change password
				@endslot

				@slot('custom_class')
					@if($user->is_default_password)
						panel-danger
					@endif
				@endslot

				@slot('custom_message')
					@if($user->is_default_password)
						(Recommended)
					@endif
				@endslot
			
				<form action="{{ route('password', $user->id) }}" method="POST">
					{{ csrf_field() }}
					@component('components.input') 
						@slot('input_name')
							current_password
						@endslot
					
						@slot('input_type')
							password
						@endslot
					
						@slot('input_value')
							
						@endslot
					
						@slot('input_placeholder')
							Enter current password
						@endslot
						
						Old password
					
						@slot('show_only')
							false
						@endslot
					@endcomponent

					@component('components.input') 
						@slot('input_name')
							new_password
						@endslot
					
						@slot('input_type')
							password
						@endslot
					
						@slot('input_value')
							
						@endslot
					
						@slot('input_placeholder')
							Preferred new password
						@endslot
						
						New password
					
						@slot('show_only')
							false
						@endslot
					@endcomponent
					
					@component('components.input') 
						@slot('input_name')
							new_password_confirmation
						@endslot
					
						@slot('input_type')
							password
						@endslot
					
						@slot('input_value')
							
						@endslot
					
						@slot('input_placeholder')
							Enter your new password again
						@endslot
						
						Confirm new password
					
						@slot('show_only')
							false
						@endslot
					@endcomponent

					<button type="submit" class="btn btn-info btn-rounded">Change password</button>
				</form>
			@endcomponent
		</div>
	</div>
@endsection

@section('js')
    <script src="{{ asset('js/vendors/jasny-bootstrap/jasny-bootstrap.min.js') }}"></script>
    <script>
    	$(".select2").select2();
    </script>
@endsection