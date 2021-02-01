<?php

namespace Modules\Account\Http\Controllers;

use Modules\User\Http\Requests\UpdateProfileRequest;
use Modules\Withdraw\Entities\WithdrawsWay;

class AccountProfileController
{
    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $withdraw_methods=WithdrawsWay::where('is_active',1)->get();
        
        
    
        return view('public.account.profile.edit', [
                
            'withdraws_methods'=>$withdraw_methods,
            'account' => auth()->user(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Modules\User\Http\Requests\UpdateProfileRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfileRequest $request)
    {
        $request->bcryptPassword($request);
        
        auth()->user()->update($request->all());

        return back()->with('success', trans('account::messages.profile_updated'));
    }
}
