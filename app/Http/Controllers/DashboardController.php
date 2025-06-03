<?php

namespace App\Http\Controllers;

use App\Models\DailyPengajuan;
use App\Models\Kurang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalKurang = Kurang::sum('total');
        $totalDailyPengajuan = DailyPengajuan::count();

        // Hitung total per bagian
        $bagianList = [
            'assembly',
            'cutting',
            'sewing',
            'stokfitting',
            'incoming bottom',
            'treatment'
        ];
        $bagianCounts = [];
        foreach ($bagianList as $bagian) {
            $bagianCounts[$bagian] = DailyPengajuan::where('bagian', $bagian)->count();
        }

        return view('dashboard', compact('totalKurang', 'totalDailyPengajuan', 'bagianCounts'));
    }

    public function kurangTable()
    {
        $data = \App\Models\Kurang::with(['dailyPengajuan.po'])->get();
        return view('kurang.table', compact('data'));
    }

    public function table()
    {
        $data = \App\Models\DailyPengajuan::with(['po', 'sizeOrderDailies'])->get();
        return view('pengajuan.table', compact('data'));
    }

    public function assembly()
    {
        $data = \App\Models\DailyPengajuan::with(['po', 'sizeOrderDailies'])->get();

        // Ambil data size_order_po per bulan (berdasarkan bm di daily_pengajuan)
        $po = DB::table('size_order_po')
            ->join('daily_pengajuan', 'size_order_po.id_po', '=', 'daily_pengajuan.id_po')
            ->selectRaw('DATE_FORMAT(daily_pengajuan.bm, "%Y-%m") as bulan, SUM(size_order_po.total) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // Ambil data size_order_daily per bulan (berdasarkan bm di daily_pengajuan)
        $daily = DB::table('size_order_daily')
            ->join('daily_pengajuan', 'size_order_daily.id_daily_pengajuan', '=', 'daily_pengajuan.id')
            ->selectRaw('DATE_FORMAT(daily_pengajuan.bm, "%Y-%m") as bulan, SUM(size_order_daily.total) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // Ambil data kurang per bulan (berdasarkan bm di daily_pengajuan)
        $kurang = DB::table('kurang')
            ->join('daily_pengajuan', 'kurang.id_daily_pengajuan', '=', 'daily_pengajuan.id')
            ->selectRaw('DATE_FORMAT(daily_pengajuan.bm, "%Y-%m") as bulan, SUM(kurang.total) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // Gabungkan semua bulan yang ada
        $allMonths = collect($po)->pluck('bulan')
            ->merge(collect($daily)->pluck('bulan'))
            ->merge(collect($kurang)->pluck('bulan'))
            ->unique()
            ->sort()
            ->values();

        // Siapkan data untuk chart
        $labels = $allMonths->toArray();
        $poData = [];
        $dailyData = [];
        $kurangData = [];

        foreach ($labels as $bulan) {
            $poData[] = (int) ($po->firstWhere('bulan', $bulan)->total ?? 0);
            $dailyData[] = (int) ($daily->firstWhere('bulan', $bulan)->total ?? 0);
            $kurangData[] = (int) ($kurang->firstWhere('bulan', $bulan)->total ?? 0);
        }

        return view('assembly', compact('data', 'labels', 'poData', 'dailyData', 'kurangData'));
    }
}
