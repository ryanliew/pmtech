@extends('layouts.app')

@section('content')
	<!-- header -->
	<div class="row heading-bg">
		
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h5 class="txt-dark">User detail</h5>
		</div>

		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
		  	<ol class="breadcrumb">
				<li><a href="{{ route('home') }}">Dashboard</a></li>
				<li><a href="{{ route('users') }}">Users</a></li>
				<li class="active"><span>User detail</span></li>
		  	</ol>
		</div>
	</div>
	<!-- end header -->
	<div class="row">
		<div class="col-md-12">
			@component('components.panel')
			
				@slot('heading')
					Basic information	
				@endslot

				<div class="row">
					<div class="col-md-6">
						<div class="row form-group">
							<label class="control-label col-md-3">Name:</label>
							<div class="col-md-9">
								<p>{{ $user->name }}</p>
							</div>
						</div>
						<div class="row form-group">
							<label class="control-label col-md-3">IC:</label>
							<div class="col-md-9">
								<p>{{ $user->ic }}</p>
							</div>
						</div>
						<div class="row form-group">
							<label class="control-label col-md-3">Email:</label>
							<div class="col-md-9">
								<p>{{ $user->email }}</p>
							</div>
						</div>
						<div class="row form-group">
							<label class="control-label col-md-3">Phone:</label>
							<div class="col-md-9">
								<p>{{ $user->phone }}</p>
							</div>
						</div>
						<div class="row form-group">
							<label class="control-label col-md-3">Username:</label>
							<div class="col-md-9">
								<p>{{ $user->username }}</p>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="row form-group">
							<label class="control-label col-md-3">Area:</label>
							<div class="col-md-9">
								<p>{{ $user->area->name }}, {{ $user->area->state->name }}</p>
							</div>
						</div>
						<div class="row form-group">
							<label class="control-label col-md-3">Joined date:</label>
							<div class="col-md-9">
								<p>{{ $user->created_at->toDateString() }}</p>
							</div>
						</div>
						<div class="row form-group">
							<label class="control-label col-md-3">Referrer:</label>
							<div class="col-md-9">
								<p>{{ $user->referrer ? $user->referrer->name : "-" }}</p>
							</div>
						</div>
						<div class="row form-group">
							<label class="control-label col-md-3">Alternate contact name:</label>
							<div class="col-md-9">
								<p>{{ $user->alt_contact_name }}</p>
							</div>
						</div>
						<div class="row form-group">
							<label class="control-label col-md-3">Alternate contact phone:</label>
							<div class="col-md-9">
								<p>{{ $user->alt_contact_phone }}</p>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="list-inline">
							<li>
								<a href="{{ route('user.edit', $user->id) }}" class="btn btn-info">Edit info</a>
							</li>
							<li>
								<form method="POST" action="{{ route('user.verify', $user->id) }}">
									{{ csrf_field() }}
									@if($user->is_verified)
										{{ method_field('DELETE') }}
									@endif
									<button type="submit" class="btn {{ $user->is_verified ? 'btn-danger' : 'btn-success' }}">
										{{ $user->is_verified ? 'Deactivate user' : 'Verify user' }}
									</button>
								</form>
							</li>
						</div>		
					</div>
				</div>
			@endcomponent
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			@component('components.panel')
				@slot('heading')
					IC Image
				@endslot
				@if( $user->is_marketing_agent )
					<img src="{{ $user->ic_image_path }}" class="img-responsive"/>
				@else
					<p>User has not uploaded his IC</p>
					@component('components.modal')
						@slot('button')
							Add IC
						@endslot
						@slot('title')
							Add IC image
						@endslot
						@slot('modal_id')
							add-ic-image-modal
						@endslot
						@slot('action_button')
							<button type="button" class="btn btn-success" onclick="$('#add-ic-form').submit()">Confirm</button>
						@endslot
					
						<form action="{{ route('user.ic', $user->id) }}" method="POST" id="add-ic-form" enctype="multipart/form-data">
							{{ csrf_field() }}
							<div class="form-group{{ $errors->has('ic_image_path') ? ' has-error has-danger' : '' }} mb-30">
	                            <label class="control-label mb-10 text-left">IC upload <span class="text-danger">*</span></label>
	                            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
	                                <div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
	                                <span class="input-group-addon fileupload btn btn-info btn-anim btn-file"><i class="fa fa-upload"></i> <span class="fileinput-new btn-text">Select file</span> <span class="fileinput-exists btn-text">Change</span>
	                                <input type="file" accept="image/*" name="ic_image_path">
	                                </span> <a href="#" class="input-group-addon btn btn-danger btn-anim fileinput-exists" data-dismiss="fileinput"><i class="fa fa-trash"></i><span class="btn-text"> Remove</span></a> 
	                            </div>
	                            @if($errors->has('ic_image_path'))
		                            <div class="help-block with-errors">
		                                <ul class="list-unstyled">
		                                    <li>{{ $errors->first('ic_image_path') }}</li>
		                                </ul>
		                            </div>
	                        	@endif
	                        </div>
						</form>
					@endcomponent
				@endif
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
									  	<td>{{ $payment->amount }}</td>
									  	<td>{{ $payment->created_at->toDateString() }}</td>
									  	<td>
									  		<div class="button-list">
									  			@component('components.modal')
													@slot('button')
														@if(!$payment->is_verified)
											  				Approve
											  			@else
											  				View details
											  			@endif
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
															<div class="clearfix"></div>
															<form id="payment-form-{{ $payment->id }}" action="{{ route('payment', $payment->id) }}" method="POST" class="form-horizontal mt-10">
																{{ csrf_field() }}
																<div class="form-group">
																	<label for="amount" class="control-label col-sm-3">Amount</label>
																	<div class="col-sm-9">
																		<input class="form-control" name="amount" id="amount" type="text" value="{{ $payment->amount }}">
																	</div>
																	
																</div>		
															</form>
														</div>
													</div>

													@slot('action_button')
														@if(!$payment->is_verified)
															<button type="button" class="btn btn-danger" onclick="$('#payment-form-{{ $payment->id }}').submit()">Verify payment</button>
														@endif
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
		</div>
	</div>
@endsection

@section('js')
    <script src="{{ asset('js/vendors/jasny-bootstrap/jasny-bootstrap.min.js') }}"></script>
	<script src="{{ asset('js/vendors/filament-tablesaw/tablesaw.js') }}"></script>
	<script src="{{ asset('js/vendors/filament-tablesaw/tablesaw-init.js') }}"></script>
@endsection