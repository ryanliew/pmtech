@extends('layouts.app')

@section('content')
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
						<div class="button-list">
							<form method="POST" action="{{ route('user', $user->id) }}">
								{{ csrf_field() }}
								@if($user->is_verified)
									{{ method_field('DELETE') }}
								@endif
								<button type="submit" class="btn {{ $user->is_verified ? 'btn-danger' : 'btn-success' }}">
									{{ $user->is_verified ? 'Deactivate user' : 'Verify user' }}
								</button>
							</form>
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
				@endif
			@endcomponent
		</div>	
		<div class="col-md-6">
			@component('components.panel')
				@slot('heading')
					Payments
				@endslot

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