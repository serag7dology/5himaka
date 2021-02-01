@extends('public.account.layout')

@section('title', trans('storefront::account.pages.wallet_history'))

@section('panel')

    <div class="panel">
        
        <div class="panel-header">
            <h4>{{ trans('storefront::account.pages.wallet_history') }}</h4>

           
        </div>

        
        
        <div class="container" style="padding-top: 40px">
      
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a style="margin-left:20px; margin-right:20px;" class=" nav-link active" data-toggle="tab" href="#tabs-1" role="tab">Personal Wallet</a>
                    </li>
                    <li class="nav-item">
                        <a style="margin-left:20px; margin-right:20px;" class=" nav-link" data-toggle="tab" href="#tabs-2" role="tab">CashBack Wallet </a>
                    </li>
                    <li class="nav-item">
                        <a style="margin-left:20px; margin-right:20px;" class=" nav-link" data-toggle="tab" href="#tabs-3" role="tab">Commision Wallet</a>
                    </li>
                    <li class="nav-item">
                        <a style="margin-left:20px; margin-right:20px;" class=" nav-link" data-toggle="tab" href="#tabs-4" role="tab">Rewards Wallet</a>
                    </li>
                    <li class="nav-item">
                        <a style="margin-left:20px; margin-right:20px;" class=" nav-link" data-toggle="tab" href="#tabs-5" role="tab">Earning Wallet</a>
                    </li>
                </ul><!-- Tab panes -->
                <div class="tab-content">
                    <div style="padding:20px" class="tab-pane active" id="tabs-1" role="tabpanel">
                        @if(count($personal_acount)>0)
                        <div class="table-responsive" >
                            <table class="table table-borderless my-wishlist-table">
                                <thead>
                                    <tr>
                                    <th>Operation</th>
                                    <th>Current Total</th>
                                    <th>Previous Total</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <tr>
                                </thead>
                                <tbody>    
                                @foreach($personal_acount as $wallet)
                                <tr>
                                    <td>{{$wallet->operation_type}}</td>
                                    <td>{{$wallet->current_total}}</td>
                                    <td>{{$wallet->pervious_total}}</td>
                                    <td>{{$wallet->amount_spent}}</td>
                                    <td>{{$wallet->created_at}}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="row alert-warning " > <div class="col-md-12 text-center"style="padding-top:50px;padding-bottom:50px">Empty</div>
                        </div>
                        @endif
                    </div>
                    <div style="padding:20px" class="tab-pane" id="tabs-2" role="tabpanel">
                    @if(count($cachback_caccount)>0)
                        <div class="table-responsive" >
                            <table class="table table-borderless my-wishlist-table">
                                <thead>
                                    <tr>
                                    <th>Operation</th>
                                    <th>Current Total</th>
                                    <th>Previous Total</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <tr>
                                </thead>
                                <tbody>    
                                @foreach($cachback_caccount as $wallet)
                                <tr>
                                    <td>{{$wallet->operation_type}}</td>
                                    <td>{{$wallet->current_total}}</td>
                                    <td>{{$wallet->pervious_total}}</td>
                                    <td>{{$wallet->amount_spent}}</td>
                                    <td>{{$wallet->created_at}}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="row alert-warning " > <div class="col-md-12 text-center"style="padding-top:50px;padding-bottom:50px">Empty</div>
                        </div>
                        @endif
                    </div>
                    <div style="padding:20px" class="tab-pane" id="tabs-3" role="tabpanel">
                    @if(count($commission_acount)>0)
                        <div class="table-responsive" >
                            <table class="table table-borderless my-wishlist-table">
                                <thead>
                                    <tr>
                                    <th>Operation</th>
                                    <th>Current Total</th>
                                    <th>Previous Total</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <tr>
                                </thead>
                                <tbody>    
                                @foreach($commission_acount as $wallet)
                                <tr>
                                    <td>{{$wallet->operation_type}}</td>
                                    <td>{{$wallet->current_total}}</td>
                                    <td>{{$wallet->pervious_total}}</td>
                                    <td>{{$wallet->amount_spent}}</td>
                                    <td>{{$wallet->created_at}}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="row alert-warning " > <div class="col-md-12 text-center"style="padding-top:50px;padding-bottom:50px">Empty</div>
                        </div>
                        @endif
                    </div>
                    <div style="padding:20px" class="tab-pane" id="tabs-4" role="tabpanel">
                    @if(count($cadeau_acount)>0)
                        <div class="table-responsive" >
                            <table class="table table-borderless my-wishlist-table">
                                <thead>
                                    <tr>
                                    <th>Operation</th>
                                    <th>Current Total</th>
                                    <th>Previous Total</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <tr>
                                </thead>
                                <tbody>    
                                @foreach($cadeau_acount as $wallet)
                                <tr>
                                    <td>{{$wallet->operation_type}}</td>
                                    <td>{{$wallet->current_total}}</td>
                                    <td>{{$wallet->pervious_total}}</td>
                                    <td>{{$wallet->amount_spent}}</td>
                                    <td>{{$wallet->created_at}}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="row alert-warning " > <div class="col-md-12 text-center"style="padding-top:50px;padding-bottom:50px">Empty</div>
                        </div>
                        @endif
                    </div>
                    <div style="padding:20px" class="tab-pane" id="tabs-5" role="tabpanel">
                    @if(count($profit_acount)>0)
                        <div class="table-responsive" >
                            <table class="table table-borderless my-wishlist-table">
                                <thead>
                                    <tr>
                                    <th>Operation</th>
                                    <th>Current Total</th>
                                    <th>Previous Total</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <tr>
                                </thead>
                                <tbody>    
                                @foreach($profit_acount as $wallet)
                                <tr>
                                    <td>{{$wallet->operation_type}}</td>
                                    <td>{{$wallet->current_total}}</td>
                                    <td>{{$wallet->pervious_total}}</td>
                                    <td>{{$wallet->amount_spent}}</td>
                                    <td>{{$wallet->created_at}}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="row alert-warning " > <div class="col-md-12 text-center"style="padding-top:50px;padding-bottom:50px">Empty</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
    
        
        
   
        
    </div>
@endsection
