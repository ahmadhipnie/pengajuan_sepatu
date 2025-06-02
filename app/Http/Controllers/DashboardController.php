<?php

namespace App\Http\Controllers;

use App\Models\DailyPengajuan;
use App\Models\Kurang;
use Illuminate\Http\Request;

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
}
