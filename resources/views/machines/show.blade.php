@extends('layouts.app')

@section('css')
	<link href="/js/vendors/filament-tablesaw/tablesaw.css" rel="stylesheet">
@endsection

@section('content')
	<!-- header -->
	<div class="row heading-bg">
		
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h5 class="txt-dark">{{ $machine->name }}</h5>
		</div>

		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
		  	<ol class="breadcrumb">
				<li><a href="{{ route('home') }}">Dashboard</a></li>
				<li><a href="{{ route('machines') }}">Machines</a></li>
				<li class="active"><span>{{ $machine->name }}</span></li>
		  	</ol>
		</div>
	</div>
	<!-- end header -->
	<div class="row">
		<div class="col-md-6">
			@component('components.panel')
			@slot('heading')
				Units @if( null !== $machine->latest_earning() )<small>earning {{ $machine->latest_earning()->final_amount / 10 }} per unit last month </small>@endif
			@endslot
		
			<table class="tablesaw table-bordered table-hover table" data-tablesaw-mode="swipe" data-tablesaw-sortable data-tablesaw-sortable-switch data-tablesaw-minimap data-tablesaw-mode-switch>
				<thead>
					<tr>
					 	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">ID</th>
					  	
					  	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Investor</th>
					  	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach( $machine->units as $unit )
						<tr>
						  	<td class="title">{{ $unit->id }}</td>
						  	<td>@if(isset($unit->investor_id)){{ $unit->investor->name }}@else No investor @endif</td>
						  	<td>
						  		<ul class="list-inline">
						  			<li>
								  		@component('components.modal')
								  			@slot('button')
								  				@if(isset($unit->investor_id))Edit investor @else Add investor @endif
								  			@endslot
								  			@slot('title')
								  				@if(isset($unit->investor_id))Edit investor @else Add investor @endif
								  			@endslot
								  			@slot('modal_id')
								  				unit-{{ $unit->id }}-modal
								  			@endslot
								  			@slot('action_button')
								  				<button type="button" class="btn btn-success" onclick="$('#unit-{{ $unit->id }}-form').submit()">Confirm</button>
								  			@endslot
								  		
								  			<form method="POST" action="{{ route("unit", $unit->id) }}" id="unit-{{ $unit->id }}-form">
								  				{{ csrf_field() }}
								  				<div class="form-group{{ $errors->has('investor_id') ? ' has-error has-danger' : '' }}">
								                    <label class="pull-left control-label mb-10" for="investor_id">Investor <span class="text-danger">*</span></label>
								                    <select class="form-control select2" name="investor_id" id="investor_id">
								                        <option>Select investor</option>
								                        @foreach($users as $user)
															<option value="{{ $user->id }}" @if(isset($unit->investor_id) && $unit->investor_id == $user->id) selected @endif>{{ $user->name }}</option>
									  					@endforeach
								                    </select>
								                    @if($errors->has('investor_id'))
								                        <div class="help-block with-errors">
								                            <ul class="list-unstyled">
								                                <li>{{ $errors->first('investor_id') }}</li>
								                            </ul>
								                        </div>
								                    @endif
								                </div>
								            </form>
								  		@endcomponent
								  	</li>
								  	@if( null !== $unit->investor)
									  	<li>
											<form method="POST" action="{{ route('unit', $unit->id) }}">
												{{ csrf_field() }}
												{{ method_field('DELETE') }}

												<button type="submit" class="btn btn-danger">Remove investor</button>
											</form>
									  	</li>
								  	@endif
								</ul>
						  	</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			@endcomponent
		</div>
		<div class="col-md-6">
			@component('components.panel')
				@slot('heading')
					Earnings history <small>Earned {{ $machine->total_earning }} so far</small>
				@endslot
			
				<table class="tablesaw table-bordered table-hover table" data-tablesaw-mode="swipe" data-tablesaw-sortable data-tablesaw-sortable-switch data-tablesaw-minimap data-tablesaw-mode-switch>
				<thead>
					<tr>
					 	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Date</th>
					  	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Amount</th>
					  	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Final amount</th>
					  	<th scope="col"	data-tablesaw-sortable-col data-tablesaw-priority="1">Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach( $machine->earnings as $earning )
						<tr>
						  	<td class="title">{{ $earning->date->toDateString()  }}</td>
						  	<td>{{ $earning->amount }}</td>
						  	<td>{{ $earning->final_amount }}</td>
						  	<td>
								@component('components.modal')
									@slot('button')
										Edit earning
									@endslot
									@slot('title')
										Edit earning for {{ $machine->name }}
									@endslot
									@slot('modal_id')
										earning-edit-modal
									@endslot
									@slot('action_button')
										<button type="button" class="btn btn-success" onclick="$('#earning-{{ $earning->id }}-form').submit()">Edit earning</button>
									@endslot
								
									<form method="POST" action="{{ route('earning', $earning->id) }}" id="earning-{{ $earning->id }}-form">
										{{ csrf_field() }}
										{{ method_field('PATCH') }}

										@component('components.input') 
											@slot('input_name')
												month
											@endslot
										
											@slot('input_type')
												number
											@endslot
										
											@slot('input_value')
												{{ $earning->date->month }}
											@endslot
										
											@slot('input_placeholder')
												Insert earning month
											@endslot
											
											Earning month
										
											@slot('show_only')
												true
											@endslot
										@endcomponent

										@component('components.input') 
											@slot('input_name')
												amount
											@endslot
										
											@slot('input_type')
												number
											@endslot
										
											@slot('input_value')
												{{ $earning->amount }}
											@endslot
										
											@slot('input_placeholder')
												Insert earning for the month
											@endslot
											
											Amount mined
										
											@slot('show_only')
												false
											@endslot
										@endcomponent
									</form>
								@endcomponent
						  	</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			@endcomponent
		</div>
	</div>
@endsection

@section('js')
	<script src="{{ asset('js/vendors/filament-tablesaw/tablesaw.js') }}"></script>
	<script src="{{ asset('js/vendors/filament-tablesaw/tablesaw-init.js') }}"></script>
@endsection