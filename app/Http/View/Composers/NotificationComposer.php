<?php

namespace App\Http\View\Composers;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Business;
use App\Branch;
use App\Transfer;
class NotificationComposer
{
    /**
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        if(auth()->user()->business_id == 0 and auth()->user()->branch_id == 0){
            $count = 0;
        }else{

            $notification =  Business::find(auth()->user()->business_id)->sales()->withCount('transfer')->get();
            $count = 0;
            foreach ($notification as $not) {
                $count += $not->transfer_count;
            }
        }

        $view->with('notification', $count);
    }
}

?>