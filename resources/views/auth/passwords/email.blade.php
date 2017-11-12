@extends('layouts.outer-layout')

@section('content')
<div class="wrapper pa-0 primary-color-blue">
    <header class="sp-header">
        <div class="sp-logo-wrap pull-left">
            <a href="{{ url('/') }}">
                <img class="brand-img"></img>
                <span class="brand-text">{{ config('app.name', 'Welory Solution') }}</span>
            </a>
        </div>
        <div class="form-group mb-0 pull-right">
            <span class="inline-block pr-10">Don't have an account?</span>
            <a class="inline-block btn btn-info btn-rounded btn-outline" href="{{ route('register') }}?as=investor">Sign Up as an investor</a>
            <a class="inline-block btn btn-info btn-rounded btn-outline" href="{{ route('register') }}?as=agent">Sign Up as an agent</a>
        </div>
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
                                    <h3 class="text-center txt-dark mb-10">Reset your password</h3>
                                </div>  
                                <div class="form-wrap">
                                    @if (session('status'))
                                        <div class="alert alert-success">
                                            {{ session('status') }}
                                        </div>
                                    @endif
                                    <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                                        {{ csrf_field() }}

                                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                            <div class="col-md-6">
                                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                                @if ($errors->has('email'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-6 col-md-offset-4">
                                                Not available for now
                                                {{-- <button type="submit" class="btn btn-primary">
                                                    Send Password Reset Link
                                                </button> --}}
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
