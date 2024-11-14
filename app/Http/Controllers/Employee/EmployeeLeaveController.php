<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EmployeeLeaveController extends Controller
{
    public function getData()
    {
        $leaveRequests = Auth::user()->leaveRequests()->latest()->get();
        return view('employee.partials.leave-requests-table', ['leaveRequests' => $leaveRequests]);
    }
}