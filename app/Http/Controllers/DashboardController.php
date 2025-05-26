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

        return view('dashboard', compact('totalKurang', 'totalDailyPengajuan'));
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
