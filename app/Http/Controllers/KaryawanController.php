<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Department;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        return view('karyawan.index', compact('departments'));
    }

    public function list()
    {
        $data = Karyawan::with('department')->get();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'shift' => 'required|in:Shift 1,Shift 2,Shift 3,Non Shift',
        ]);

        // Generate NIK otomatis
        $last = Karyawan::orderByDesc('id')->first();
        $nextNumber = $last ? ((int) substr($last->nik, 4)) + 1 : 1;
        $nik = '2025' . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);

        $karyawan = Karyawan::create([
            'nik' => $nik,
            'nama' => $request->nama,
            'department_id' => $request->department_id,
            'shift' => $request->shift,
        ]);
        return response()->json($karyawan->load('department'));
    }

    public function update(Request $request, Karyawan $karyawan)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'shift' => 'required|in:Shift 1,Shift 2,Shift 3,Non Shift',
        ]);
        $karyawan->update($request->only('nama', 'department_id', 'shift'));
        return response()->json($karyawan->load('department'));
    }

    public function destroy(Karyawan $karyawan)
    {
        $karyawan->delete();
        return response()->json(['success' => true]);
    }
}