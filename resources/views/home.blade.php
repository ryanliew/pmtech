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
                        Units owned
                    @endslot

                    {{ auth()->user()->units()->count() }}
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
            </div>  
        </div>
    </dashboard>
@endsection

@section('js')
    <script src="{{ asset( 'js/vendors/jquery.counterup/jquery.counterup.min.js' ) }}"></script>
    <script src="{{ asset( 'js/vendors/waypoints/jquery.waypoints.min.js' ) }}"></script> 
@endsection