@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if( !is_null(auth()->user()->referrer) )
                        Your referrer : {{ auth()->user()->referrer->name }}
                    @endif

                    @if(auth()->user()->referees_count > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Date joined</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(auth()->user()->referees as $referee)
                            <tr>
                                <td>{{ $referee->id }}</td>
                                <td>{{ $referee->name }}</td>
                                <td>{{ $referee->created_at }}<i class="fa fa-facebook"></i></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                        <p>You have yet to refer someone</p>
                    @endif

                    Your referral link : {{ auth()->user()->referral_link }}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
