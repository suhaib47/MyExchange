@extends('layout.master')

@section('content')

<div class="container">
    <p><h5>{{ $currentDate }}</h5></p>

    <h3>Latest Available Currencies</h3>

    <hr>

    <div class="row mt-4">
        @foreach(json_decode($currencies, true) as $curr_code => $curr_name)
        <!-- <a href="#"> -->
            <div class="col-sm-12 col-md-2 text-center mb-3">
                <div class="card h-100" style="width: 12rem; ">
                    <div class="card-body">
                        <h5 class="card-title">{{ strtoupper($curr_code) }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{$curr_name}}</h6>
                        <a href="{{route('showCurrency', ['curr_code'=> $curr_code ])}}" class="stretched-link"></a>
                    </div>
                </div>
            </div>
        <!-- </a> -->
        @endforeach

    </div>
    
</div>

@endsection