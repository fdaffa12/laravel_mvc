// filepath: resources/views/karyawan/index.blade.php
@extends('layouts.main')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">Data Karyawan</h3>
            <button class="btn btn-primary" id="btnAdd">
                <i class="bi bi-plus-lg me-1"></i> Tambah Karyawan
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered align-middle" id="karyawanTable">
                <thead class="table-light">
                    <tr>
                        <th style="width:60px;">#</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Departemen</th>
                        <th>Shift</th>
                        <th style="width:160px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data via AJAX -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="karyawanModal" tabindex="-1" aria-labelledby="karyawanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="karyawanForm" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="karyawanModalLabel">Tambah Karyawan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="karyawan_id">
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" required>
                            <div class="invalid-feedback" id="nama_error"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Departemen</label>
                            <select class="form-select" id="department_id" required>
                                <option value="">Pilih Departemen</option>
                                @foreach ($departments as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->dept_name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="department_id_error"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Shift</label>
                            <select class="form-select" id="shift" required>
                                <option value="">Pilih Shift</option>
                                <option value="Shift 1">Shift 1</option>
                                <option value="Shift 2">Shift 2</option>
                                <option value="Shift 3">Shift 3</option>
                                <option value="Non Shift">Non Shift</option>
                            </select>
                            <div class="invalid-feedback" id="shift_error"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="saveBtn">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        let karyawanModal = null;
        document.addEventListener('DOMContentLoaded', function() {
            karyawanModal = new bootstrap.Modal(document.getElementById('karyawanModal'));
            loadKaryawan();
        });

        function loadKaryawan() {
            fetch('{{ route('karyawan.list') }}')
                .then(res => res.json())
                .then(data => {
                    let rows = '';
                    data.forEach((k, i) => {
                        rows += `<tr>
                    <td>${i+1}</td>
                    <td>${k.nik}</td>
                    <td>${k.nama}</td>
                    <td>${k.department ? k.department.dept_name : '-'}</td>
                    <td>${k.shift}</td>
                    <td>
                        <button class="btn btn-sm btn-warning me-1" onclick="editKaryawan(${k.id}, '${k.nama.replace(/'/g,"&#39;")}', ${k.department_id}, '${k.shift}')">
                            <i class="bi bi-pencil-square"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="deleteKaryawan(${k.id})">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </td>
                </tr>`;
                    });
                    document.querySelector('#karyawanTable tbody').innerHTML = rows;
                });
        }

        function resetForm() {
            document.getElementById('karyawanForm').reset();
            document.getElementById('karyawan_id').value = '';
            ['nama', 'department_id', 'shift'].forEach(id => {
                document.getElementById(id).classList.remove('is-invalid');
                document.getElementById(id + '_error').innerText = '';
            });
        }

        document.getElementById('btnAdd').addEventListener('click', function() {
            resetForm();
            document.getElementById('karyawanModalLabel').innerText = 'Tambah Karyawan';
            karyawanModal.show();
        });

        window.editKaryawan = function(id, nama, department_id, shift) {
            resetForm();
            document.getElementById('karyawanModalLabel').innerText = 'Edit Karyawan';
            document.getElementById('karyawan_id').value = id;
            document.getElementById('nama').value = nama;
            document.getElementById('department_id').value = department_id;
            document.getElementById('shift').value = shift;
            karyawanModal.show();
        }

        document.getElementById('karyawanForm').addEventListener('submit', function(e) {
            e.preventDefault();
            let id = document.getElementById('karyawan_id').value;
            let nama = document.getElementById('nama').value;
            let department_id = document.getElementById('department_id').value;
            let shift = document.getElementById('shift').value;
            let url = id ? `/karyawan/${id}` : `/karyawan`;
            let method = id ? 'PUT' : 'POST';

            fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        nama,
                        department_id,
                        shift
                    })
                })
                .then(async res => {
                    if (!res.ok) {
                        let data = await res.json();
                        ['nama', 'department_id', 'shift'].forEach(id => {
                            document.getElementById(id).classList.remove('is-invalid');
                            document.getElementById(id + '_error').innerText = '';
                        });
                        if (data.errors) {
                            for (let key in data.errors) {
                                document.getElementById(key).classList.add('is-invalid');
                                document.getElementById(key + '_error').innerText = data.errors[key][0];
                            }
                        }
                        throw new Error('Validation error');
                    }
                    return res.json();
                })
                .then(() => {
                    karyawanModal.hide();
                    loadKaryawan();
                })
                .catch(() => {});
        });

        window.deleteKaryawan = function(id) {
            if (confirm('Yakin ingin menghapus karyawan ini?')) {
                fetch(`/karyawan/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(() => loadKaryawan());
            }
        }
    </script>
@endsection
