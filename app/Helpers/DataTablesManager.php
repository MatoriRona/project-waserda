<?php

namespace App\Helpers;

use App\Models\Barang;
use App\Models\JenisBarang;
use App\Models\Restok;
use App\Models\StokOut;
use App\Models\Suplier;
use App\Models\Transaksi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DataTablesManager{

    public function users(Request $request)
    {
        $users = User::all();

        return datatables()->of($users)
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->addColumn('name', function ($user) {
                return $user->name;
            })
            ->addColumn('nohp', function ($user) {
                return $user->nohp;
            })
            ->addColumn('email', function ($user) {
                return $user->email;
            })
            ->addColumn('role', function ($user) {
                return $user->role;
            })
            ->addColumn('action', function ($user) {
                $json = "{
                    id: '$user->id',
                    name: '$user->name',
                    nohp: '$user->nohp',
                    email: '$user->email',
                    role: '$user->role',
                }";
                $btnEdit = "<button class=\"btn btn-warning btn-sm\" data-tooltip=\"true\" title=\"Edit\" onclick=\"editData($json)\"><i class=\"fa fa-edit\"></i></button>";
                $btnDelete = "<button class=\"btn btn-danger btn-sm\" data-tooltip=\"true\" title=\"Delete\" onclick=\"deleteData($user->id)\"><i class=\"fa fa-trash\"></i></button>";
                return "<div class=\"btn-group\">$btnEdit $btnDelete</div>";
            })
            ->toJson();
    }

    public function jenisBarang(Request $request)
    {
        $jenisBarang = JenisBarang::all();

        return datatables()->of($jenisBarang)
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->addColumn('nama', function ($jns) {
                return $jns->nama;
            })
            ->addColumn('action', function ($jns) {
                $json = "{
                    id: '$jns->id',
                    nama: '$jns->nama',
                }";
                $btnEdit = "<button class=\"btn btn-warning btn-sm\" data-tooltip=\"true\" title=\"Edit\" onclick=\"editData($json)\"><i class=\"fa fa-edit\"></i></button>";
                $btnDelete = "<button class=\"btn btn-danger btn-sm\" data-tooltip=\"true\" title=\"Delete\" onclick=\"deleteData($jns->id)\"><i class=\"fa fa-trash\"></i></button>";
                return "<div class=\"btn-group\">$btnEdit $btnDelete</div>";
            })
            ->toJson();
    }

    public function barang(Request $request)
    {
        $barang = Barang::selectRaw("
                barangs.*,
                jenis_barangs.nama as jenis_barang
            ")
            ->join('jenis_barangs', 'barangs.jenis_barang_id', 'jenis_barangs.id');

        if($request->jenis_barang != 0){
            $barang->where('barangs.jenis_barang_id', $request->jenis_barang);
        }

        if($request->date_expired != 0){
            $ds = now();
            $date_start = $ds->format('Y-m-d');
            $dst = $ds->addMonths($request->date_expired)->endOfMonth();
            $date_end = $dst->format('Y-m-d');
            $barang->whereBetween('barangs.expired', [$date_start, $date_end]);
        }

        return datatables()->of($barang)
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->addColumn('jenis_barang', function ($brg) {
                return $brg->jenis_barang;
            })
            ->addColumn('kode', function ($brg) {
                return $brg->kode;
            })
            ->addColumn('nama', function ($brg) {
                return $brg->nama;
            })
            ->addColumn('satuan', function ($brg) {
                return $brg->satuan;
            })
            ->addColumn('harga_beli', function ($brg) {
                return number_format($brg->harga_beli);
            })
            ->addColumn('harga_jual', function ($brg) {
                return number_format($brg->harga_jual);
            })
            ->addColumn('stok', function ($brg) {
                return number_format($brg->stok);
            })
            ->addColumn('expired', function ($brg) {
                return Carbon::parse($brg->expired)->format('d F, Y');
            })
            ->addColumn('is_active', function ($brg) {
                return $brg->is_active ? "Aktif" : "Nonaktif";
            })
            ->addColumn('action', function ($brg) {
                $json = "{
                    id: '$brg->id',
                    jenis_barang_id: '$brg->jenis_barang_id',
                    kode: '$brg->kode',
                    nama: '$brg->nama',
                    satuan: '$brg->satuan',
                    harga_beli: '$brg->harga_beli',
                    harga_jual: '$brg->harga_jual',
                    stok: '$brg->stok',
                    expired: '$brg->expired',
                    is_active: '$brg->is_active',
                }";
                $btnEdit = "<button class=\"btn btn-warning btn-sm\" data-tooltip=\"true\" title=\"Edit\" onclick=\"editData($json)\"><i class=\"fa fa-edit\"></i></button>";
                $btnDelete = "<button class=\"btn btn-danger btn-sm\" data-tooltip=\"true\" title=\"Delete\" onclick=\"deleteData($brg->id)\"><i class=\"fa fa-trash\"></i></button>";
                return "<div class=\"btn-group\">$btnEdit $btnDelete</div>";
            })
            ->toJson();
    }

    public function suplier(Request $request)
    {
        $supliers = Suplier::all();

        return datatables()->of($supliers)
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->addColumn('nama', function ($sup) {
                return $sup->nama;
            })
            ->addColumn('nohp', function ($sup) {
                return $sup->nohp;
            })
            ->addColumn('alamat', function ($sup) {
                return $sup->alamat;
            })
            ->addColumn('action', function ($sup) {
                $json = "{
                    id: '$sup->id',
                    nama: '$sup->nama',
                    nohp: '$sup->nohp',
                    alamat: '$sup->alamat',
                }";
                $btnEdit = "<button class=\"btn btn-warning btn-sm\" data-tooltip=\"true\" title=\"Edit\" onclick=\"editData($json)\"><i class=\"fa fa-edit\"></i></button>";
                $btnDelete = "<button class=\"btn btn-danger btn-sm\" data-tooltip=\"true\" title=\"Delete\" onclick=\"deleteData($sup->id)\"><i class=\"fa fa-trash\"></i></button>";
                return "<div class=\"btn-group\">$btnEdit $btnDelete</div>";
            })
            ->toJson();
    }

    public function stokMasuk(Request $request)
    {
        $restoks =  Restok::selectRaw("
                restoks.*,
                (select name from users where users.id = restoks.user_id) as user,
                (select nama from supliers where supliers.id = restoks.suplier_id) as suplier,
                (select nama from barangs where barangs.id = restoks.barang_id) as nama
            ")
            ->whereBetween('restoks.tanggal', [$request->date_start, $request->date_end]);

        if($request->user_id != 0){
            $restoks->where('user_id', $request->user_id);
        }
        if($request->suplier_id != 0){
            $restoks->where('suplier_id', $request->suplier_id);
        }
        if($request->barang_id != 0){
            $restoks->where('barang_id', $request->barang_id);
        }

        return datatables()->of($restoks)
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->addColumn('user', function ($restok) {
                return $restok->user;
            })
            ->addColumn('suplier', function ($restok) {
                return $restok->suplier;
            })
            ->addColumn('nama', function ($restok) {
                return $restok->nama;
            })
            ->addColumn('tanggal', function ($restok) {
                return Carbon::parse($restok->tanggal)->format('d F, Y');
            })
            ->addColumn('harga_beli_lama', function ($restok) {
                return number_format($restok->harga_beli_lama);
            })
            ->addColumn('harga_beli_baru', function ($restok) {
                return number_format($restok->harga_beli_baru);
            })
            ->addColumn('harga_jual_lama', function ($restok) {
                return number_format($restok->harga_jual_lama);
            })
            ->addColumn('harga_jual_baru', function ($restok) {
                return number_format($restok->harga_jual_baru);
            })
            ->addColumn('stok_lama', function ($restok) {
                return number_format($restok->stok_lama);
            })
            ->addColumn('stok_baru', function ($restok) {
                return number_format($restok->stok_baru);
            })
            ->addColumn('total_stok', function ($restok) {
                return number_format($restok->stok_lama + $restok->stok_baru);
            })
            ->addColumn('note', function ($restok) {
                return $restok->note;
            })
            ->addColumn('action', function ($restok) {
                $json = "{
                    id: '$restok->id',
                    nama: '$restok->nama',
                }";
                $btnEdit = "<button class=\"btn btn-warning btn-sm\" data-tooltip=\"true\" title=\"Edit\" onclick=\"editData($json)\"><i class=\"fa fa-edit\"></i></button>";
                $btnDelete = "<button class=\"btn btn-danger btn-sm\" data-tooltip=\"true\" title=\"Delete\" onclick=\"deleteData($restok->id)\"><i class=\"fa fa-trash\"></i></button>";
                return "<div class=\"btn-group\">$btnEdit $btnDelete</div>";
            })
            ->toJson();
    }

    public function stokKeluar(Request $request)
    {
        $stokOuts =  StokOut::selectRaw("
                stok_outs.*,
                (select name from users where users.id = stok_outs.user_id) as user,
                (select nama from barangs where barangs.id = stok_outs.barang_id) as nama
            ")->whereBetween('stok_outs.tanggal', [$request->date_start, $request->date_end]);

        if($request->user_id != 0){
            $stokOuts->where('user_id', $request->user_id);
        }
        if($request->barang_id != 0){
            $stokOuts->where('barang_id', $request->barang_id);
        }

        return datatables()->of($stokOuts)
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->addColumn('user', function ($out) {
                return $out->user;
            })
            ->addColumn('nama', function ($out) {
                return $out->nama;
            })
            ->addColumn('tanggal', function ($out) {
                return Carbon::parse($out->tanggal)->format('d F, Y');
            })
            ->addColumn('stok_lama', function ($out) {
                return number_format($out->stok_lama);
            })
            ->addColumn('stok_keluar', function ($out) {
                return number_format($out->stok_keluar);
            })
            ->addColumn('note', function ($out) {
                return $out->note;
            })
            ->addColumn('action', function ($out) {
                $json = "{
                    id: '$out->id',
                    nama: '$out->nama',
                }";
                $btnEdit = "<button class=\"btn btn-warning btn-sm\" data-tooltip=\"true\" title=\"Edit\" onclick=\"editData($json)\"><i class=\"fa fa-edit\"></i></button>";
                $btnDelete = "<button class=\"btn btn-danger btn-sm\" data-tooltip=\"true\" title=\"Delete\" onclick=\"deleteData($out->id)\"><i class=\"fa fa-trash\"></i></button>";
                return "<div class=\"btn-group\">$btnEdit $btnDelete</div>";
            })
            ->toJson();
    }

    public function transaksi(Request $request)
    {
        $transaksi = Transaksi::selectRaw("
            transaksis.*,
            users.name as kasir
        ")
        ->join('users', 'users.id', 'transaksis.user_id')
        ->whereBetween('tanggal', [$request->date_start, $request->date_end]);

        if($request->user_id != 0){
            $transaksi->where('user_id', $request->user_id);
        }

        return datatables()->of($transaksi)
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->addColumn('nota', function ($tra) {
                return $tra->nota;
            })
            ->addColumn('tanggal', function ($tra) {
                return Carbon::parse($tra->created_at)->format('d F, Y H:i:s');
            })
            ->addColumn('kasir', function ($tra) {
                return $tra->kasir;
            })
            ->addColumn('total', function ($tra) {
                return number_format($tra->total);
            })
            ->addColumn('cash', function ($tra) {
                return number_format($tra->cash);
            })
            ->addColumn('kembalian', function ($tra) {
                return number_format($tra->kembalian);
            })
            ->addColumn('keuntungan', function ($tra) {
                return number_format($tra->keuntungan);
            })
            ->addColumn('note', function ($tra) {
                return $tra->note;
            })
            ->addColumn('action', function ($tra) {
                $json = "{
                    id: '$tra->id',
                }";
                $btnDetail = "<button class=\"btn btn-primary btn-sm\" data-tooltip=\"true\" title=\"Detail\" onclick=\"detailData($tra->id)\"><i class=\"fa fa-info-circle\"></i></button>";
                $btnPrint = "<button class=\"btn btn-success btn-sm\" data-tooltip=\"true\" title=\"Print\" onclick=\"printData($tra->id)\"><i class=\"fa fa-print\"></i></button>";
                $btnEdit = "<button class=\"btn btn-warning btn-sm\" data-tooltip=\"true\" title=\"Edit\" onclick=\"editData($json)\"><i class=\"fa fa-edit\"></i></button>";
                $btnDelete = "<button class=\"btn btn-danger btn-sm\" data-tooltip=\"true\" title=\"Delete\" onclick=\"deleteData($tra->id)\"><i class=\"fa fa-trash\"></i></button>";
                return "<div class=\"btn-group\">$btnDetail $btnPrint</div>";
            })
            ->toJson();
    }
}