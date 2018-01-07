@extends('layouts.app')

@section('css')
	<link href="/js/vendors/bootstrap-treeview/bootstrap-treeview.min.css" rel="stylesheet" type="text/css">
@endsection
@section('content')
	<!-- header -->
	<div class="row heading-bg">
		
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h5 class="txt-dark">Users tree</h5>
		</div>

		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
		  	<ol class="breadcrumb">
				<li><a href="{{ route('home') }}">Dashboard</a></li>
				<li class="active"><span>Users tree</span></li>
		  	</ol>
		</div>
	</div>
	<!-- end header -->

	<div class="row">
		<div class="col-md-12">
			@component('components.panel')
				@slot('heading')
					
				@endslot
				
				<div class="flex-row flex-center mb-10">
					<label class="mr-5">Search:</label>
					<input class="form-control mr-5" id="searchTree" type="text" placeholder="Search for the name of the user"/>
					<button class="btn btn-success mr-5" onclick="search()"><i class="fa fa-search"></i></button>
					<button class="btn btn-danger" onclick="clearSearch()"><i class="fa fa-times"></i></button>
					<div class="flex"></div>
				</div>
				<div class="treeview" id="users-treeview"></div>
			@endcomponent

		</div>
	</div>
@endsection

@section('js')
	<script src="/js/vendors/bootstrap-treeview/bootstrap-treeview.min.js"></script>

	<script>

		var users = [
			@foreach($roots as $user)
				{
					text: "{{ $user->name }} ({{ $user->email }})",
					href: "{{ $user->id }}",
					selectable: false,
					state: {
						expanded: false
					},
					@if(count($user->children))
						tags: ['{{ count($user->children) }}'],
						nodes: [
							@include('includes.manageChild', ['childs' => $user->children])
						]
					@endif
				},
			@endforeach	
		]
		$('#users-treeview').treeview({
			data: users,
			showTags: true
		});

		function search() {
			console.log("called");
			$('#users-treeview').treeview('search', [$("#searchTree").val(), {
				ignoreCase: true,     // case insensitive
			  	exactMatch: false,    // like or equals
			  	revealResults: true,  // reveal matching nodes
			}]);
		}

		function clearSearch() {
			console.log("called");
			$("#searchTree").val('');
			$('#users-treeview').treeview('clearSearch');
		}
	</script>
@endsection