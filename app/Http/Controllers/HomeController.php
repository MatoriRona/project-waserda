<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{ 
    public function index(Request $request)
    {
        if(auth()->user()->role == 'kasir'){
            return $this->homeAdmin($request);
        }
        $date_start = request()->date_start ? request()->date_start : Carbon::now()->startOfMonth()->toDateString();
        $date_end = request()->date_end ? request()->date_end : Carbon::now()->endOfMonth()->toDateString();

        $date_start = Carbon::parse($date_start)->format('Y-m-d 00:00:00');
        $date_end = Carbon::parse($date_end)->format('Y-m-d 23:59:59');

        $barang = Barang::get()->count();
        $transaksi = Transaksi::whereBetween('tanggal', [$date_start, $date_end])->count();
        $pendapatan_hari_ini = Transaksi::where('tanggal', date('Y-m-d'))->get()->sum('keuntungan');
        $pendapatan_total = Transaksi::whereBetween('tanggal', [$date_start, $date_end])->get()->sum('keuntungan');

        $barang_terlaris =  DB::table('transaksi_details')
                ->selectRaw('
                    barang_id,
                    (select nama from barangs where barangs.id = transaksi_details.barang_id) as nama,
                    SUM(qty) as total_terjual
                ')
                ->groupBy('barang_id')
                ->whereBetween('transaksi_details.created_at', [$date_start, $date_end])
                ->orderBy('total_terjual', 'DESC')
                ->limit(10)
                ->get();

        $barang_menipis =  DB::table('barangs')
                ->selectRaw('
                    id,
                    nama,
                    stok
                ')
                ->where('stok', '<=', '10')
                ->orderBy('stok', 'ASC')
                ->get();

        $barang_expired = DB::table('barangs')
            ->selectRaw('
                id,
                nama,
                expired,
                stok,
                DATEDIFF(expired, CURDATE()) as hari_expired
            ')
            ->where('is_active', true)
            ->whereRaw('DATEDIFF(expired, CURDATE()) <= 60') // 60 hari = 2 bulan
            ->get();

        // Menyiapkan rentang tanggal 30 hari terakhir
        $dateEnd = now()->endOfDay();
        $dateStart = now()->subDays(29)->startOfDay();

        // Mendapatkan daftar tanggal 30 hari terakhir
        $dateRange = [];
        $currentDate = clone $dateStart;

        while ($currentDate->lte($dateEnd)) {
            $dateRange[] = $currentDate->copy();
            $currentDate->addDay();
        }

        // Menggabungkan transaksi_details dengan tanggal pada rentang waktu
        $grafikBulanIni = DB::table('transaksi_details')
            ->rightJoin('transaksis', 'transaksi_details.transaksi_id', '=', 'transaksis.id')
            ->selectRaw('transaksis.tanggal, COALESCE(SUM((transaksi_details.harga_jual - transaksi_details.harga_beli) * transaksi_details.qty), 0) as total_keuntungan')
            ->whereBetween('transaksis.tanggal', [$dateStart, $dateEnd])
            ->groupBy('transaksis.tanggal')
            ->get();

        // Membuat array untuk menyimpan data final
        $grafik_bulan_ini = [];

        // Mengisi data final dengan nilai keuntungan 0 untuk tanggal yang tidak memiliki transaksi
        foreach ($dateRange as $date) {
            $formattedDate = $date->format('Y-m-d');
            $result = $grafikBulanIni->where('tanggal', $formattedDate)->first();

            $grafik_bulan_ini[] = [
                'tanggal' => $formattedDate,
                'total_keuntungan' => $result ? $result->total_keuntungan : 0,
            ];
        }


        return view('index', [
            'title' => 'Login Page',
            'barang' => $barang,
            'transaksi' => $transaksi,
            'pendapatan_hari_ini' => $pendapatan_hari_ini,
            'pendapatan_total' => $pendapatan_total,
            'barang_terlaris' => $barang_terlaris,
            'barang_menipis' => $barang_menipis,
            'barang_expired' => $barang_expired,
            'grafik_bulan_ini' => $grafik_bulan_ini,
        ]);
    }

    public function homeAdmin(Request $request){
        $date_start = request()->date_start ? request()->date_start : Carbon::now()->startOfMonth()->toDateString();
        $date_end = request()->date_end ? request()->date_end : Carbon::now()->endOfMonth()->toDateString();

        $date_start = Carbon::parse($date_start)->format('Y-m-d 00:00:00');
        $date_end = Carbon::parse($date_end)->format('Y-m-d 23:59:59');

        $barang = Barang::get()->count();
        $transaksi = Transaksi::whereBetween('tanggal', [$date_start, $date_end])->where('user_id', auth()->user()->id)->count();
        $pendapatan_hari_ini = Transaksi::where('tanggal', date('Y-m-d'))->where('user_id', auth()->user()->id)->get()->sum('keuntungan');
        
        $barang_terlaris =  DB::table('transaksi_details')
                ->selectRaw('
                    barang_id,
                    (select nama from barangs where barangs.id = transaksi_details.barang_id) as nama,
                    SUM(qty) as total_terjual
                ')
                ->groupBy('barang_id')
                ->whereBetween('transaksi_details.created_at', [$date_start, $date_end])
                ->orderBy('total_terjual', 'DESC')
                ->limit(10)
                ->get();

        $barang_menipis =  DB::table('barangs')
                ->selectRaw('
                    id,
                    nama,
                    stok
                ')
                ->where('stok', '<=', '10')
                ->orderBy('stok', 'ASC')
                ->get();
        
        $barang_expired = DB::table('barangs')
            ->selectRaw('
                id,
                nama,
                expired,
                stok,
                DATEDIFF(expired, CURDATE()) as hari_expired
            ')
            ->where('is_active', true)
            ->whereRaw('DATEDIFF(expired, CURDATE()) <= 60') // 60 hari = 2 bulan
            ->get();

        // Menyiapkan rentang tanggal 30 hari terakhir
        $dateEnd = now()->endOfDay();
        $dateStart = now()->subDays(29)->startOfDay();

        // Mendapatkan daftar tanggal 30 hari terakhir
        $dateRange = [];
        $currentDate = clone $dateStart;

        while ($currentDate->lte($dateEnd)) {
            $dateRange[] = $currentDate->copy();
            $currentDate->addDay();
        }

        // Menggabungkan transaksi_details dengan tanggal pada rentang waktu
        $grafikBulanIni = DB::table('transaksi_details')
            ->rightJoin('transaksis', 'transaksi_details.transaksi_id', '=', 'transaksis.id')
            ->selectRaw('transaksis.tanggal, COUNT(transaksis.id) as total_transaksi')
            ->whereBetween('transaksis.tanggal', [$dateStart, $dateEnd])
            ->where('transaksis.user_id', auth()->user()->id)
            ->groupBy('transaksis.tanggal')
            ->get();

        // Membuat array untuk menyimpan data final
        $grafik_bulan_ini = [];

        // Mengisi data final dengan nilai transaksi 0 untuk tanggal yang tidak memiliki transaksi
        foreach ($dateRange as $date) {
            $formattedDate = $date->format('Y-m-d');
            $result = $grafikBulanIni->where('tanggal', $formattedDate)->first();

            $grafik_bulan_ini[] = [
                'tanggal' => $formattedDate,
                'total_transaksi' => $result ? $result->total_transaksi : 0,
            ];
        }


        return view('home-admin', [
            'title' => 'Login Page',
            'barang' => $barang,
            'transaksi' => $transaksi,
            'pendapatan_hari_ini' => $pendapatan_hari_ini,
            'barang_terlaris' => $barang_terlaris,
            'barang_menipis' => $barang_menipis,
            'barang_expired' => $barang_expired,
            'grafik_bulan_ini' => $grafik_bulan_ini,
        ]);
    }
}
