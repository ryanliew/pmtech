@extends('layouts.app')

@section('css')
	<link href="{{ asset('/js/vendors/filament-tablesaw/tablesaw.css') }}" rel="stylesheet">
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
		
		<transactions created_at="{{ $user->created_at->toDateString() }}"></transactions>

	@endcomponent
@endsection

@section('js')
	<script src="{{ asset('js/vendors/filament-tablesaw/tablesaw.js') }}"></script>
	<script src="{{ asset('js/vendors/filament-tablesaw/tablesaw-init.js') }}"></script>
@endsection