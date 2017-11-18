@extends('layouts.app')

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
	@component('components.panel')
		@slot('heading')
			Units @if( null !== $machine->latest_earning() )<small>earning {{ $machine->latest_earning()->amount / 10 }} per unit last month </small>@endif
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
								<li>
									<a href="{{ route('unit', $unit->id) }}" class="btn btn-warning">
										View details
									</a>
								</li>
							</ul>
					  	</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	@endcomponent
@endsection