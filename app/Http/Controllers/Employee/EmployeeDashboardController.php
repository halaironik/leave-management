<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leaveRequests = auth()->user()->leaveRequests;
        return view('employee.dashboard', ['leaveRequests' => $leaveRequests]);
    }

    /**
     * Show the form for submitting a leave request.
     */
    public function createLeaveRequestForm()
    {
        return view('employee.leave_request_form');
    }

    /**
     * Store a newly created leave request in database.
     */
    public function store(Request $request)
    {   
        try {
            $request->validate([
                'start_date' => 'required|date|after_or_equal:today',
                'end_date' => 'required|date|after_or_equal:start_date',
                'reason' => 'required|string|max:255',
            ]);
            
            Auth::user()->leaveRequests()->create([
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'reason' => $request->reason
            ]);
    
            return ResponseService::successRedirectResponse('Leave request submitted successfully.', 'dashboard');
        } catch (\Exception $e) {
            return ResponseService::logErrorRedirect($e, 'Failed to submit leave request', 'An error occurred while submitting the leave request.');
        }
    }
}
