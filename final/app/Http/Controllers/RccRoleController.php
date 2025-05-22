<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RccRole;

class RccRoleController extends Controller
{
    public function index()
    {
        return RccRole::all();
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'rcc_role_name' => 'required|string|unique:rcc_roles,rcc_role_name',
        ]);
        $role = RccRole::create($data);
        return response()->json($role, 201);
    }

    public function show(RccRole $role)
    {
        return $role;
    }

    public function update(Request $r, RccRole $role)
    {
        $data = $r->validate([
            'rcc_role_name' => 'required|string|unique:rcc_roles,rcc_role_name,' . $role->rcc_role_id . ',rcc_role_id',
        ]);
        $role->update($data);
        return response()->json($role);
    }

    public function destroy(RccRole $role)
    {
        $role->delete();
        return response()->json(null, 204);
    }
}
