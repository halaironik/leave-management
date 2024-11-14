<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\LeaveStatusNotification;

class LeaveNotificationService
{
    /**
     * Create a new class instance.
     */
    public function notifyUser(User $user, string $status) 
    {   
        $subject = "Leave Request Status Update";
        
        Mail::to($user->email)->send(new LeaveStatusNotification($user, $status, $subject));
    }
}
