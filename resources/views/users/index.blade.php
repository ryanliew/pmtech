@extends('layouts.app')

@section('css')
	<link href="/js/vendors/filament-tablesaw/tablesaw.css" rel="stylesheet">
@endsection

@section('content')
	<div class="row heading-bg">
		<!-- header -->
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h5 class="txt-dark">users</h5>
		</div>

		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
		  	<ol class="breadcrumb">
				<li><a href="{{ route('home') }}">Dashboard</a></li>
				<li class="active"><span>users</span></li>
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
						<div class="row controls">
							<div class="col-md-12 button-list">
								<a href="{{ route('user.create') }}" class="btn btn-info" >Add user</a>
							</div>
						</div>
						<div class="table-wrap">
							<div class="mt-40">
								<table class="tablesaw table-bordered table-hover table" data-tablesaw-mode="swipe" data-tablesaw-sortable data-tablesaw-sortable-switch data-tablesaw-minimap data-tablesaw-mode-switch>
									<thead>
										<tr>
										 	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Name</th>
										  	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="6">IC</th>
										  	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Status</th>
										  	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Units owned</th>
										  	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Money earned</th>
										  	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Date joined</th>
										  	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Actions</th>
										</tr>
									</thead>
									<tbody>
										@foreach( $users as $user )
											<tr>
											  	<td class="title">{{ $user->name }}</td>
											  	<td>{{ $user->ic }}</td>
											  	<td>{{ $user->status }}</td>
											  	<td>0</td>
											  	<td>0</td>
											  	<td>{{ $user->created_at->toDateString() }}</td>
											  	<td>
											  		<div class="button-list">
												  		<a class="btn btn-success" href="{{ route('user', $user->id) }}">View details</a>
												  		@if($user->is_verified)
													  		<button type="button" class="btn btn-danger" onclick="$('#delete-user-{{ $user->id }}').submit()">Deactivate</button>
													  		<form method="POST" action="{{ route("user.verify", $user->id) }}" id="delete-user-{{ $user->id }}">
																{{ csrf_field() }}
																{{ method_field('DELETE') }}	
													  		</form>	
													  	@endif
													</div>
											  	</td>
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