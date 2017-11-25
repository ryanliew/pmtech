<div class="panel {{ isset($custom_class) ? $custom_class : 'panel-default' }} card-view">
	<div class="panel-heading">
		<div class="pull-left">
			<h6 class="panel-title txt-dark">{{ $heading }}@if(isset($custom_message)) <small>{{ $custom_message }}</small> @endif</h6>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="panel-wrapper collapse in">
		<div class="panel-body">
			{{ $slot }}
		</div>
	</div>
</div>
