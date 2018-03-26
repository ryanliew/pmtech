@extends('layouts.app')

@section('css')
	<link href="{{ asset('js/vendors/filament-tablesaw/tablesaw.css') }}" rel="stylesheet">
	<link href="{{ asset('js/vendors/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
@endsection

@section('content')
	<!-- header -->
	<div class="row heading-bg">
		
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h5 class="txt-dark">machines</h5>
		</div>

		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
		  	<ol class="breadcrumb">
				<li><a href="{{ route('home') }}">Dashboard</a></li>
				<li class="active"><span>machines</span></li>
		  	</ol>
		</div>
	</div>
	<!-- end header -->

	<!-- Content -->
	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-default card-view">
				<div class="panel-wrapper collapse in">
					<div class="panel-body">
						@if(auth()->user()->is_admin)
							<div class="row controls">
								<div class="col-md-12 button-list">
									<button class="btn btn-info" data-toggle="modal" data-target="#add-machine-modal">Add machine</button>
									<div id="add-machine-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
													<h5 class="modal-title">Add new machine</h5>
												</div>
												<div class="modal-body">
													<form id="add-machine-form" method="POST" action="{{ route('machines') }}">
														{{ csrf_field() }}
														<div class="form-group">
															<label for="name" class="control-label mb-10">Name:</label>
															<input type="text" name="name" class="form-control" id="name">
														</div>
														<div class="form-group">
															<label for="status" class="control-label mb-10">Status:</label>
															<input type="text" name="status" class="form-control" id="status">
														</div>
														<div class="form-group">
															<label for="arrival" class="control-label mb-10">Estimated arrival:</label>
															<input type="date" name="arrival_date" class="form-control" id="arrival" value="{{ $today->toDateString() }}">
														</div>
													</form>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
													<button type="button" class="btn btn-danger" onclick="$('#add-machine-form').submit()">Save changes</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						@endif
						<div class="table-wrap">
							<div class="mt-40">
								<table class="tablesaw table-bordered table-hover table" data-tablesaw-mode="swipe" data-tablesaw-sortable data-tablesaw-sortable-switch data-tablesaw-minimap data-tablesaw-mode-switch>
									<thead>
										<tr>
										 	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Name</th>
										  	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="6">Empty units</th>
										  	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Status</th>
										  	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Estimated arrival</th>
										  	@if(auth()->user()->is_admin)
											  	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Last earning amount</th>
											  	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Last earning month</th>
											  	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="6">Actions</th>
											@endif
										</tr>
									</thead>
									<tbody>
										@foreach( $machines as $machine )
											<tr>
											  	<td class="title">{{ $machine->name }}</td>
											  	<td>{{ $machine->empty_unit_count }}</td>
											  	<td>{{ $machine->status }}</td>
											  	<td>{{ $machine->arrival_date ? $machine->arrival_date->toDateString() : "-" }}</td>
											  	@if(auth()->user()->is_admin)
												  	<td>@if( null !== $machine->latest_earning() ){{ $machine->latest_earning()->amount }} @else - @endif</td>
												  	<td>@if( null !== $machine->latest_earning() ){{ $machine->latest_earning()->date->toDateString() }} @else - @endif</td>
												  	<td>
												  		<ul class="list-inline">
												  			@if(auth()->user()->is_admin)
												  			<li>
														  		<button class="btn btn-success" data-toggle="modal" data-target="#edit-machine-modal-{{ $machine->id }}">Edit</button>
														  	</li>
														  	{{-- <li>	
													  			<button type="button" class="btn btn-danger" onclick="$('#delete-machine-{{ $machine->id }}').submit()">Delete</button>

													  			<form method="POST" action="{{ route("machine", $machine->id) }}" id="delete-machine-{{ $machine->id }}">
																	{{ csrf_field() }}
																	{{ method_field('DELETE') }}
													  			</form>
													  		</li> --}}
													  		<li>
																@component('components.modal')
																	@slot('button')
																		Add earning
																	@endslot
																	@slot('title')
																		Earning for {{ $machine->name }}
																	@endslot
																	@slot('modal_id')
																		machine-earning-{{ $machine->id }}-modal
																	@endslot
																	@slot('action_button')
																		<button type="button" class="btn btn-success" onclick="$('#machine-earning-{{ $machine->id }}-form').submit()">Add earning</button>
																	@endslot
																
																	<form method="POST" action="{{ route('earning', $machine->id) }}" id="machine-earning-{{ $machine->id }}-form">
																		{{ csrf_field() }}

																		@component('components.input') 
																			@slot('input_name')
																				month
																			@endslot
																		
																			@slot('input_type')
																				number
																			@endslot
																		
																			@slot('input_value')
																				
																			@endslot
																		
																			@slot('input_placeholder')
																				Insert earning month
																			@endslot
																			
																			Earning month
																		
																			@slot('show_only')
																				false
																			@endslot
																		@endcomponent

																		<earning-calculator inline-template>
																			<div>
																				@component('components.input') 
																					@slot('input_name')
																						amount
																					@endslot
																				
																					@slot('input_type')
																						number
																					@endslot
																				
																					@slot('input_value')
																						
																					@endslot
																				
																					@slot('input_placeholder')
																						Insert earning for the month (MYR)
																					@endslot
																					
																					Gross Amount mined (MYR)
																				
																					@slot('show_only')
																						false
																					@endslot

																					@slot('extra_information')
																						<div class="help-block">
																							After deduction: RM<span v-text="finalAmount"></span> <i class="fa fa-circle-o-notch fa-spin fa-fw text-white" v-if="calculating"></i>
																						</div>
																					@endslot
																					
																					@slot('actions')
																						@change="getTotalDeduction"
																					@endslot

																					@slot('vmodel')
																						amountMyr
																					@endslot
																				@endcomponent
																			
																				@component('components.input') 
																					@slot('input_name')
																						cryptocurrency_amount
																					@endslot
																				
																					@slot('input_type')
																						number
																					@endslot
																				
																					@slot('input_value')
																						
																					@endslot
																				
																					@slot('input_placeholder')
																						Insert earning for the month (Cryptocurrency)
																					@endslot
																					
																					Nett Amount mined (Crypocurrency)
																				
																					@slot('show_only')
																						false
																					@endslot

																					@slot('vmodel')
																						amountCrypto
																					@endslot

																					@slot('extra_information')
																						<div class="help-block">
																							Conversion rate: RM<span v-text="conversionRate"></span> per cryptocurrency
																						</div>
																					@endslot
																				@endcomponent
																			</div>
																		</earning-calculator>
																	</form>
																@endcomponent
															</li>
															@endif
															<li>
																<a href="{{ route('machine', $machine->id) }}" class="btn btn-warning">
																	View details
																</a>
															</li>
														</ul>
														<div id="edit-machine-modal-{{ $machine->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="edit-machine-modal" aria-hidden="true" style="display: none;">
													  		<div class="modal-dialog">
													  			<form method="POST" action="{{ route('machine', $machine->id) }}">
																	<div class="modal-content">
																		<div class="modal-header">
																			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																			<h5 class="modal-title">Edit {{ $machine->name }}</h5>
																		</div>
																		<div class="modal-body">
																			{{ csrf_field() }}
																			<div class="form-group">
																				<label for="name" class="control-label mb-10">Name:</label>
																				<input type="text" name="name" class="form-control" id="name" value="{{ $machine->name }}">
																			</div>
																			<div class="form-group">
																				<label for="status" class="control-label mb-10">Status:</label>
																				<input type="text" name="status" class="form-control" id="status" value="{{ $machine->status }}">
																			</div>
																			<div class="form-group">
																				<label for="arrival" class="control-label mb-10">Estimated arrival:</label>
																				<input type="date" name="arrival_date" class="form-control" id="arrival" value="{{ $machine->arrival_date ? $machine->arrival_date->toDateString() : $today->toDateString() }}">
																			</div>
																		</div>
																		<div class="modal-footer">
																			<a type="button" class="btn btn-default" data-dismiss="modal">Close</a>
																			<button type="submit" class="btn btn-danger">Save changes</button>
																		</div>
																	</div>
																</form>
															</div>
														</div>
												  	</td>
											  	@endif
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>	
					</div>
				</div>
			</div>
		</div>	
	</div>	
	<!-- end content -->
@endsection

@section('js')
	<script src="{{ asset('js/vendors/filament-tablesaw/tablesaw.js') }}"></script>
	<script src="{{ asset('js/vendors/filament-tablesaw/tablesaw-init.js') }}"></script>
@endsection