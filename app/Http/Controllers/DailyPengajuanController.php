<?php

namespace App\Http\Controllers;

use App\Models\DailyPengajuan;
use App\Models\Kurang;
use App\Models\SizeOrderDaily;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DailyPengajuanController extends Controller
{
    public function index(Request $request)
    {
        $query = DailyPengajuan::with('po');
        if ($request->has('search') && $request->search != '') {
            $query->whereHas('po', function ($q) use ($request) {
                $q->where('no_po', 'like', '%' . $request->search . '%');
            });
        }
        $data = $query->get();
        return view('daily_pengajuan.index', compact('data'));
    }

    public function show($id)
    {
        $pengajuan = DailyPengajuan::with(['po', 'sizeOrderDailies', 'kurangs'])->findOrFail($id);
        return view('daily_pengajuan.show', compact('pengajuan'));
    }

    public function edit($id)
    {
        $pengajuan = \App\Models\DailyPengajuan::with(['po', 'sizeOrderDailies'])->findOrFail($id);
        return view('daily_pengajuan.edit', compact('pengajuan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'size.*' => 'required',
            'total.*' => 'required|integer',
        ]);

        $pengajuan = \App\Models\DailyPengajuan::findOrFail($id);
        $pengajuan->update($request->only(['tanggal_mulai', 'tanggal_selesai']));

        // Hapus size order daily lama, insert ulang
        \App\Models\SizeOrderDaily::where('id_daily_pengajuan', $id)->delete();
        foreach ($request->size as $i => $size) {
            \App\Models\SizeOrderDaily::create([
                'size' => $size,
                'total' => $request->total[$i],
                'id_daily_pengajuan' => $id,
            ]);
        }

        return redirect()->route('daily_pengajuan.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        DailyPengajuan::findOrFail($id)->delete();
        return redirect()->route('daily_pengajuan.index')->with('success', 'Data berhasil dihapus');
    }

    public function updateKurang(Request $request, $id)
    {
        $pengajuan = DailyPengajuan::findOrFail($id);

        // Hapus semua kurang lama, insert ulang
        Kurang::where('id_daily_pengajuan', $id)->delete();
        if ($request->size && $request->total) {
            foreach ($request->size as $i => $size) {
                if ($size && $request->total[$i]) {
                    Kurang::create([
                        'size' => $size,
                        'total' => $request->total[$i],
                        'id_daily_pengajuan' => $id,
                    ]);
                }
            }
        }
        return redirect()->route('daily_pengajuan.show', $id)->with('success', 'Data kurang berhasil diupdate');
    }

    public function create(Request $request)
    {
        $po = null;
        $sizeOrderPo = [];
        if ($request->filled('no_po') && $request->filled('wide')) {
            $po = \App\Models\Po::where('no_po', $request->no_po)
                ->where('wide', $request->wide)
                ->first();
            if ($po) {
                $sizeOrderPo = $po->sizeOrderPos;
            }
        }
        return view('daily_pengajuan.create', compact('po', 'sizeOrderPo'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'no_po' => 'required',
            'wide' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'size.*' => 'required',
            'total.*' => 'required|integer',
        ]);

        $po = \App\Models\Po::where('no_po', $request->no_po)
            ->where('wide', $request->wide)
            ->first();

        if (!$po) {
            return back()->withInput()->withErrors(['no_po' => 'PO tidak ditemukan!']);
        }

        DB::transaction(function () use ($request, $po) {
            $daily = \App\Models\DailyPengajuan::create([
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'id_po' => $po->id,
            ]);
            foreach ($request->size as $i => $size) {
                \App\Models\SizeOrderDaily::create([
                    'size' => $size,
                    'total' => $request->total[$i],
                    'id_daily_pengajuan' => $daily->id,
                ]);
            }
        });

        return redirect()->route('daily_pengajuan.index')->with('success', 'Data berhasil ditambahkan');
    }
}
