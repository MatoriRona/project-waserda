@extends('layouts/app')
@section('content')
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Data Transaksi</a></li>
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
                            <h4 class="card-title">Data Transaksi</h4>
                            <div class="btn-group">
                                {{-- <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal"><i class="fa fa-plus"></i> Add</button> --}}
                            </div>
                        </div>

                        <form action="{{ route('transaksi.view') }}" method="get" class="m-4">
                            <div class="row align-items-end mx-2">
                                <div class="col-md-2 px-1">
                                    <div class="form-group">
                                        <label>Kasir</label>
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
                            <table class="table table-striped table-bordered zero-configuration" id="transaksiTbl">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nota</th>
                                        <th>Tanggal</th>
                                        <th>Kasir</th>
                                        <th>Total</th>
                                        <th>Cash</th>
                                        <th>Kembalian</th>
                                        <th>Keuntungan</th>
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
                    <h5 class="modal-title">Barang</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <form  onsubmit="event.preventDefault(); sendAjaxRequest(addForm)"
                action="{{ route('barang.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="error-bag"></div>
                        <div class="form-group">
                            <label>Jenis Barang</label>
                        </div>
                        <div class="form-group">
                            <label>Kode</label>
                            <input type="text" class="form-control" name="kode">
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" name="nama">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Satuan</label>
                                <input type="text" class="form-control" name="satuan">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Tanggal Expired</label>
                                <input type="date" class="form-control" name="expired">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Harga Beli</label>
                                <input type="text" class="form-control" name="harga_beli">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Harga Jual</label>
                                <input type="text" class="form-control" name="harga_jual">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Stok</label>
                                <input type="number" class="form-control" name="stok">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Status</label>
                                <select class="form-control" name="is_active">
                                    <option selected="selected">--Pilih--</option>
                                    <option value="1">Aktif</option>
                                    <option value="0">Nonaktif</option>
                                </select>
                            </div>
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

    <div class="modal fade bd-example-modal-xl" id="editModal">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Barang</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <form id="editForm" name="editForm" onsubmit="event.preventDefault(); sendAjaxRequest(editForm)"
                action="{{ route('barang.update') }}" method="post">
                    @csrf
                    <input type="hidden" name="barang_id">
                    <div class="modal-body">
                        <div class="error-bag"></div>
                        <div class="form-group">
                            <label>Jenis Barang</label>
                        </div>
                        <div class="form-group">
                            <label>Kode</label>
                            <input type="text" class="form-control" name="kode">
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" name="nama">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Satuan</label>
                                <input type="text" class="form-control" name="satuan">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Tanggal Expired</label>
                                <input type="date" class="form-control" name="expired">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Harga Beli</label>
                                <input type="text" class="form-control" name="harga_beli">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Harga Jual</label>
                                <input type="text" class="form-control" name="harga_jual">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Stok</label>
                                <input type="number" class="form-control" name="stok">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Status</label>
                                <select class="form-control" name="is_active">
                                    <option selected="selected">--Pilih--</option>
                                    <option value="1">Aktif</option>
                                    <option value="0">Nonaktif</option>
                                </select>
                            </div>
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

    <div class="modal fade" id="detailModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Transaksi Detail</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="detailDiv">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function() {
            user_id = $('#user_id').val();
            date_start = $('#date_start').val();
            date_end = $('#date_end').val();
            // $('#transaksiTbl').dataTable({
            //     ajax: `{{ route('datatables') }}?type=transaksi&user_id=${user_id}&date_start=${date_start}&date_end=${date_end}`,
            //     columns: [{
            //             data: 'DT_RowIndex',
            //             name: 'DT_RowIndex'
            //         },
            //         {
            //             data: 'nota',
            //             name: 'nota'
            //         },
            //         {
            //             data: 'tanggal',
            //             name: 'tanggal'
            //         },
            //         {
            //             data: 'kasir',
            //             name: 'kasir'
            //         },
            //         {
            //             data: 'total',
            //             name: 'total'
            //         },
            //         {
            //             data: 'cash',
            //             name: 'cash'
            //         },
            //         {
            //             data: 'kembalian',
            //             name: 'kembalian'
            //         },
            //         {
            //             data: 'keuntungan',
            //             name: 'keuntungan'
            //         },
            //         {
            //             data: 'note',
            //             name: 'note'
            //         },
            //         {
            //             data: 'action',
            //             name: 'action',
            //             orderable: false,
            //             searchable: false
            //         }
            //     ],
            //     order: [
            //         [0, 'desc']
            //     ],
            //     dom: 'Blrftip',
            //     buttons: [
            //         {
            //             extend: 'excelHtml5',
            //             title: 'Transaksi',
            //             exportOptions: {
            //                 columns: [0, 1, 2, 3, 4, 5, 6, 7]
            //             }
            //         },
            //         {
            //             extend: 'pdfHtml5',
            //             title: 'Transaksi',
            //             exportOptions: {
            //                 columns: [0, 1, 2, 3, 4, 5, 6, 7]
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

                    $('#transaksiTbl').dataTable({
                        ajax: `{{ route('datatables') }}?type=transaksi&user_id=${user_id}&date_start=${date_start}&date_end=${date_end}`,
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex'
                            },
                            {
                                data: 'nota',
                                name: 'nota'
                            },
                            {
                                data: 'tanggal',
                                name: 'tanggal'
                            },
                            {
                                data: 'kasir',
                                name: 'kasir'
                            },
                            {
                                data: 'total',
                                name: 'total'
                            },
                            {
                                data: 'cash',
                                name: 'cash'
                            },
                            {
                                data: 'kembalian',
                                name: 'kembalian'
                            },
                            {
                                data: 'keuntungan',
                                name: 'keuntungan'
                            },
                            {
                                data: 'note',
                                name: 'note'
                            },
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false
                            }
                        ],
                        order: [
                            [0, 'desc']
                        ],
                        dom: 'Blrftip',
                        buttons: [
                            {
                                extend: 'excelHtml5',
                                title: 'Transaksi',
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4, 5, 6, 7]
                                }
                            },
                            {
                                extend: 'pdfHtml5',
                                title: 'Transaksi',
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4, 5, 6, 7]
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

        });

        function editData(data){
            $("#editForm input[name=barang_id]").val(data.id);
            $("#editForm select[name=jenis_barang_id]").val(data.jenis_barang_id).change();
            $("#editForm input[name=kode]").val(data.kode);
            $("#editForm input[name=nama]").val(data.nama);
            $("#editForm input[name=satuan]").val(data.satuan);
            $("#editForm input[name=harga_beli]").val(data.harga_beli);
            $("#editForm input[name=harga_jual]").val(data.harga_jual);
            $("#editForm input[name=stok]").val(data.stok);
            $("#editForm input[name=expired]").val(data.expired);
            $("#editForm select[name=is_active]").val(data.is_active).change();

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
                        url: "{{ route('barang.delete') }}",
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

        function detailData(id){
            $.ajax({
                url: `{{ url('api/transaksi') }}?id=${id}`,
                type: "GET",
                success: (res) => {
                    if (res.success) {
                        transaksi = res.transaksi
                        transaksi_detail = res.transaksi_detail
                        
                        
                        transaksiSection = `
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="basic-list-group">
                                        <ul class="list-group">
                                            <li class="list-group-item">NOTA: ${transaksi.nota}</li>
                                            <li class="list-group-item">TANGGAL: ${transaksi.tanggal}</li>
                                        </ul>
                                    </div>
                                </div>    
                                <div class="col-md-6">
                                    <div class="basic-list-group">
                                        <ul class="list-group">
                                            <li class="list-group-item">KASIR: ${transaksi.kasir}</li>
                                            <li class="list-group-item">TOTAL: ${transaksi.total}</li>
                                        </ul>
                                    </div>
                                </div>    
                            </div>
                        `;

                        tableDetail = ``;
                        transaksi_detail.forEach((item, i) => {
                            tableDetail += `
                                <tr>
                                    <td>${i+1}</td>
                                    <td>${item.kode}</td>
                                    <td>${item.nama}</td>
                                    <td>${item.satuan}</td>
                                    <td>${item.qty}</td>
                                    <td>${toRupiah(item.harga_beli)}</td>
                                    <td>${toRupiah(item.harga_jual)}</td>
                                    <td>${toRupiah(item.harga_jual * item.qty)}</td>
                                </tr>
                            `
                        });

                        detailSection = `
                            <div class="mt-4">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration" id="transaksiDetailTbl">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode</th>
                                                <th>Nama</th>
                                                <th>Satuan</th>
                                                <th>Qty</th>
                                                <th>Harga Beli</th>
                                                <th>Harga Jual</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ${tableDetail}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        `;

                        $('#detailDiv').html('')
                        $('#detailDiv').append(`
                            ${transaksiSection}
                            ${detailSection}
                        `)

                        // $('#transaksiDetailTbl').dataTable({
                        //     dom: 'Blrftip',
                        //     buttons: [
                        //         {
                        //             extend: 'excelHtml5',
                        //             exportOptions: {
                        //                 columns: [0, 1, 2, 3, 4, 5, 6, 7]
                        //             }
                        //         },
                        //         {
                        //             extend: 'pdfHtml5',
                        //             exportOptions: {
                        //                 columns: [0, 1, 2, 3, 4, 5, 6, 7]
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

                        $('#detailModal').modal('show')
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

        function printData(id){
            window.open(`{{ route('transaksi.print') }}?id=` + id, '_blank');
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