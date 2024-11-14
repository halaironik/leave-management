<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Services\LeaveNotificationService;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class LeaveRequestsController extends Controller
{
    protected $leaveNotificationService;

    public function __construct(LeaveNotificationService $leaveNotificationService) 
    {
        $this->leaveNotificationService = $leaveNotificationService;
    }
 
    /**
     * Display a listing of the leave requests.
     */
    public function index()
    {
        $leaveRequests = LeaveRequest::with('user')->get();
        return view('admin.dashboard', ['leaveRequests' => $leaveRequests]);
    }

    /**
     * Approve leave request.
     */
    public function approve($id)
    {
        try{
            $leaveRequest = LeaveRequest::findOrFail($id);
            $leaveRequest->update(['status' => 'approved']);
    
            $this->leaveNotificationService->notifyUser($leaveRequest->user, $leaveRequest->status);
    
            return ResponseService::successRedirectResponse('Leave request approved.', 'admin.dashboard');
        
        } catch (\Exception $e) {
         
            return ResponseService::logErrorRedirect($e, 'Failed to approve leave request', 'An error occurred while approving the leave request.');

        }
    }


    /**
     * Reject leave request.
     */
    public function reject($id)
    {
        try{
            $leaveRequest = LeaveRequest::findOrFail($id);
            $leaveRequest->update(['status' => 'rejected']);
    
            $this->leaveNotificationService->notifyUser($leaveRequest->user, $leaveRequest->status);

            return ResponseService::successRedirectResponse('Leave request rejected.', 'admin.dashboard');
       
        } catch (\Exception $e) {
           
            return ResponseService::logErrorRedirect($e, 'Failed to reject leave request', 'An error occurred while rejecting the leave request.');

        }
    }

    /**
     * Delete a leave request.
     */
    public function destroy(String $id)
    {
        try{
            $leaveRequest = LeaveRequest::findOrFail($id);
            $leaveRequest->delete();
            
            return ResponseService::successRedirectResponse('Leave request deleted.', 'admin.dashboard');
        
        } catch (\Exception $e) {
            
            return ResponseService::logErrorRedirect($e, 'Failed to delete leave request', 'An error occurred while deleting the leave request.');
            
        }
    }

    /**
     * Retrieves all leave requests with associated user data and displays them in a table view.
     * @return \Illuminate\View\View
     */
    public function getData()
    {   
        $leaveRequests = LeaveRequest::with('user')->latest()->get();
        return view('admin.partials.admin-requests-table', ['leaveRequests' => $leaveRequests]);
    }

}
