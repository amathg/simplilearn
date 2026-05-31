<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoleController extends Controller {

    public function index() {
        $bid   = session('boutique_id');
        $roles = Role::where('boutique_id', $bid)->with('permissions')->get();
        $permissions = Permission::orderBy('module')->get();
        return view('admin.roles.index', compact('roles','permissions'));
    }

    public function store(Request $request) {
        $bid = session('boutique_id');
        $request->validate(['nom' => 'required|string|max:50']);
        $role = Role::create([
            'boutique_id' => $bid,
            'nom'         => $request->nom,
            'slug'        => Str::slug($request->nom).'-'.$bid,
            'description' => $request->description,
        ]);
        if ($request->permissions) {
            $role->permissions()->sync($request->permissions);
        }
        return back()->with('ok', 'Rôle créé.');
    }

    public function update(Request $request, Role $role) {
        $role->update(['nom' => $request->nom, 'description' => $request->description]);
        if ($request->permissions) {
            $role->permissions()->sync($request->permissions);
        }
        return back()->with('ok', 'Rôle mis à jour.');
    }

    public function destroy(Role $role) {
        $role->delete();
        return back()->with('ok', 'Rôle supprimé.');
    }

    public function create() { return redirect()->route('admin.roles.index'); }
    public function edit(Role $role) { return redirect()->route('admin.roles.index'); }
    public function show(Role $role) { return redirect()->route('admin.roles.index'); }
}