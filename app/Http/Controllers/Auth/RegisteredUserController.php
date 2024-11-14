<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use App\Services\PermissionService;

class RegisteredUserController extends Controller
{
    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            // validate role such that it is either admin or employee
            'role' => ['required', 'in:admin,employee'], 
        ]);

        if($request->role === 'admin' && User::whereHas('roles', fn($query) => $query->where('name', 'admin'))->exists()){
            return redirect()->route('register')->withInput()->withErrors(['role' => 'Admin role already exists. Please register as an employee']);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $this->permissionService->assignRoleToUser($user, $request->role);

        event(new Registered($user));

        Auth::login($user);

        if ($this->permissionService->hasRole('employee')) {
            return redirect(route('dashboard', absolute: false));
        }
            
        return redirect(route('admin.dashboard', absolute: false));

    }
}
