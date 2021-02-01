@extends('public.account.layout')

@section('title', trans('storefront::account.pages.dashboard'))

@section('panel')
    @if ($recentOrders->isNotEmpty())
        <div class="panel">
            <div class="panel-header">
                <h4>{{ trans('storefront::account.dashboard.recent_orders') }}</h4>

                <a href="{{ route('account.orders.index') }}">
                    {{ trans('storefront::account.dashboard.view_all') }}
                </a>
            </div>

            <div class="panel-body">
                @include('public.account.partials.orders_table', ['orders' => $recentOrders])
            </div>
        </div>
    @endif

    <div class="panel">
        
        <div class="panel-header">
            <h4>{{ trans('storefront::account.dashboard.account_information') }} </h4>
            <input id="myInput" style="width:50%"   cols="30" rows="4" class="form-control" value="<?php echo env('APP_URL') .'/en/register?code='.auth()->id();?>"></input>
         

         <!-- The button used to copy the text -->
        <button class="btn btn-info" onclick="myFunction()"><i class="fas fa-copy "></i> Copy </button>
            <a href="{{ route('account.profile.edit') }}">
                {{ trans('storefront::account.dashboard.edit') }}
            </a>
        </div>

        
        
        <div class="container" style="padding-top: 40px">
            <div class="row">
                <div class="col-md-3 money-box" style="">
                    <b>Personal Wallet</b>     
                    <p style="padding-top: 20px; font-size: 30px;">0 EGP</p>
                </div>
                <div class="col-md-3  money-box">
                    <b>CashBack Wallet     </b>   
                    <p  style="padding-top: 20px; font-size: 30px;">0 EGP</p>
                    
                </div>
                <div class="col-md-3  money-box">
                    <b>Commision Wallet    </b>  
                    <p  style="padding-top: 20px; font-size: 30px;">0 EGP</p>
                </div>
                <div class="col-md-3  money-box">
                    <b>Rewards Wallet  </b>   
                    <p  style="padding-top: 20px; font-size: 30px;">0 EGP</p>
                </div>
                <div class="col-md-3 money-box">
                    <b>Earning Wallet   </b>     
                    <p  style="padding-top: 20px; font-size: 30px;">0 EGP</p>
                </div>
            </div>
        </div>
        <div id="snackbar" style="display:none">Copied!</div>
        
        <div class="panel-body"  style="margin-top: 40px; border-top: 1px;">
            <ul class="list-inline user-info">
                <li>
                    <i class="las la-user-circle"></i>
                    <span>{{ $account->full_name }}</span>
                </li>

                <li>
                    <i class="las la-envelope"></i>
                    <span>{{ $account->email }}</span>
                </li>
            </ul>
        </div>
        
    </div>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script>
  function showMessage() {
  var x = document.getElementById("snackbar");
   x.className = "show";
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
  }
function myFunction() {
  var copyText = document.getElementById("myInput");
  copyText.select();
  copyText.setSelectionRange(0, 99999); 
  document.execCommand("copy");
  showMessage();
//  alert('Copy Success')
}
    </script>
@endsection
