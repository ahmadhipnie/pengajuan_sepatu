<?php

namespace App\Http\Controllers;

use App\Models\DailyPengajuan;
use App\Models\Kurang;
use App\Models\SizeOrderDaily;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

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

        $errors = [];
        if ($request->size && $request->total) {
            foreach ($request->size as $i => $size) {
                $inputKurang = (int) $request->total[$i];
                // Cari data kurang yang sesuai
                $kurang = Kurang::where('id_daily_pengajuan', $id)->where('size', $size)->first();

                if (!$kurang) {
                    $errors[] = "Data kurang untuk size $size tidak ditemukan!";
                    continue;
                }

                if ($inputKurang > $kurang->total) {
                    $errors[] = "Input kurang untuk size $size tidak boleh lebih dari {$kurang->total}!";
                    continue;
                }

                // Tambahkan ke SizeOrderDaily
                $sizeOrderDaily = \App\Models\SizeOrderDaily::where('id_daily_pengajuan', $id)
                    ->where('size', $size)
                    ->first();

                if ($sizeOrderDaily) {
                    $sizeOrderDaily->total += $inputKurang;
                    $sizeOrderDaily->save();
                } else {
                    // Jika belum ada, buat baru
                    \App\Models\SizeOrderDaily::create([
                        'size' => $size,
                        'total' => $inputKurang,
                        'id_daily_pengajuan' => $id,
                    ]);
                }

                // Kurangi dari tabel kurang
                $sisa = $kurang->total - $inputKurang;

                if ($sisa == 0) {
                    $kurang->delete();
                } else {
                    $kurang->update(['total' => $sisa]);
                }
            }
        }

        if (count($errors) > 0) {
            Alert::error('Error', 'Ada kesalahan dalam input data kurang:');
            return back()->withInput()->with('swal_error', implode("\n", $errors));
        }

        Alert::success('Success', 'Data kurang berhasil diupdate');
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
            'cell' => 'required',
            'bagian' => 'required',
            'xfd' => 'required|date',
            'bm' => 'required|date',
            'size.*' => 'required',
            'total.*' => 'required|integer',
        ]);

        $po = \App\Models\Po::where('no_po', $request->no_po)
            ->where('wide', $request->wide)
            ->first();

        if (!$po) {
            return back()->withInput()->withErrors(['no_po' => 'PO tidak ditemukan!']);
        }

        // Validasi: total sizeorderdaily tidak boleh lebih dari sizeorderpo
        $sizeOrderPo = $po->sizeOrderPos()->get()->keyBy('size');
        foreach ($request->size as $i => $size) {
            $inputTotal = (int)$request->total[$i];
            $poTotal = isset($sizeOrderPo[$size]) ? (int)$sizeOrderPo[$size]->total : null;
            if ($poTotal === null) {
                Alert::error('Error', "Size $size tidak ditemukan pada PO!");
                return back()->withInput()->withErrors(['size' => "Size $size tidak ditemukan pada PO!"]);
            }
            if ($inputTotal > $poTotal) {
                Alert::error('Error', "Total untuk size $size tidak boleh lebih dari $poTotal!");
                return back()->withInput()->withErrors(['total' => "Total untuk size $size tidak boleh lebih dari $poTotal!"]);
            }
        }

        DB::transaction(function () use ($request, $po) {
            $daily = \App\Models\DailyPengajuan::create([
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'cell' => $request->cell,
                'bagian' => $request->bagian,
                'bm' => $request->bm,
                'xfd' => $request->xfd,
                'id_po' => $po->id,
            ]);

            // Simpan SizeOrderDaily
            foreach ($request->size as $i => $size) {
                \App\Models\SizeOrderDaily::create([
                    'size' => $size,
                    'total' => $request->total[$i],
                    'id_daily_pengajuan' => $daily->id,
                ]);
            }

            // Cek selisih dan simpan ke tabel kurang jika perlu
            $sizeOrderPo = $po->sizeOrderPos()->get();
            foreach ($sizeOrderPo as $poSize) {
                // Cari total pada sizeOrderDaily untuk size ini
                $inputIndex = collect($request->size)->search($poSize->size);
                $dailyTotal = $inputIndex !== false ? (int)$request->total[$inputIndex] : 0;
                if ($dailyTotal < $poSize->total) {
                    $selisih = $poSize->total - $dailyTotal;
                    \App\Models\Kurang::create([
                        'size' => $poSize->size,
                        'total' => $selisih,
                        'id_daily_pengajuan' => $daily->id,
                    ]);
                }
            }
        });

        return redirect()->route('daily_pengajuan.index')->with('success', 'Data berhasil ditambahkan');
    }
}
