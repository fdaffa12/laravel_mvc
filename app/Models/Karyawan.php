<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;
    protected $fillable = ['nik', 'nama', 'department_id', 'shift'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}