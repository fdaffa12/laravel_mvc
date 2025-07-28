<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        return view('departments.index');
    }

    public function list()
    {
        return response()->json(Department::all());
    }

    public function store(Request $request)
    {
        $request->validate(['dept_name' => 'required|string|max:255']);
        $department = Department::create($request->only('dept_name'));
        return response()->json($department);
    }

    public function update(Request $request, Department $department)
    {
        $request->validate(['dept_name' => 'required|string|max:255']);
        $department->update($request->only('dept_name'));
        return response()->json($department);
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return response()->json(['success' => true]);
    }
}