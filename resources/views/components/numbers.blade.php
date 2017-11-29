<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
	<div class="panel panel-default card-view pa-0">
		<div class="panel-wrapper collapse in">
			<div class="panel-body pa-0">
				<div class="sm-data-box {{ $color }}">
					<div class="container-fluid">
						<div class="row">
							<div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
								<span class="txt-light block counter"><span class="counter-anim">{{ $slot }}</span></span>
								<span class="weight-500 uppercase-font txt-light block font-13 text-center">{{ $adjective }}</span>
							</div>
							<div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
								{{ $icon }}
							</div>
						</div>	
					</div>
				</div>
			</div>
		</div>
	</div>
</div>