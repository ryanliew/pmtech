@extends('layouts.app')

@section('css')
	<link href="/js/vendors/filament-tablesaw/tablesaw.css" rel="stylesheet">
@endsection

@section('content')
	<div class="row heading-bg">
		<!-- header -->
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h5 class="txt-dark">Payments for {{ $date }}</h5>
		</div>

		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
		  	<ol class="breadcrumb">
				<li><a href="{{ route('home') }}">Dashboard</a></li>
				<li><a href="{{ route('users') }}">users</a></li>
				<li class="active"><span>payments</span></li>
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
						<div class="table-wrap">
							<div class="mt-40 tablesaw-overflow">
								<table class="tablesaw table-bordered table-hover table" data-tablesaw-mode="columntoggle" data-tablesaw-sortable data-tablesaw-sortable-switch data-tablesaw-minimap data-tablesaw-mode-switch>
									<thead>
										<tr>
										 	<th data-tablesaw-sortable-col data-tablesaw-priority="persist">Name</th>
										  	<th data-tablesaw-priority="0" class="tablesaw-cell-hidden">Bank name</th>
										  	<th data-tablesaw-priority="0">Bank account number</th>
										  	<th data-tablesaw-priority="0">Bitcoin address</th>
										  	<th data-tablesaw-priority="0">Email</th>
										  	<th data-tablesaw-priority="0" class="tablesaw-cell-hidden">Phone</th>
										  	<th data-tablesaw-priority="0">Amount (MYR)</th>
										  	<th data-tablesaw-priority="0">Amount (Bitcoin)</th>
										</tr>
									</thead>
									<tbody>
										@foreach( $users as $user )
											<tr>
											  	<td class="title"><a href="{{ route('transactions', $user->id) }}">{{ $user->name }}</a></td>
											  	<td>{{ $user->bank_name }}</td>
											  	<td>{{ $user->bank_account_number }}</td>
											  	<td>{{ $user->bitcoin_address }}</td>
											  	<td>{{ $user->email }}</td>
											  	<td>{{ $user->phone }}</td>
											  	<td>{{ number_format($user->total, 2, '.', '') }}</td>
											  	<td>{{ number_format($user->bitcoin_total, 6, '.', '') }}</td>
											</tr>
										@endforeach
									</tbody>
								</table>

								{{ $users->links() }}
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