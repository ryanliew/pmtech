@extends('layouts.app')

@section('content')
    <dashboard isdefaultpassword="{{ auth()->user()->is_default_password }}" inline-template>
        <div>
            <div class="row">
                @component('components.numbers')
                    @slot('color')
                        bg-red
                    @endslot

                    @slot('icon')
                        <i class="fa fa-4x fa-money text-white"></i>
                    @endslot

                    @slot('adjective')
                        Total mined
                    @endslot

                    {{ auth()->user()->transactions()->profits()->sum('amount') }}
                @endcomponent
                @component('components.numbers')
                    @slot('color')
                        bg-pink
                    @endslot

                    @slot('icon')
                        <i class="fa fa-bitcoin fa-4x text-white"></i>
                    @endslot

                    @slot('adjective')
                        Total commision this month
                    @endslot

                    {{ $commision }}
                @endcomponent
                @component('components.numbers')
                    @slot('color')
                        bg-blue
                    @endslot

                    @slot('icon')
                        <i class="fa fa-child fa-4x text-white"></i>
                    @endslot

                    @slot('adjective')
                        Users referred
                    @endslot

                    {{ auth()->user()->referees()->count() }}
                @endcomponent
                @component('components.numbers')
                    @slot('color')
                        bg-green
                    @endslot

                    @slot('icon')
                        <i class="fa fa-usd fa-4x text-white"></i>
                    @endslot

                    @slot('adjective')
                        Bitcoin value
                    @endslot

                    <span v-text="bitcoinUSD"></span>
                @endcomponent
            </div>
            <div class="row">
                <div class="col-md-6" :class="bitcoinHistoryLoadingClass">
                    <div class="preloader-block">
                        <ul class="spin-preloader">
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                        </ul>
                    </div>
                    @component('components.panel')
                        @slot('heading')
                            Bitcoin statistics
                        @endslot
                    
                        <chartjs-line :bind="true" :labels="this.bitcoinChartLabels" :data="this.bitcoinChartData" datalabel="USD"></chartjs-line>
                    @endcomponent 
                </div>
                <div class="col-md-6">
                    @component('components.panel')
                        @slot('heading')
                            Units performance
                        @endslot
                    
                        <table class="tablesaw table-bordered table-hover table" data-tablesaw-mode="swipe" data-tablesaw-sortable data-tablesaw-sortable-switch data-tablesaw-minimap data-tablesaw-mode-switch>
                            <thead>
                                <tr>
                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">ID</th>
                                    
                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Earning last month</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse( auth()->user()->units as $unit )
                                    <tr>
                                        <td class="title">{{ $unit->id }}</td>
                                        <td>{{ $unit->machine->latest_earning()->final_amount / 10 }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2">
                                            You did not invest in any units
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    @endcomponent
                    <div class="row">
                        <div class="col-md-6" :class="milestoneLoadingClass">
                            <div class="preloader-block">
                                <ul class="spin-preloader">
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                </ul>
                            </div>
                            @component('components.panel')
                                @slot('heading')
                                    <span class="text-center">Next milestone</span>
                                @endslot

                                @slot('custom_body_class')
                                    sm-data-box-1
                                @endslot
                                
                                <span class="uppercase-font weight-500 font-14 block text-center txt-dark" v-text="milestoneString">
                                </span>
                                <div class="cus-sat-stat weight-500 txt-success text-center mt-5">
                                    <span id="milestone-percentage" v-text="milestonePercentage"></span><span>%</span>
                                </div>
                                <div class="progress-anim mt-20">
                                    <div class="progress mb-5">
                                        <div class="progress-bar progress-bar-success wow animated progress-animated" role="progressbar" :aria-valuenow="milestonePercentage" aria-valuemin="0" aria-valuemax="100" :style="'width:' + milestonePercentage + '%;'"></div>
                                    </div>
                                </div>
                                <div class="next-role-description text-center" v-text="milestoneDescription">
                                </div>
                                
                            @endcomponent
                        </div>
                        <div class="col-md-6">
                            @component('components.panel')
                                @slot('heading')
                                    My referees
                                @endslot
                            
                                <table class="tablesaw table-bordered table-hover table" data-tablesaw-mode="swipe" data-tablesaw-sortable data-tablesaw-sortable-switch data-tablesaw-minimap data-tablesaw-mode-switch>
                                    <thead>
                                        <tr>
                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Name</th>
                                            
                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Role</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse( auth()->user()->referees as $referee )
                                            <tr>
                                                <td class="title">{{ $referee->name }}</td>
                                                <td>{{ $referee->role_string }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2">
                                                    You do not have any referee
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            @endcomponent
                    </div>
                </div>
            </div>  
        </div>
    </dashboard>
@endsection

@section('js')
    <script src="{{ asset( 'js/vendors/jquery.counterup/jquery.counterup.min.js' ) }}"></script>
    <script src="{{ asset( 'js/vendors/waypoints/jquery.waypoints.min.js' ) }}"></script> 
@endsection