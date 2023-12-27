@extends('layouts/app')
@section('content')
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Stok Masuk</a></li>
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
                            <h4 class="card-title">Stok Masuk</h4>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal"><i class="fa fa-plus"></i> Add</button>
                            </div>
                        </div>

                        <form action="{{ route('stok.masuk.index') }}" method="get" class="m-4">
                            <div class="row align-items-end mx-2">
                                <div class="col-md-2 px-1">
                                    <div class="form-group">
                                        <label>User</label>
                                        <select class="form-control" name="user_id" id="user_id">
                                            <option value="0">--All--</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                            @if (request()->has('user_id'))
                                                <script>
                                                    $(`#user_id`).val("{{ Request::get('user_id') }}").change()
                                                </script>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 px-1">
                                    <div class="form-group">
                                        <label>Suplier</label>
                                        <select class="form-control" name="suplier_id" id="suplier_id">
                                            <option value="0">--All--</option>
                                            @foreach ($supliers as $sup)
                                                <option value="{{ $sup->id }}">{{ $sup->nama }}</option>
                                            @endforeach
                                            @if (request()->has('suplier_id'))
                                                <script>
                                                    $(`#suplier_id`).val("{{ Request::get('suplier_id') }}").change()
                                                </script>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 px-1">
                                    <div class="form-group">
                                        <label>Barang</label>
                                        <select class="form-control" name="barang_id" id="barang_id">
                                            <option value="0">--All--</option>
                                            @foreach ($barang as $brg)
                                                <option value="{{ $brg->id }}">{{ $brg->nama }}</option>
                                            @endforeach
                                            @if (request()->has('barang_id'))
                                                <script>
                                                    $(`#barang_id`).val("{{ Request::get('barang_id') }}").change()
                                                </script>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 px-1">
                                    <div class="form-group">
                                        <label>Tanggal Awal</label>
                                        <input type="date" class="form-control " name="date_start" id="date_start" value="{{ request()->date_start ?? Carbon\Carbon::now()->startOfMonth()->toDateString() }}">
                                    </div>
                                </div>
                                <div class="col-md-2 px-1">
                                    <div class="form-group">
                                        <label>Tanggal Akhir</label>
                                        <input type="date" class="form-control" name="date_end" id="date_end" value="{{ request()->date_end ?? Carbon\Carbon::now()->endOfMonth()->toDateString() }}">
                                    </div>
                                </div>
                                <div class="col-md-1 px-0">
                                    <div class="form-group">
                                        <button class="btn btn-primary btn-lg btn-block">Filter</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration" id="stokMasukTbl">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>User</th>
                                        <th>Suplier</th>
                                        <th>Nama</th>
                                        <th>Tanggal</th>
                                        <th>Harga Beli Lama</th>
                                        <th>Harga Beli Baru</th>
                                        <th>Harga Jual Lama</th>
                                        <th>Harga Jual Baru</th>
                                        <th>Stok Lama</th>
                                        <th>Penambahan Stok</th>
                                        <th>Total Stok</th>
                                        <th>Note</th>
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
                    <h5 class="modal-title">Restok</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <form id="addForm" name="addForm" onsubmit="event.preventDefault(); sendAjaxRequest(addForm)"
                action="{{ route('stok.masuk.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="error-bag"></div>
                        <div class="form-group">
                            <label>Suplier</label>
                            <select class="form-control select2 select2-hidden-accessible" style="width: 100%;"  name="suplier_id">
                                <option selected="selected">--Pilih--</option>
                                @foreach ($supliers as $sup)
                                    <option value="{{ $sup->id }}">{{ $sup->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Barang</label>
                            <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" name="barang_id" onchange="loadBarang(this.value)">
                                <option selected="selected">--Pilih--</option>
                                @foreach ($barang as $brg)
                                    <option value="{{ $brg->id }}">{{ $brg->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Harga Beli Sekarang</label>
                                <input type="text" class="form-control" name="harga_beli_lama" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Harga Beli Baru</label>
                                <input type="text" class="form-control" name="harga_beli_baru">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Harga Jual Sekarang</label>
                                <input type="text" class="form-control" name="harga_jual_lama" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Harga Jual Baru</label>
                                <input type="text" class="form-control" name="harga_jual_baru">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Stok Sekarang</label>
                                <input type="text" class="form-control" name="stok_lama" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Penambahan Stok</label>
                                <input type="text" class="form-control" name="stok_baru">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Tanggal Expired</label>
                                <input type="date" class="form-control" name="expired">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Tanggal Restok</label>
                                <input type="date" class="form-control" name="tanggal" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Note</label>
                            <textarea name="note" class="form-control" rows="2"></textarea>
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
                    <h5 class="modal-title">Restok</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <form id="editForm" name="editForm" onsubmit="event.preventDefault(); sendAjaxRequest(editForm)"
                action="{{ route('stok.masuk.update') }}" method="post">
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            user_id = $('#user_id').val();
            suplier_id = $('#suplier_id').val();
            barang_id = $('#barang_id').val();
            date_start = $('#date_start').val();
            date_end = $('#date_end').val();
            // $('#stokMasukTbl').dataTable({
            //     ajax: `{{ route('datatables') }}?type=stok-masuk&user_id=${user_id}&suplier_id=${suplier_id}&barang_id=${barang_id}&date_start=${date_start}&date_end=${date_end}`,
            //     columns: [{
            //             data: 'DT_RowIndex',
            //             name: 'DT_RowIndex'
            //         },
            //         {
            //             data: 'user',
            //             name: 'user'
            //         },
            //         {
            //             data: 'suplier',
            //             name: 'suplier'
            //         },
            //         {
            //             data: 'nama',
            //             name: 'nama'
            //         },
            //         {
            //             data: 'tanggal',
            //             name: 'tanggal'
            //         },
            //         {
            //             data: 'harga_beli_lama',
            //             name: 'harga_beli_lama'
            //         },
            //         {
            //             data: 'harga_beli_baru',
            //             name: 'harga_beli_baru'
            //         },
            //         {
            //             data: 'harga_jual_lama',
            //             name: 'harga_jual_lama'
            //         },
            //         {
            //             data: 'harga_jual_baru',
            //             name: 'harga_jual_baru'
            //         },
            //         {
            //             data: 'stok_lama',
            //             name: 'stok_lama'
            //         },
            //         {
            //             data: 'stok_baru',
            //             name: 'stok_baru'
            //         },
            //         {
            //             data: 'total_stok',
            //             name: 'total_stok'
            //         },
            //         {
            //             data: 'note',
            //             name: 'note'
            //         },
            //         {
            //             data: 'action',
            //             name: 'action',
            //             orderable: false,
            //             searchable: false,
            //             visible: false,
            //         }
            //     ],
            //     order: [
            //         [0, 'desc']
            //     ],
            //     dom: 'Blrftip',
            //     buttons: [
            //         {
            //             extend: 'excelHtml5',
            //             title: 'Stok Masuk',
            //             exportOptions: {
            //                 columns: [0, 1, 2, 3, 4, 9, 10, 11]
            //             }
            //         },
            //         {
            //             extend: 'pdfHtml5',
            //             title: 'Stok Masuk',
            //             exportOptions: {
            //                 columns: [0, 1, 2, 3, 4, 9, 10, 11]
            //             },
            //             customize: function (doc) {
            //                 // Set up the page size
            //                 doc.pageMargins = [20, 20, 20, 20]; // Set the margins
            //                 doc.defaultStyle.fontSize = 8; // Font size
            //                 doc.styles.tableHeader.fontSize = 10; // Font size for table headers
            //                 doc.styles.tableHeader.fillColor = '##7571f9'; // Header background color
            //                 doc.content[1].table.widths = ['*', '*', '*', '*', '*', '*', '*', '*']; // Set column widths
            //             }
            //         },
            //     ],
            // })

            const imageUrl = "{{ asset('assets/images/masjid/logo-text.png') }}" ;
            let imageDataUrl;

            // Fetch the image and convert it to data URL
            fetch(imageUrl)
                .then(response => response.blob())
                .then(blob => {
                    return new Promise((resolve, reject) => {
                        const reader = new FileReader();
                        reader.onloadend = () => resolve(reader.result);
                        reader.onerror = reject;
                        reader.readAsDataURL(blob);
                    });
                })
                .then(dataUrl => {
                    imageDataUrl = dataUrl;

                    $('#stokMasukTbl').dataTable({
                        ajax: `{{ route('datatables') }}?type=stok-masuk&user_id=${user_id}&suplier_id=${suplier_id}&barang_id=${barang_id}&date_start=${date_start}&date_end=${date_end}`,
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex'
                            },
                            {
                                data: 'user',
                                name: 'user'
                            },
                            {
                                data: 'suplier',
                                name: 'suplier'
                            },
                            {
                                data: 'nama',
                                name: 'nama'
                            },
                            {
                                data: 'tanggal',
                                name: 'tanggal'
                            },
                            {
                                data: 'harga_beli_lama',
                                name: 'harga_beli_lama'
                            },
                            {
                                data: 'harga_beli_baru',
                                name: 'harga_beli_baru'
                            },
                            {
                                data: 'harga_jual_lama',
                                name: 'harga_jual_lama'
                            },
                            {
                                data: 'harga_jual_baru',
                                name: 'harga_jual_baru'
                            },
                            {
                                data: 'stok_lama',
                                name: 'stok_lama'
                            },
                            {
                                data: 'stok_baru',
                                name: 'stok_baru'
                            },
                            {
                                data: 'total_stok',
                                name: 'total_stok'
                            },
                            {
                                data: 'note',
                                name: 'note'
                            },
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false,
                                visible: false,
                            }
                        ],
                        order: [
                            [0, 'desc']
                        ],
                        dom: 'Blrftip',
                        buttons: [
                            {
                                extend: 'excelHtml5',
                                title: 'Stok Masuk',
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4, 9, 10, 11]
                                }
                            },
                            {
                                extend: 'pdfHtml5',
                                title: 'Stok Masuk',
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4, 9, 10, 11]
                                },
                                customize: function (doc) {
                                    // Set up the page size and margins
                                    doc.pageMargins = [20, 70, 20, 20];
                                    doc.defaultStyle.fontSize = 8;
                                    doc.styles.tableHeader.fontSize = 10;
                                    doc.styles.tableHeader.fillColor = '##7571f9';
                                    doc.content[1].table.widths = ['*', '*', '*', '*', '*', '*', '*', '*'];

                                    // Add image and text to the header using data URL
                                    doc['header'] = function () {
                                        return {
                                            columns: [
                                                {
                                                    table: {
                                                        widths: ['*'], // Adjust the width of the table cell
                                                        body: [
                                                            [
                                                                {
                                                                    image: imageDataUrl,
                                                                    width: 200,
                                                                    alignment: 'center',
                                                                },
                                                            ],
                                                        ],
                                                    },
                                                    layout: 'noBorders', // Remove borders for a cleaner look
                                                },
                                            ],
                                            margin: [20, 10],
                                        };
                                    };
                                }
                            },
                        ],
                    })
                })
            .catch(error => console.error('Error fetching or converting image:', error));

            $('.select2').select2();
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
                        url: "{{ route('stok.masuk.delete') }}",
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

        function loadBarang(id){
            $.ajax({
                url: `{{ url('api/barang') }}?barang_id=${id}`,
                type: "GET",
                success: (res) => {
                    if (res.success) {
                        barang = res.barang
                        if(barang){
                            $("#addForm input[name=harga_beli_lama]").val(barang.harga_beli);
                            $("#addForm input[name=harga_beli_baru]").val(barang.harga_beli);
                            $("#addForm input[name=harga_jual_lama]").val(barang.harga_jual);
                            $("#addForm input[name=harga_jual_baru]").val(barang.harga_jual);
                            $("#addForm input[name=stok_lama]").val(barang.stok);
                            $("#addForm input[name=stok_baru]").val(0);
                        }
                    } else {
                        Swal.fire({
                            title: 'Oops! Ada yang salah',
                            icon: 'error',
                            text: res.message
                        })
                    }
                },
                error: (err) => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops! Ada yang salah',
                        text: `${err.statusCode} ${err.statusText}`
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

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .select2-hidden-accessible {
            border: 0 !important;
            clip: rect(0 0 0 0) !important;
            height: 1px !important;
            margin: -1px !important;
            overflow: hidden !important;
            padding: 0 !important;
            position: absolute !important;
            width: 1px !important
        }

        .select2-container--default .select2-selection--single,
        .select2-selection .select2-selection--single {
            border: 1px solid #d2d6de;
            border-radius: 0;
            padding: 6px 12px;
            height: 34px
        }

        .select2-container--default .select2-selection--single {
            background-color: #fff;
            border: 1px solid #aaa;
            border-radius: 4px
        }

        .select2-container .select2-selection--single {
            box-sizing: border-box;
            cursor: pointer;
            display: block;
            height: 28px;
            user-select: none;
            -webkit-user-select: none
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            padding-right: 10px
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            padding-left: 0;
            padding-right: 0;
            height: auto;
            margin-top: -3px
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: 28px
        }

        .select2-container--default .select2-selection--single,
        .select2-selection .select2-selection--single {
            border: 1px solid #d2d6de;
            border-radius: 0 !important;
            padding: 6px 12px;
            height: 40px !important
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 26px;
            position: absolute;
            top: 6px !important;
            right: 1px;
            width: 20px
        }
    </style>

@endsection