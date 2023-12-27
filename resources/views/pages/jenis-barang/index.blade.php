@extends('layouts/app')
@section('content')
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Jenis Barang</a></li>
            </ol>
        </div>
    </div>
    <div class="mx-4" id="message" style="display: none;">
        <div class="alert alert-primary" role="alert">
            {{ session()->get('message') }}
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Jenis Barang</h4>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal"><i class="fa fa-plus"></i> Add</button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration" id="jenisBarangTbl">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Jenis Barang</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <form id="addForm" name="addForm" onsubmit="event.preventDefault(); sendAjaxRequest(addForm)"
                action="{{ route('jenis-barang.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="error-bag"></div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" name="nama">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Jenis Barang</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <form id="editForm" name="editForm" onsubmit="event.preventDefault(); sendAjaxRequest(editForm)"
                action="{{ route('jenis-barang.update') }}" method="post">
                    @csrf
                    <input type="hidden" name="jenis_barang_id">
                    <div class="modal-body">
                        <div class="error-bag"></div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" name="nama">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#jenisBarangTbl').dataTable({
                ajax: "{{ route('datatables') }}?type=jenis-barang",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
            })
        });

        function editData(data){
            $("#editForm input[name=jenis_barang_id]").val(data.id);
            $("#editForm input[name=nama]").val(data.nama);
            $('#editModal').modal('show')
        }
        
        function deleteData(id){
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                icon: 'question',
                text: 'Data yang telah dihapus tidak dapat dipulihkan. Tetap hapus?',
                showCancelButton: true,
                cancelButtonColor: '#0E87FF',
                showCloseButton: true,
                confirmButtonText: 'Tetap hapus',
                confirmButtonColor: '#DB0E20',
                allowEnterKey: false
            }).then((res) => {
                if (res.isConfirmed) {
                    swalLoading()
                    $.ajax({
                        url: "{{ route('jenis-barang.delete') }}",
                        data: {
                            _token: "{{csrf_token()}}",
                            _method: 'DELETE',
                            jenis_barang_id: id,
                        },
                        type: 'POST',
                        success: (res) => {
                            if (res.success) {
                                Swal.fire({
                                    title: 'Success!',
                                    icon: 'success',
                                    text: res.message,
                                })
                                reloadTable('.dataTable')
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    icon: 'error',
                                    text: res.message,
                                })
                            }
                        },
                        error: (err) => {
                            Swal.fire({
                                title: 'Error!',
                                icon: 'error',
                                text: err.responseJSON.message,
                            })
                        }
                    })
                }
            })
        }

        function sendAjaxRequest(form) {
            data = new FormData(form)
            url = $(form).attr('action')
            formId = $(form).attr('id')
            $(`#${formId} .errorBag`).html('')
            swalLoading()
            $.ajax({
                type: $(form).attr('method'),
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data,
                contentType: false,
                processData: false,
                success: (res) => {
                    if (res.success) {
                        Swal.fire({
                            title: 'Success!',
                            icon: 'success',
                            text: res.message,
                        })
                        $('.modal').modal('hide')
                        $(form).trigger('reset')
                        reloadTable('.dataTable')
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            icon: 'error',
                            text: res.message,
                        })
                    }
                },
                error: (err) => {
                    if (err.status === 422) {
                        Swal.fire({
                            title: "Error!",
                            icon: 'error',
                            text: err.responseJSON.message
                        })
                        $(`#${formId} .error-bag`).html(
                            '<div class="alert alert-danger mt-2"><h5>Oops! Ada yang salah!</h5><ul></ul></div>'
                        )
                        err.responseJSON.errors.forEach((msg, i) => {
                            $(`#${formId} .error-bag ul`).append(`<li>${msg}</li>`)
                        })
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            icon: 'error',
                            text: err.responseJSON.message,
                        })
                    }
                }
            })
        }
    </script>
@endsection