<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Get admin users with pagination
        $adminUsers = (clone $query)
            ->where('role', 'admin')
            ->paginate(10);

        // Get client users with pagination
        $clientUsers = (clone $query)
            ->where('role', 'client')
            ->paginate(10);

        return view('admin.users.index', compact('adminUsers', 'clientUsers'));
    }

    public function store(Request $request)
    {
        try {
            Log::info('Attempting to create new admin user', ['request_data' => $request->all()]);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);

            Log::info('Validation passed', ['validated_data' => $validated]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'admin',
            ]);

            Log::info('User created successfully', ['user_id' => $user->id]);

            return redirect()->route('admin.users.index')
                ->with('success', 'Admin user created successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to create admin user', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create admin user: ' . $e->getMessage());
        }
    }

    public function update(Request $request, User $user)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            ]);

            $user->update($validated);

            return redirect()->route('admin.users.index')
                ->with('success', 'Admin user updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update admin user: ' . $e->getMessage());
        }
    }

    public function destroy(User $user)
    {
        try {
            if ($user->role !== 'admin') {
                return redirect()->back()
                    ->with('error', 'Only admin users can be deleted from this interface.');
            }

            $user->delete();

            return redirect()->route('admin.users.index')
                ->with('success', 'Admin user deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete admin user: ' . $e->getMessage());
        }
    }
} 