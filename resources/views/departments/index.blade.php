@extends('layouts.main')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">Data Departemen</h3>
            <button class="btn btn-primary" id="btnAdd">
                <i class="bi bi-plus-lg me-1"></i> Tambah Departemen
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered align-middle" id="deptTable">
                <thead class="table-light">
                    <tr>
                        <th style="width:60px;">#</th>
                        <th>Nama Departemen</th>
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
    <div class="modal fade" id="deptModal" tabindex="-1" aria-labelledby="deptModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="deptForm" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deptModalLabel">Tambah Departemen</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="dept_id">
                        <div class="mb-3">
                            <label for="dept_name" class="form-label">Nama Departemen</label>
                            <input type="text" class="form-control" id="dept_name" required>
                            <div class="invalid-feedback" id="dept_name_error"></div>
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
        let deptModal = null;
        document.addEventListener('DOMContentLoaded', function() {
            deptModal = new bootstrap.Modal(document.getElementById('deptModal'));
            loadDepartments();
        });

        function loadDepartments() {
            fetch('{{ route('departemen.list') }}')
                .then(res => res.json())
                .then(data => {
                    let rows = '';
                    data.forEach((dept, i) => {
                        rows += `<tr>
                    <td>${i+1}</td>
                    <td>${dept.dept_name}</td>
                    <td>
                        <button class="btn btn-sm btn-warning me-1" onclick="editDept(${dept.id}, '${dept.dept_name.replace(/'/g,"&#39;")}')">
                            <i class="bi bi-pencil-square"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="deleteDept(${dept.id})">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </td>
                </tr>`;
                    });
                    document.querySelector('#deptTable tbody').innerHTML = rows;
                });
        }

        function resetForm() {
            document.getElementById('deptForm').reset();
            document.getElementById('dept_id').value = '';
            document.getElementById('dept_name').classList.remove('is-invalid');
            document.getElementById('dept_name_error').innerText = '';
        }

        document.getElementById('btnAdd').addEventListener('click', function() {
            resetForm();
            document.getElementById('deptModalLabel').innerText = 'Tambah Departemen';
            deptModal.show();
        });

        window.editDept = function(id, name) {
            resetForm();
            document.getElementById('deptModalLabel').innerText = 'Edit Departemen';
            document.getElementById('dept_id').value = id;
            document.getElementById('dept_name').value = name;
            deptModal.show();
        }

        document.getElementById('deptForm').addEventListener('submit', function(e) {
            e.preventDefault();
            let id = document.getElementById('dept_id').value;
            let name = document.getElementById('dept_name').value;
            let url = id ? `/departemen/${id}` : `/departemen`;
            let method = id ? 'PUT' : 'POST';

            fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        dept_name: name
                    })
                })
                .then(async res => {
                    if (!res.ok) {
                        let data = await res.json();
                        if (data.errors && data.errors.dept_name) {
                            document.getElementById('dept_name').classList.add('is-invalid');
                            document.getElementById('dept_name_error').innerText = data.errors.dept_name[0];
                        }
                        throw new Error('Validation error');
                    }
                    return res.json();
                })
                .then(() => {
                    deptModal.hide();
                    loadDepartments();
                })
                .catch(() => {});
        });

        window.deleteDept = function(id) {
            if (confirm('Yakin ingin menghapus departemen ini?')) {
                fetch(`/departemen/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(() => loadDepartments());
            }
        }
    </script>
@endsection
