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
	<div class="flex-row">
		@if(auth()->user()->is_admin)
			<div class="col-md-3">
				@component('components.panel')
				@slot('heading')
					Units
				@endslot
			
				<table class="tablesaw table-bordered table-hover table" data-tablesaw-mode="swipe" data-tablesaw-sortable data-tablesaw-sortable-switch data-tablesaw-minimap data-tablesaw-mode-switch>
					<thead>
						<tr>
						  	
						  	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Investor</th>
						  	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach( $machine->units as $unit )
							<tr>
							  	<td>@if(isset($unit->investor_id)){{ $unit->investor->name }}@else No investor @endif</td>
							  	<td>
							  		<ul class="list-inline">
									  	@if( null !== $unit->investor)
										  	<li>
												<form method="POST" action="{{ route('unit', $unit->id) }}">
													{{ csrf_field() }}
													{{ method_field('DELETE') }}

													<button type="submit" class="btn btn-danger btn-small"><i class="fa fa-times"></i></button>
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
		@endif
		<div class="{{ auth()->user()->is_admin ? 'col-md-9' : 'col-md-12' }}">
			@component('components.panel')
				@slot('heading')
					Earnings history 
				@endslot
				
				<machine-chart class="mb-10" machine="{{ $machine->id }}"></machine-chart>
				<table class="tablesaw table-bordered table-hover table" data-tablesaw-mode="swipe" data-tablesaw-sortable data-tablesaw-sortable-switch data-tablesaw-minimap data-tablesaw-mode-switch>
					<thead>
						<tr>
						 	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Date</th>
						  	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Gross income</th>
						  	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Nett income</th>
						</tr>
					</thead>
					<tbody>
						@foreach( $earnings as $earning )
							<tr>
							  	<td class="title">{{ $earning->date->toDateString()  }}</td>
							  	<td>{{ $earning->amount }}</td>
							  	<td>{{ $earning->final_amount }}</td>
							</tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr>
							<td colspan="2" class="text-right">Last earning per unit:</td>
							<td><b>{{ null !== $machine->latest_earning() ? number_format($machine->latest_earning()->final_amount  / 10, 2) : 0.00 }}</b></td>
						</tr>
						<tr>
							<td colspan="2" class="text-right">Total earned:</td>
							<td>{{ number_format($total, 2) }}</td>
						</tr>
					</tfoot>
				</table>
			@endcomponent
		</div>
	</div>
@endsection

@section('js')
	<script src="{{ asset('js/vendors/filament-tablesaw/tablesaw.js') }}"></script>
	<script src="{{ asset('js/vendors/filament-tablesaw/tablesaw-init.js') }}"></script>
@endsection