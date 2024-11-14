<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\PermissionService;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    protected $responseService;
    protected $permissionService;

    public function __construct(ResponseService $responseService, PermissionService $permissionService) 
    {
        $this->responseService = $responseService;
        $this->permissionService = $permissionService;
    }
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        $users = User::all();
        return view('admin.employee_management', ['users' => $users]);
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('admin.add_employee');
    }

    /**
     * Store a newly created.
     */
    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'unique:users'],
                'password' => ['required', 'min:6', Rules\Password::defaults()],
                'role' => ['required', 'in:admin,employee'],
            ]);

            if($validator->fails()) {
                return $this->responseService->validationErrorResponse(
                    $validator->errors()->toArray(),
                    $request->all
                );
            }
    
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $this->permissionService->assignRoleToUser($user, $request->role);

            if (!$user) {
                return $this->responseService->errorRedirectResponse( 
                    'Failed to create user. Please try again.', 
                    'admin.user.index'
                );
            }
           
            return $this->responseService->successRedirectResponse('User created successfully.', 'admin.user.index');
       
        } catch (\Exception $e) {
         
            return $this->responseService->logErrorRedirect($e, 'Failed to create user', 'An error occurred while creating the user.');

        }
    }

    /**
     * Show the form for editing the user.
     */
    public function edit(string $id)
    {
        $user = User::findorFail($id);

        return view('admin.edit_employee_form', ['user' => $user]);
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, string $id)
    {
        try {
            $user = User::findOrFail($id);
    
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'unique:users,email,'.$user->id],
                'role' => ['required', 'in:admin,employee'],
            ]);

            if($validator->fails()) {
                return $this->responseService->validationErrorResponse(
                    $validator->errors()->toArray(),
                    $request->all()
                );
            }
    
            $updated = $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            $this->permissionService->syncUserRole($user, $request->role);

            if(!$updated) {
                return $this->responseService->errorRedirectResponse(
                    'Failed to update user. Please try again.', 
                    'admin.user.index'
                );
            }
           
            return $this->responseService->successRedirectResponse('User updated successfully.', 'admin.user.index');
        
        } catch (\Exception $e) {
           
            return $this->responseService->logErrorRedirect($e, 'Failed to update user', 'An error occurred while updating the user.');

        }
    }

    /**
     * Remove the specified user from database.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
    
            $user->delete();
            
            return $this->responseService->successRedirectResponse('User deleted successfully.', 'admin.user.index');
        
        } catch (\Exception $e) {
            
            return $this->responseService->logErrorRedirect($e, 'Failed to delete user', 'An error occurred while deleting the user.');

        }
    }
}
