
@extends('layouts.app')

@section('content')
<div class="title m-b-md">
    <p> Payment</p>
 </div>
 <div class="links">
    <a class="btn btn-primary" href="{{ route('card',{{ $subscription_cost }}) }}">Credit Card</a>
    <a class="btn btn-info"   href="{{ route('kiosk',{{ $subscription_cost }}) }}">Accept Number</a>
      <a class="btn btn-danger" href="{{ route('fawry',{{ $subscription_cost }}) }}">Fawry Number</a>
    
 </div>
@endsection


