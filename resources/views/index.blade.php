@extends('layouts/app')
@section('content')
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Home</a></li>
            </ol>
        </div>
    </div>
    <div class="mx-4" id="message" style="display: none;">
        <div class="alert alert-primary" role="alert">
            {{ session()->get('message') }}
        </div>
    </div>
    <!-- row -->

    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('dashboard') }}" method="get">
                            <div class="row align-items-end">
                                <div class="col-md-2 px-1">
                                    <div class="form-group">
                                        <label>Kasir</label>
                                        <select class="form-control" name="user_id" id="user_id">
                                            <option value="0">--All--</option>
                                            {{-- @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach --}}
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
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="card gradient-1">
                    <div class="card-body">
                        <h3 class="card-title text-white">Data Barang</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white">{{ $barang }}</h2>
                            <p class="text-white mb-0"></p>
                        </div>
                        <span class="float-right display-5 opacity-5"><i class="fa fa-shopping-cart"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card gradient-2">
                    <div class="card-body">
                        <h3 class="card-title text-white">Data Transaksi</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white">{{ $transaksi }}</h2>
                            <p class="text-white mb-0"></p>
                        </div>
                        <span class="float-right display-5 opacity-5"><i class="fa fa-money"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card gradient-3">
                    <div class="card-body">
                        <h3 class="card-title text-white">Pendapatan Hari Ini</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white">Rp. {{ number_format($pendapatan_hari_ini) }}</h2>
                            <p class="text-white mb-0"></p>
                        </div>
                        <span class="float-right display-5 opacity-5"><i class="fa fa-users"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card gradient-4">
                    <div class="card-body">
                        <h3 class="card-title text-white">Total Pendapatan</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white">Rp. {{ number_format($pendapatan_total) }}</h2>
                            <p class="text-white mb-0"></p>
                        </div>
                        <span class="float-right display-5 opacity-5"><i class="fa fa-heart"></i></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Grafik Pendapatan 30 Hari Terakhir</h4>
                        <canvas id="grafik-bulan-ini" width="500" height="250"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <h5>Barang Terlaris</h5>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration" id="terlarisTbl">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Total Terjual</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($barang_terlaris as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->nama }}</td>
                                            <td>{{ $item->total_terjual }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <h5>Barang Menipis</h5>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration" id="menipisTbl">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($barang_menipis as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->nama }}</td>
                                            <td>{{ $item->stok }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <h5>Barang Expired</h5>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration" id="expiredTbl">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Stok</th>
                                        <th>Tanggal</th>
                                        <th>Hari</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($barang_expired as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->nama }}</td>
                                            <td>{{ $item->stok }}</td>
                                            <td>{{ Carbon\Carbon::parse($item->expired)->format('d F, Y') }}</td>
                                            <td>{{ $item->hari_expired }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('js')
    <script src="{{ asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/plugins-init/chartjs-init.js') }}"></script> --}}
    <script>
        
        $(document).ready(function() {
            $('#terlarisTbl').dataTable()
            $('#menipisTbl').dataTable()
            $('#expiredTbl').dataTable()
        
            loadGafikPendapatan()

        });

        function loadGafikPendapatan() {
            var jsonString = `{!! htmlspecialchars_decode(json_encode($grafik_bulan_ini)) !!}`
            var data = JSON.parse(jsonString);

            var tanggal = data.map(item => item.tanggal);
            var keuntungan = data.map(item => item.total_keuntungan);

            var ctx = document.getElementById("grafik-bulan-ini");
            ctx.height = 150;
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: tanggal,
                    type: 'line',
                    defaultFontFamily: 'Montserrat',
                    datasets: [{
                        data: keuntungan,
                        label: "Keuntungan",
                        backgroundColor: '#006a4e',
                        borderColor: '#006a4e',
                        borderWidth: 0.5,
                        pointStyle: 'circle',
                        pointRadius: 5,
                        pointBorderColor: 'transparent',
                        pointBackgroundColor: '#006a4e',
                    },]
                },
                options: {
                    responsive: true,
                    tooltips: {
                        mode: 'index',
                        titleFontSize: 12,
                        titleFontColor: '#000',
                        bodyFontColor: '#000',
                        backgroundColor: '#fff',
                        titleFontFamily: 'Montserrat',
                        bodyFontFamily: 'Montserrat',
                        cornerRadius: 3,
                        intersect: false,
                    },
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            fontFamily: 'Montserrat',
                        },
                    },
                    scales: {
                        xAxes: [{
                            display: true,
                            gridLines: {
                                display: false,
                                drawBorder: false
                            },
                            scaleLabel: {
                                display: false,
                                labelString: 'Tanggal'
                            }
                        }],
                        yAxes: [{
                            display: true,
                            gridLines: {
                                display: false,
                                drawBorder: false
                            },
                            scaleLabel: {
                                display: true,
                                labelString: 'Keuntungan'
                            }
                        }]
                    },
                    title: {
                        display: false,
                    }
                }
            });
        }
    </script>
@endsection