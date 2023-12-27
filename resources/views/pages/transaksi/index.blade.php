@extends('layouts/app')
@section('content')
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Transaksi</a></li>
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
                            <h4 class="card-title">Transaksi Penjualan</h4>
                        </div>
                        <div class="row">
                            <div class="col-7">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body ">
                                            <div class="form-row align-items-end" id="divBarang">
                                                <div class="form-group col-md-4">
                                                    <label>Barcode</label>
                                                    <input type="text" class="form-control" name="kode" id="barcode">
                                                    <input type="hidden" class="form-control" name="barang_id">
                                                    <div id="barcodeList" class="list-barcode">
                                                        <div class="card mr-4">
                                                            <div class="card-body p-0">
                                                                <div class="list-group p-0"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label>Nama</label>
                                                    <input type="text" class="form-control" name="nama" id="nama">
                                                    <div id="namaList" class="list-barcode">
                                                        <div class="card mr-4">
                                                            <div class="card-body p-0">
                                                                <div class="list-group p-0"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label>Qty</label>
                                                    <input type="number" class="form-control" name="qty">
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <button class="btn btn-primary btn-lg btn-block" onclick="saveToCart()">Add</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <table class="table" id="keranjangTbl">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Kode</th>
                                                        <th>Barang</th>
                                                        <th>Price</th>
                                                        <th>Qty</th>
                                                        <th>Total</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-5">
                                <form id="transaksiForm" name="transaksiForm" action="{{ route('transaksi.store') }}" method="POST" onsubmit="event.preventDefault(); sendAjaxRequest(transaksiForm)">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4>TANGGAL : {{ date('d-m-Y') }}</h4>
                                                    <h4>KASIR : {{ auth()->user()->name }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label>Subtotal</label>
                                                        <input type="text" class="form-control" name="subtotal" autonumeric="true" id="subtotal" readonly>
                                                        <input type="hidden" class="form-control" name="tanggal" value="{{ date('Y-m-d') }}">
                                                        <input type="hidden" class="form-control" name="user_id" value="{{ auth()->user()->id }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Total</label>
                                                        <input type="text" class="form-control" name="total" autonumeric="true" id="total" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label>Cash</label>
                                                        <input type="text" class="form-control" autonumeric="true" name="cash" id="cash" onkeyup="getKembalian()">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Kembalian</label>
                                                        <input type="text" class="form-control" autonumeric="true" name="kembalian" readonly id="kembalian">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label>Note</label>
                                                        <textarea name="note" id="note" class="form-control" rows="2"></textarea>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <button class="btn btn-block btn-danger" type="button" onclick="removeCart({{ auth()->id() }})">BATAL</button>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <button class="btn btn-block btn-primary">SIMPAN</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>

        user_id = "{{ auth()->user()->id }}"

        $(document).ready(function() {
            $('#restokTbl').dataTable({
                ajax: "{{ route('datatables') }}?type=restok",
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

            $('.select2').select2();

            loadCart(user_id)
        });

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
                            $("#addForm input[name=stok_baru]").val(barang.stok);
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
                        if(`#${formId}` == '#transaksiForm'){
                            loadCart(user_id)
                            window.open(`{{ route('transaksi.print') }}?id=` + res.transaksi_id, '_blank');
                        }
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

        $('#barcode').focus(function() {
            $('#barcodeList').fadeIn();
        })

        $('#barcode').blur(function() {
            $("#barcodeList").fadeOut();
        })
        
        $('#barcode').keyup(function(evt) {
            if (evt.target.value.length >= 2) {
                console.log('aa');
                // resetCustomer();
                $('#barcodeList .card .card-body .list-group').html(`
                    <div class="md-progress primary-color-dark">
                        <div class="indeterminate"></div>
                    </div>
                `)
                if(evt.target.value !== null) {
                    $.ajax({
                        type: "GET",
                        url: "/api/barang?kode="+evt.target.value,
                        success: function(res) {
                            if(res.success === true) {
                                console.log(res);
                                $('#barcodeList .card .card-body .list-group').html(``)
                                res.barang.forEach(function(item, idx) {
                                    brg = {
                                        id: item.id,
                                        kode: item.kode,
                                        nama: item.nama,                                    }
                                    $('#barcodeList .card .card-body .list-group').append(`
                                        <span class="select-none cursor-pointer list-group-item list-group-item-action" onclick='fillBarang(${JSON.stringify(brg)}, "#divBarang")'><b>${item.kode}</b> ${item.nama}</span>
                                    `)
                                })
                            }
                        }
                    })
                }
            }
        })

        $('#nama').focus(function() {
            $('#namaList').fadeIn();
        })

        $('#nama').blur(function() {
            $("#namaList").fadeOut();
        })

        $('#nama').keyup(function(evt) {
            if (evt.target.value.length >= 2) {
                console.log('aa');
                // resetBarang();
                $('#namaList .card .card-body .list-group').html(`
                    <div class="md-progress primary-color-dark">
                        <div class="indeterminate"></div>
                    </div>
                `)
                if(evt.target.value !== null) {
                    $.ajax({
                        type: "GET",
                        url: "/api/barang?nama="+evt.target.value,
                        success: function(res) {
                            if(res.success === true) {
                                console.log(res);
                                $('#namaList .card .card-body .list-group').html(``)
                                res.barang.forEach(function(item, idx) {
                                    brg = {
                                        id: item.id,
                                        kode: item.kode,
                                        nama: item.nama,                                    }
                                    $('#namaList .card .card-body .list-group').append(`
                                        <span class="select-none cursor-pointer list-group-item list-group-item-action" onclick='fillBarang(${JSON.stringify(brg)}, "#divBarang")'><b>${item.kode}</b> ${item.nama}</span>
                                    `)
                                })
                            }
                        }
                    })
                }
            }
        })

        function fillBarang(brg, element = '#divBarang') {
            $(element+' input[name="barang_id"]').val(brg.id)
            $(element+' input[name="kode"]').val(brg.kode)
            $(element+' input[name="nama"]').val(brg.nama)
            $(element+' input[name="qty"]').val(1)
        }

        function resetBarang(element = '#divBarang') {
            $(element+' input[name="barang_id"]').val('')
            $(element+' input[name="kode"]').val('')
            $(element+' input[name="nama"]').val('')
            $(element+' input[name="qty"]').val('')
        }

        function saveToCart(){
            barang_id =  $('#divBarang input[name="barang_id"]').val()
            qty = $('#divBarang input[name="qty"]').val()

            $.ajax({
                url: `{{ route('transaksi.store-cart') }}`,
                type: "POST",
                data: {
                    barang_id: barang_id,
                    qty: qty,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: (res) => {
                    if (res.success) {
                        loadCart(user_id)
                    } else {
                        Swal.fire({
                            title: 'Oops! Ada yang salah',
                            icon: 'error',
                            text: res.message
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

        function deleteCart(id){
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
                        url: "{{ route('transaksi.delete-cart') }}",
                        data: {
                            _token: "{{csrf_token()}}",
                            _method: 'DELETE',
                            id: id,
                        },
                        type: 'POST',
                        success: (res) => {
                            if (res.success) {
                                Swal.fire({
                                    title: 'Success!',
                                    icon: 'success',
                                    text: res.message,
                                })
                                loadCart(user_id)
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

        function removeCart(id){
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
                        url: "{{ route('transaksi.remove-cart') }}",
                        data: {
                            _token: "{{csrf_token()}}",
                            _method: 'DELETE',
                            id: id,
                        },
                        type: 'POST',
                        success: (res) => {
                            if (res.success) {
                                Swal.fire({
                                    title: 'Success!',
                                    icon: 'success',
                                    text: res.message,
                                })
                                loadCart(user_id)
                                $('#transaksiForm').trigger('reset')
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

        function loadCart(user_id){
            $.ajax({
                url: `{{ url('api/keranjang') }}?user_id=${user_id}`,
                type: "GET",
                success: (res) => {
                    if (res.success) {
                        $('#keranjangTbl tbody').html(``)
                        keranjang = ''
                        subtotal = 0
                        res.keranjang.forEach((item, i) => {
                            subtotal += parseInt(item.harga_jual * item.qty)
                            keranjang += `
                                <tr>
                                    <td>${i+1}</td>
                                    <td>${item.kode}</td>
                                    <td>${item.nama}</td>
                                    <td>${toRupiah(item.harga_jual)}</td>
                                    <td>${item.qty}</td>
                                    <td>${toRupiah(item.harga_jual * item.qty)}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-danger btn-sm" data-tooltip="true" title="Delete" onclick="deleteCart(${item.id})">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            `
                        })
                        $('#keranjangTbl tbody').append(`${keranjang}`)
                        AutoNumeric.getAutoNumericElement('#subtotal').set(subtotal);
                        AutoNumeric.getAutoNumericElement('#total').set(subtotal);

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

        function getKembalian(){
            cash = AutoNumeric.getAutoNumericElement(`#cash`).rawValue
            total = AutoNumeric.getAutoNumericElement(`#total`).rawValue
            kembalian = parseInt(cash - total);
            console.log(kembalian);
            AutoNumeric.getAutoNumericElement('#kembalian').set(kembalian);
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

        .list-barcode {
            display: none;
            position: absolute;
            width: 100%;
            background-color: white;
            border: 1px rgb(105, 105, 105);
            z-index: 10000;
            top: 70px;
            max-height: 300px;
            overflow-y: auto;
        }
    </style>

@endsection