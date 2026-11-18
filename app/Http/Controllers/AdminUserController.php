<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    public function index()
    {
        $admins = User::orderBy('role', 'desc')->orderBy('name')->get();

        return view('admins.index', compact('admins'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users,name'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $admin = User::create([
            'name' => $validated['name'],
            'password' => $validated['password'],
            'role' => 'admin',
        ]);

        $this->recordActivity($request, 'admin.created', "Admin {$admin->name} ditambahkan");

        return redirect()
            ->route('admins.index')
            ->with('status', "Admin {$admin->name} berhasil ditambahkan");
    }

    public function edit($id)
    {
        $admin = User::findOrFail($id);

        if ($admin->isSuperAdmin()) {
            return redirect()
                ->route('admins.index')
                ->withErrors(['admin' => 'Akun superadmin diubah lewat halaman Settings.']);
        }

        return view('admins.edit', compact('admin'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $admin = User::findOrFail($id);

        if ($admin->isSuperAdmin()) {
            return redirect()
                ->route('admins.index')
                ->withErrors(['admin' => 'Akun superadmin diubah lewat halaman Settings.']);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('users', 'name')->ignore($admin->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $data = ['name' => $validated['name']];

        if (! empty($validated['password'])) {
            $data['password'] = $validated['password'];
        }

        $admin->update($data);

        $this->recordActivity($request, 'admin.updated', "Admin {$admin->name} diubah");

        return redirect()
            ->route('admins.index')
            ->with('status', "Admin {$admin->name} berhasil diperbarui");
    }


    public function destroy(Request $request, $id): RedirectResponse
    {
        $admin = User::findOrFail($id);

        if ($admin->isSuperAdmin()) {
            return redirect()
                ->route('admins.index')
                ->withErrors(['admin' => 'Akun superadmin tidak bisa dihapus.']);
        }

        $adminName = $admin->name;
        $admin->delete();

        $this->recordActivity($request, 'admin.deleted', "Admin {$adminName} dihapus");

        return redirect()
            ->route('admins.index')
            ->with('status', "Admin {$adminName} berhasil dihapus");
    }

    private function recordActivity(Request $request, string $action, string $description): void
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'description' => $description,
            'ip_address' => $request->ip(),
        ]);
    }
}