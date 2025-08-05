<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['dept_name'];

    // Relasi one-to-many: Satu department bisa memiliki banyak karyawan
    // Dengan ini, kita bisa akses semua karyawan dari sebuah department
    public function karyawans()
    {
        return $this->hasMany(Karyawan::class);
    }
}