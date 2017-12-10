@extends('layouts.app')

@section('css')
    <link href="{{ asset('/js/vendors/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    <div class="row">
        @if(!auth()->user()->confirmed)
            <div class="col-md-12">
                <div class="alert alert-warning alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <i class="fa fa-warning pr-15 pull-left"></i><p class="pull-left">Your email is not verified. Please proceed to your registered email inbox to verify it.</p>
                    <div class="clearfix"></div>
                </div>
            </div>
        @endif
        @if(auth()->user()->is_default_password) 
            <div class="col-md-12">
                <div class="alert alert-warning alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <i class="fa fa-warning pr-15 pull-left"></i><p class="pull-left">Your password is set as the last 6 digit of your IC number. It is recommended that you <a class="password-link" href="{{ route('user.profile') }}">change your password</a> now</p>
                    <div class="clearfix"></div>
                </div>
            </div>
        @endif
    </div>
    <dashboard isdefaultpassword="{{ auth()->user()->is_default_password }}" investor="{{ auth()->user()->referral_link }}" marketing="{{ auth()->user()->marketing_referral_link }}" confirmed="{{ auth()->user()->confirmed }}" inline-template>
        <div>
            <div class="row">
                @component('components.numbers')
                    @slot('color')
                        bg-red
                    @endslot

                    @slot('icon')
                        <i class="fa fa-4x fa-bitcoin text-white"></i>
                    @endslot

                    @slot('adjective')
                        Total earning cumulated (MYR)
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
                        Total investor payment (MYR)
                    @endslot

                    {{ $payments }}
                @endcomponent
                @component('components.numbers')
                    @slot('color')
                        bg-blue
                    @endslot

                    @slot('icon')
                        <i class="fa fa-server fa-4x text-white"></i>
                    @endslot

                    @slot('adjective')
                        Total machines running
                    @endslot

                    {{ $machines }}
                @endcomponent
                @component('components.numbers')
                    @slot('color')
                        bg-green
                    @endslot

                    @slot('icon')
                        <i class="fa fa-usd fa-4x text-white"></i>
                    @endslot

                    @slot('adjective')
                        Bitcoin current value (USD)
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
                    @if(!auth()->user()->is_admin)
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
                                            @forelse( auth()->user()->getDescendants(1) as $referee )
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
                                </div>
                            </div>
                        @endcomponent
                    @else
                        @component('components.panel')
                            @slot('heading')
                                Unverified users
                            @endslot
                            
                            <div class="table-wrap">
                                <div class="table-responsive"> 
                                    <table id="referee-data-table" class="table table-hover display pb-30">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Date Joined</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Name</th>
                                                <th>Date Joined</th>
                                                <th>Actions</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @forelse( $unverified_users as $user )
                                                <tr>
                                                    <td class="title">{{ $user->name }}</td>
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
                                            @empty
                                                <tr>
                                                    <td colspan="3">
                                                        All users have been verified
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endcomponent
                    @endif
                </div>
                <div class="col-md-6">
                    @component('components.panel')
                        @slot('heading')
                            Units performance
                        @endslot
                        
                        <ul class="unit-list">
                            @forelse(auth()->user()->units as $unit)
                                <li class="flex-row text-white bg-pink">
                                    <i class="fa fa-server text-white"></i>
                                    <a href="{{ route('machine', $unit->machine_id) }}" class="ml-10">
                                        {{ $unit->machine->name }} - {{ $unit->id }}
                                    </a>
                                    <strong class="ml-10 text-bold flex text-center">
                                        Earned MYR {{ $unit->machine->earningSumAfterDate($unit->updated_at)->aggregate / 10 }} so far
                                    </strong>
                                    <span class="ml-10">
                                        Started investment on {{ $unit->updated_at->toDateString() }}
                                    </span>
                                </li>
                            @empty
                                <li>
                                    <span class="text-danger">
                                        You have not invested in any units
                                    </span>
                                </li>
                            @endforelse
                        </ul>  
                    @endcomponent
                    @if(!auth()->user()->is_admin)
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
                                    <div class="cus-sat-stat weight-500 text-center mt-5" :class="milestonePercentageClass">
                                        <span id="milestone-percentage" v-text="milestonePercentage"></span><span>%</span>
                                    </div>
                                    <div class="progress-anim mt-20">
                                        <div class="progress mb-5">
                                            <div class="progress-bar wow animated progress-animated" :class="milestoneProgressBarClass" role="progressbar" :aria-valuenow="milestonePercentage" aria-valuemin="0" aria-valuemax="100" :style="'width:' + milestonePercentage + '%;'"></div>
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
                                    <div class="cus-sat-stat weight-500 text-center mt-5" :class="descendentsPercentageClass">
                                        <span id="active-percentage" v-text="activeDescendents.toFixed(2)"></span><span>%</span>
                                    </div>
                                    <div class="progress-anim mt-20">
                                        <div class="progress mb-5">
                                            <div class="progress-bar wow animated progress-animated" role="progressbar" :class="descendentsProgressBarClass" :aria-valuenow="activeDescendents" aria-valuemin="0" aria-valuemax="100" :style="'width:' + activeDescendents + '%;'"></div>
                                        </div>
                                    </div>
                                    <div class="next-role-description text-center">
                                        Number of active marketing agent under me
                                    </div>
                                @endcomponent
                            </div>
                            
                            @component('components.numbers')
                                @slot('size')
                                    col-lg-6 col-md-6 col-sm-6 col-xs-12 
                                @endslot

                                @slot('color')
                                    bg-blue
                                @endslot

                                @slot('icon')
                                    <i class="fa fa-child fa-4x text-white"></i>
                                @endslot

                                @slot('adjective')
                                    Users referred
                                @endslot

                                {{ auth()->user()->getImmediateDescendants()->count() }}
                            @endcomponent
                            
                            @component('components.numbers')
                                @slot('size')
                                    col-lg-6 col-md-6 col-sm-6 col-xs-12 
                                @endslot

                                @slot('color')
                                    bg-blue
                                @endslot

                                @slot('icon')
                                    <i class="fa fa-money fa-4x text-white"></i>
                                @endslot

                                @slot('adjective')
                                    Total commisions this month (MYR)
                                @endslot

                                {{ $commision }}
                            @endcomponent
                            
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default card-view">
                                    <div class="panel-wrapper collapse in">
                                        <div class="panel-body">
                                            <div class="flex-row flex-center">
                                                <h6 class="flex">My referral links</h6>
                                                @if(auth()->user()->is_verified && auth()->user()->ic_image_path !== "")
                                                    <ul class="list-inline">
                                                        <li><button class="btn btn-success btn-sm" @click="copyInvestor()">Copy Investor URL</button></li>
                                                        <li><button class="btn btn-info btn-sm" @click="copyMarketing()">Copy Agent URL</button></li>
                                                    </ul>
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
                    @endif
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