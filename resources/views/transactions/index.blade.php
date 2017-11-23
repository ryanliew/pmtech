@extends('layouts.app')

@section('css')
	<link href="/js/vendors/filament-tablesaw/tablesaw.css" rel="stylesheet">
@endsection

@section('content')
	<!-- header -->
	<div class="row heading-bg">
		
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h5 class="txt-dark">Transaction history</h5>
		</div>

		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
		  	<ol class="breadcrumb">
				<li><a href="{{ route('home') }}">Dashboard</a></li>
				<li class="active"><span>Transaction history for {{ $user->name }}</span></li>
		  	</ol>
		</div>
	</div>

	@component('components.panel')
		@slot('heading')
			Transactions
		@endslot

		<table class="tablesaw table-bordered table-hover table" data-tablesaw-mode="swipe" data-tablesaw-sortable data-tablesaw-sortable-switch data-tablesaw-minimap data-tablesaw-mode-switch>
			<thead>
				<tr>
				 	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Type</th>
				  	
				  	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Description</th>
				  	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Amount</th>
				  	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Date</th>
				</tr>
			</thead>
			<tbody>
				@forelse($transactions as $transaction)
					<tr>
						<td>{{ title_case($transaction->type) }}</td>
						<td>{{ $transaction->description }}</td>
						<td>{{ $transaction->amount }}</td>
						<td>{{ $transaction->created_at->toDateString() }}</td>
					</tr>
				@empty
					<tr>
						<td colspan="4">No transaction for this month</td>
					</tr>
				@endforelse
			</tbody>
		</table>

		{{ $transactions->links() }}
	@endcomponent
@endsection

@section('js')
	<script src="{{ asset('js/vendors/filament-tablesaw/tablesaw.js') }}"></script>
	<script src="{{ asset('js/vendors/filament-tablesaw/tablesaw-init.js') }}"></script>
@endsection