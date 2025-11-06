<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Subscription;

class ClientComposer
{
    public function compose(View $view)
    {
        $user = Auth::guard('site_user')->user();

        $subscription = null;
        if ($user) {
            $subscription = Subscription::with('plan')
                ->where('user_id', $user->id)
                ->latest()
                ->first();
        }

        $view->with(compact('user', 'subscription'));
    }
}
