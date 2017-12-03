@extends('layouts.app')

@section('css')
    <link href="{{ asset('/js/vendors/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    <dashboard isdefaultpassword="{{ auth()->user()->is_default_password }}" investor="{{ auth()->user()->referral_link }}" marketing="{{ auth()->user()->marketing_referral_link }}" inline-template>
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
                    @component('components.panel')
                        @slot('heading')
                            My referees
                        @endslot
                        
                        <div class="table-wrap">
                            <div class="table-responsive"> 
                                <table id="referee-data-table" class="table table-hover display pb-30">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Role</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Role</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @forelse( auth()->user()->referees as $referee )
                                            <tr>
                                                <td class="title">{{ $referee->name }}</td>
                                                <td>{{ $referee->role_string }}</td>
                                                <td>{{ $referee->descending_marketing_agent_count }}</td>
                                                <td>{{ $referee->descending_investor_count }}</td>
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
                            </div>
                        </div>
                    @endcomponent
                </div>
                <div class="col-md-6">
                    @component('components.panel')
                        @slot('heading')
                            Units performance
                        @endslot
                    
                        <div class="table-wrap">
                            <div class="table-responsive"> 
                                <table id="units-data-table" class="table table-hover display pb-30">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Earning last month</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Earning last month</th>
                                        </tr>
                                    </tfoot>
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
                            </div>
                        </div>
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
                                    <span class="text-center">Active Descendents</span>
                                @endslot

                                @slot('custom_body_class')
                                    sm-data-box-1
                                @endslot
                                
                                <span class="uppercase-font weight-500 font-14 block text-center txt-dark">
                                    Active marketing agent
                                </span>
                                <div class="cus-sat-stat weight-500 txt-success text-center mt-5">
                                    <span id="active-percentage" v-text="activeDescendents.toFixed(2)"></span><span>%</span>
                                </div>
                                <div class="progress-anim mt-20">
                                    <div class="progress mb-5">
                                        <div class="progress-bar progress-bar-success wow animated progress-animated" role="progressbar" :aria-valuenow="activeDescendents" aria-valuemin="0" aria-valuemax="100" :style="'width:' + activeDescendents + '%;'"></div>
                                    </div>
                                </div>
                                <div class="next-role-description text-center">
                                    Number of active marketing agent under me
                                </div>
                            @endcomponent
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default card-view">
                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body">
                                        <div class="col-md-6 pull-left"><h6>My referral links</div>
                                        <div class="col-md-6 pull-right">
                                            @if(auth()->user()->is_verified && auth()->user()->ic_image_path !== "")
                                                <div class="row">
                                                    <div class="col-md-6"><button class="btn btn-success btn-sm" @click="copyInvestor()">Copy Investor URL</button></div>
                                                    <div class="col-md-6"><button class="btn btn-info btn-sm" @click="copyMarketing()">Copy Agent URL</button></div>
                                                </div>
                                            @else
                                                <div class="text-center text-danger">
                                                    Please consult our support team on how to become a marketing agent.
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            @component('components.panel')
                                @slot('heading')
                                    FAQ
                                @endslot
                            
                                <div class="panel-group accordion-struct" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingOne">
                                            <a role="button" data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">How to become a marketing agent?</a>
                                        </div>
                                        <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                            <div class="panel-body pa-15">If you are already an investor, please email your copy of IC to support@pmtech.com. You will become a marketing agent after you referred an investor successfully.</div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingTwo">
                                            <a role="button" data-toggle="collapse" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">How am I considered a team leader?</a>
                                        </div>
                                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                            <div class="panel-body pa-15">You must be a marketing agent before hand to "level up" into a team leader. You will then become a team leader by referring 5 marketing agent successfully.</div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingThree">
                                            <a role="button" data-toggle="collapse" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree">Why become a team leader?</a>
                                        </div>
                                        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                            <div class="panel-body pa-15">A team leader can earn passive income of 10% per referee referred by your direct descendents.</div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingFour">
                                            <a role="button" data-toggle="collapse" href="#collapseFour" aria-expanded="true" aria-controls="collapseFour">How am I considered a group manager?</a>
                                        </div>
                                        <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                                            <div class="panel-body pa-15">You must be a team leader before hand to "level up" into a group manager. You can then become a group manager by referring 50 marketing agent successfully or by having 10 team leaders as your direct descendents.</div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingFive">
                                            <a role="button" data-toggle="collapse" href="#collapseFive" aria-expanded="true" aria-controls="collapseFive">Why become a group manager?</a>
                                        </div>
                                        <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
                                            <div class="panel-body pa-15">A group manager enjoys the benefit of team leader and at the same time stand a chance to get a percentage of the total commission per month, depending on how active your descendents are.</div>
                                        </div>
                                    </div>
                                </div>
                            @endcomponent
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </dashboard>
@endsection

@section('js')
    <script src="{{ asset( 'js/vendors/jquery.counterup/jquery.counterup.min.js' ) }}"></script>
    <script src="{{ asset( 'js/vendors/waypoints/jquery.waypoints.min.js' ) }}"></script> 
    <script src="{{ asset( 'js/vendors/datatables/jquery.dataTables.min.js' ) }}"></script>
    <script>
        $('#referee-data-table').DataTable();
        $('#units-data-table').DataTable();
    </script> 
@endsection