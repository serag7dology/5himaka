<?php

namespace Modules\Account\Http\Controllers;

use Modules\User\Entities\WalletHistory;
use Modules\User\Entities\WalletHistoryTranslation;
use Modules\User\Entities\User;

class AccountWalletHistoryController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cachback_caccount =  WalletHistory::where('wallet_id',auth()->user()->id)->where('wallet_type','cachback_caccount')->get(); 
        $commission_acount =  WalletHistory::where('wallet_id',auth()->user()->id)->where('wallet_type','commission_acount')->get(); 
        $cadeau_acount =  WalletHistory::where('wallet_id',auth()->user()->id)->where('wallet_type','cadeau_acount')->get(); 
        $profit_acount =  WalletHistory::where('wallet_id',auth()->user()->id)->where('wallet_type','profit_acount')->get(); 
        $personal_acount =  WalletHistory::where('wallet_id',auth()->user()->id)->where('wallet_type','personal_acount')->get(); 
 

        return view('public.account.wallet_history.index', [
            'account' => auth()->user(),
            'cachback_caccount' => $cachback_caccount,
            'commission_acount' => $commission_acount,
            'cadeau_acount'     => $cadeau_acount,
            'profit_acount'     => $profit_acount,
            'personal_acount'   => $personal_acount,
            'recentOrders'      => auth()->user()->recentOrders(5),
        ]);
        return view('public.account.wallet_history.index');
    }
}
