<?php

namespace App\Http\View\Composers;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Business;
use App\Branch;
class NotificationComposer
{
    /**
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        try {
            $notification =  Business::find(auth()->user()->business_id)->sales()->with('transfer')->count();
        } catch (\Throwable $th) {
            $notification = 0;
        }
        $view->with('notification', $notification);
    }
}

?>