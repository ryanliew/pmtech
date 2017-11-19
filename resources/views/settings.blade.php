@extends('layouts.app')

@section('content')
	<div class="row">
		<div class="col-md-12">
			@component('components.panel')
				@slot('heading')
					Settings
				@endslot
			
				<form action="{{ route('settings') }}" method="POST">
					{{ csrf_field() }}
					<div class="row">
						<div class="col-md-6">
							<h4>Fees settings</h4>
							<hr>
							@component('components.input') 
								@slot('input_name')
									fee_rental_per_month
								@endslot
							
								@slot('input_type')
									number
								@endslot
							
								@slot('input_value')
									{{ $setting->fee_rental_per_month }}
								@endslot
							
								@slot('input_placeholder')
									Rental fee per month
								@endslot
								
								Rental fee <span class="text-danger">*</span>
							
								@slot('show_only')
									false
								@endslot
							@endcomponent
							@component('components.input') 
								@slot('input_name')
									fee_internet_per_month
								@endslot
							
								@slot('input_type')
									number
								@endslot
							
								@slot('input_value')
									{{ $setting->fee_internet_per_month }}
								@endslot
							
								@slot('input_placeholder')
									Internet fee per month
								@endslot
								
								Internet fee <span class="text-danger">*</span>
							
								@slot('show_only')
									false
								@endslot
							@endcomponent
							@component('components.input') 
								@slot('input_name')
									fee_electric_per_month
								@endslot
							
								@slot('input_type')
									number
								@endslot
							
								@slot('input_value')
									{{ $setting->fee_electric_per_month }}
								@endslot
							
								@slot('input_placeholder')
									Electric fee per month
								@endslot
								
								Electric fee <span class="text-danger">*</span>
							
								@slot('show_only')
									false
								@endslot
							@endcomponent
							@component('components.input') 
								@slot('input_name')
									fee_admin_percentage_per_month
								@endslot
							
								@slot('input_type')
									number
								@endslot
							
								@slot('input_value')
									{{ $setting->fee_admin_percentage_per_month }}
								@endslot
							
								@slot('input_placeholder')
									Admin fee per month in percentage
								@endslot
								
								Admin fee (%) <span class="text-danger">*</span>
							
								@slot('show_only')
									false
								@endslot
							@endcomponent
						</div>
						<div class="col-md-6">
							<h4>Incentive settings</h4>
							<hr>
							@component('components.input') 
								@slot('input_name')
									incentive_commission_per_referee
								@endslot
							
								@slot('input_type')
									number
								@endslot
							
								@slot('input_value')
									{{ $setting->incentive_commission_per_referee }}
								@endslot
							
								@slot('input_placeholder')
									Commision earned by agent per investor referrred
								@endslot
								
								Commission per referee <span class="text-danger">*</span>
							
								@slot('show_only')
									false
								@endslot
							@endcomponent
							@component('components.input') 
								@slot('input_name')
									incentive_bonus_per_referee_pack
								@endslot
							
								@slot('input_type')
									number
								@endslot
							
								@slot('input_value')
									{{ $setting->incentive_bonus_per_referee_pack }}
								@endslot
							
								@slot('input_placeholder')
									Bonus earned by agent every 5 person they referred per month
								@endslot
								
								Bonus per 5 referee <span class="text-danger">*</span>
							
								@slot('show_only')
									false
								@endslot
							@endcomponent
							@component('components.input') 
								@slot('input_name')
									incentive_direct_downline_commission_percentage
								@endslot
							
								@slot('input_type')
									number
								@endslot
							
								@slot('input_value')
									{{ $setting->incentive_direct_downline_commission_percentage }}
								@endslot
							
								@slot('input_placeholder')
									Bonus earned by team leader when their direct downline referred a investor
								@endslot
								
								Team leader bonus (%) <span class="text-danger">*</span>
							
								@slot('show_only')
									false
								@endslot
							@endcomponent
						</div>
					</div>
					<button type="submit" class="btn btn-success pull-right">Change settings</button>
				</form>
		@endcomponent
		</div>
	</div>
	
	
@endsection