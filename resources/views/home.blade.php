@extends('layouts.app')

@section('content')
    <dashboard inline-template>
        <div class="row">
            @component('components.numbers')
                @slot('color')
                    bg-red
                @endslot

                @slot('icon')
                    <i class="fa fa-4x fa-money text-white"></i>
                @endslot

                @slot('adjective')
                    Total earning
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
                    Earning last month
                @endslot

                {{ auth()->user()->transactions()->profits()->latest()->first() ? auth()->user()->transactions()->profits()->latest()->first()->amount : "0" }}
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

                <span v-text="this.bitcoinUSD"></span>
            @endcomponent
        </div>
    </dashboard>
@endsection
