@extends('layout.master')

@section('content')

@php
//$response = json_decode($response, true);
//dd($response[$response['base_curr']]);
$base_curr = $response['base_curr'];
$rates = $response[$base_curr];
$date = $response['date'];
//dd($rates);
@endphp

<div class="container">
    <h3>Exchange Rates for {{ strtoupper($response['base_curr']) }} as of {{ date('d-M-Y', strtotime($date)) }}</h3>

    <form action="{{ route('showRateDate', ['curr_code'=>$base_curr]) }}" method="POST" class="">
        @csrf
        <div class="row">
            <div class="col-md-2">
                <input class="form-control" type="date" id="rates_date" name="rates_date" value={{$date}} min="2020-11-22" max="{{date('Y-m-d')}}">
            </div>
            <div class="col-md-2">
                <input class="btn btn-primary" id="rate_submit" name="rate_submit" type="submit" value="Update">
            </div>
        </div>
    </form>
    <hr>

    <a href="{{ url('download_csv', ['curr_code'=>$base_curr, 'date'=>$date]) }}" class="btn btn-secondary mb-3">Download as CSV</a>

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">To</th>
                <th scope="col">Value</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rates as $target_curr => $rate)
            <!-- pass if base currency == taget currenct as rate would be 1 -->
            @if($base_curr != $target_curr)
            <tr>
                <th scope="row">{{ strtoupper($target_curr) }}</th>
                <!-- display as float and prevent exponential notation -->
                <td>{{ sprintf("%f", $rate) }}</td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
</div>

@endsection