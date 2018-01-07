@foreach($childs as $child)
	{
		text: "{{ $child->name }}",
		href: "{{ $child->id }}",
		selectable: false,
		state: {
			expanded: false
		},
		@if(count($child->children))
			tags: ['{{ count($child->children) }}'],
			nodes: [
				@include('includes.manageChild', ['childs' => $child->children])
			]
		@endif
	},
@endforeach