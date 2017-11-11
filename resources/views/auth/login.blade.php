@extends('layouts.outer-layout')

@section('content')
<div class="wrapper pa-0 primary-color-blue">
    <header class="sp-header">
        <div class="sp-logo-wrap pull-left">
            <a href="{{ url('/') }}">
                <img class="brand-img"></img>
                <span class="brand-text">{{ env("APP_NAME", "Welory Solution") }}</span>
            </a>
        </div>
        <div class="form-group mb-0 pull-right">
            <span class="inline-block pr-10">Don't have an account?</span>
            <a class="inline-block btn btn-info btn-rounded btn-outline" href="{{ route('register') }}?as=investor">Sign Up as an investor</a>
            <a class="inline-block btn btn-info btn-rounded btn-outline" href="{{ route('register') }}?as=agent">Sign Up as an agent</a>
        </div>
        <div class="clearfix"></div>
    </header>
    <div class="page-wrapper pa-0 ma-0 auth-page">
        <div class="container-fluid">
        <!-- Row -->
            <div class="table-struct full-width full-height">
                <div class="table-cell vertical-align-middle auth-form-wrap">
                    <div class="auth-form  ml-auto mr-auto no-float">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <div class="mb-30">
                                    <h3 class="text-center txt-dark mb-10">Sign in to {{ env("APP_NAME", "Welory Solution") }}</h3>
                                    <h6 class="text-center nonecase-font txt-grey">Enter your details below</h6>
                                </div>  
                                <div class="form-wrap">
                                    <form method="POST" action="{{ route('login') }}">
                                        <div class="form-group">
                                            <label class="control-label mb-10" for="email">Email address</label>
                                            <input name="email" type="email" class="form-control" required="" id="email" placeholder="Enter email">
                                        </div>
                                        <div class="form-group">
                                            <label class="pull-left control-label mb-10" for="password">Password</label>
                                                <a class="capitalize-font txt-primary block mb-10 pull-right font-12" href="{{ route('password.request') }}">forgot password ?</a>
                                                <div class="clearfix"></div>
                                                <input name="password" type="password" class="form-control" required="" id="password" placeholder="Enter password">
                                        </div>
                                                
                                        <div class="form-group">
                                            <div class="checkbox checkbox-primary pr-10 pull-left">
                                                <input name="remember" id="remember" required="" type="checkbox">
                                                <label for="remember"> Keep me logged in</label>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="form-group text-center">
                                            <button type="submit" class="btn btn-info btn-rounded">sign in</button>
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
</div>
@endsection
