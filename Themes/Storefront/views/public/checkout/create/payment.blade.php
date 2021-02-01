  <div class="title m-b-md">
   <p> Payment</p>
</div>
<div class="links">
   <a style="display: inherit;
    margin: 10px;
    width: 50%;" class="btn btn-primary" href="{{ route('card',\Cart::total()->amount()) }}">Credit Card</a>
   <a style="display: inherit;
    margin: 10px;
    width: 50%;" class="btn btn-info"   href="{{ route('kiosk',\Cart::total()->amount()) }}">Accept Number</a>
   <a style="display: inherit;
    margin: 10px;
    width: 50%;" class="btn btn-danger" href="{{ route('fawry',\Cart::total()->amount()) }}">Fawry Number</a>
   <a style="display: inherit;
    margin: 10px;
    width: 50%;" class="btn btn-warning" href="{{ route('wallet',[\Cart::total()->amount(),1]) }}">Comission Wallet</a>
   <a style="display: inherit;
    margin: 10px;
    width: 50%;" class="btn btn-success" href="{{ route('wallet',[\Cart::total()->amount(),2]) }}">Personal Wallet</a>
   
</div>