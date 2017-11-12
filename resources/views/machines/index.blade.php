@extends('layouts.app')

@section('css')
	<link href="/js/vendors/filament-tablesaw/tablesaw.css" rel="stylesheet">
@endsection

@section('content')
	<div class="row heading-bg">
		<!-- header -->
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
						<div class="table-wrap">
							<div class="mt-40">
								<table class="tablesaw table-bordered table-hover table" data-tablesaw-mode="swipe" data-tablesaw-sortable data-tablesaw-sortable-switch data-tablesaw-minimap data-tablesaw-mode-switch>
									<thead>
										<tr>
										 	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Machine ID</th>
										  	<th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="3">Name</th>
										  	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Total earnings</th>
										  	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Actions</th>
										</tr>
									</thead>
									<tbody>
										@foreach( $machines as $machine )
											<tr>
											  	<td class="title">{{ $machine->id }}</td>
											  	<td>{{ $machine->name }}</td>
											  	<td>Todo Earning calculation</td>
											  	<td>
											  		<div class="button-list">
												  		<button class="btn btn-success" data-toggle="modal" data-target="#edit-machine-modal-{{ $machine->id }}">Edit</button>
												  		<button type="button" class="btn btn-danger" onclick="$('#delete-machine-{{ $machine->id }}').submit()">Delete</button>
												  		<form method="POST" action="{{ route("machine", $machine->id) }}" id="delete-machine-{{ $machine->id }}">
															{{ csrf_field() }}
															{{ method_field('DELETE') }}
															
												  		</form>
														
													</div>
													<div id="edit-machine-modal-{{ $machine->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="edit-machine-modal" aria-hidden="true" style="display: none;">
												  		<div class="modal-dialog">
												  			<form id="add-machine-form" method="POST" action="{{ route('machine', $machine->id) }}">
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
											</tr>
										@endforeach
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
	<script src="/js/vendors/filament-tablesaw/tablesaw.js"></script>
	<script src="/js/vendors/filament-tablesaw/tablesaw-init.js"></script>
@endsection