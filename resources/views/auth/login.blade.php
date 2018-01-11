@extends('layouts.outer-layout')

@section('content')
<div class="page-wrapper pa-0 ma-0 auth-page">
    <div class="container-fluid">
    <!-- Row -->
        <div class="table-struct full-width full-height">
            <div class="table-cell vertical-align-middle auth-form-wrap">
                <div class="auth-form  ml-auto mr-auto no-float">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <div class="mb-30">
                                <h3 class="text-center txt-dark mb-10">Sign in to {{ config('app.name', 'Welory Solution') }}</h3>
                                <h6 class="text-center nonecase-font txt-grey">Enter your details below</h6>
                            </div>  
                            <div class="form-wrap">
                                <form method="POST" action="{{ route('login') }}">
                                    {{ csrf_field() }}
                                    <div class="form-group{{ $errors->has('email') ? ' has-error has-danger' : '' }}{{ $errors->has('email') ? ' has-error has-danger' : '' }}">
                                        <label class="control-label mb-10" for="email">Email address</label>
                                        <input name="email" type="email" class="form-control" required="" id="email" placeholder="Enter email">
                                        @if($errors->has('email'))
                                            <div class="help-block with-errors">
                                                <ul class="list-unstyled">
                                                    <li>{{ $errors->first('email') }}</li>
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('password') ? ' has-error has-danger' : '' }}{{ $errors->has('password') ? ' has-error has-danger' : '' }}">
                                        <label class="pull-left control-label mb-10" for="password">Password</label>
                                        <a class="capitalize-font txt-primary block mb-10 pull-right font-12" href="{{ route('password.request') }}">forgot password ?</a>
                                        <div class="clearfix"></div>
                                        <input name="password" type="password" class="form-control" required="" id="password" placeholder="Enter password">
                                        @if($errors->has('password'))
                                            <div class="help-block with-errors">
                                                <ul class="list-unstyled">
                                                    <li>{{ $errors->first('password') }}</li>
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                            
                                    <div class="form-group">
                                        <div class="checkbox checkbox-primary pr-10 pull-left">
                                            <input name="remember" id="remember" type="checkbox">
                                            <label for="remember"> Keep me logged in</label>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="form-group text-center">
                                        <button type="submit" class="btn btn-info btn-rounded">sign in</button>
                                        <p class="mt-10">Don't have an account?</p>
                                        <ul class="list-inline">
                                            <li><a class="btn btn-info btn-rounded btn-outline mb-10" href="{{ route('register') }}?as=investor">Sign Up as customer</a></li>
                                            <li><a class="btn btn-info btn-rounded btn-outline" href="{{ route('register') }}?as=agent">Sign Up as agent</a></li>
                                        </ul>
                                    </div>

                                    <div class="social-medias">
                                        <a class="facebook" href="https://www.facebook.com/pmantech/" _target="blank"><i class="fa fa-facebook mr-5"></i> Connect to our facebook</a>
                                    </div>
                                </form>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    <!-- /Row -->   
    </div>       
</div>
@endsection
