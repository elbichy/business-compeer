<?php

namespace App\Http\View\Composers;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\User;
class NotificationComposer
{
    /**
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $notification =  User::find(auth()->user()->id);
        // dd($notification->notifications);
        $view->with('notification', $notification);
    }
}

?>