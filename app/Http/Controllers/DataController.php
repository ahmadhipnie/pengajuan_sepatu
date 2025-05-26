<?php

namespace App\Http\Controllers;

use App\Models\Po;
use App\Models\SizeOrderPo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class DataController extends Controller
{
    public function index(Request $request)
    {
        $query = Po::with('sizeOrderPos');
        if ($request->has('search') && $request->search != '') {
            $query->where('no_po', 'like', '%' . $request->search . '%');
        }
        $po = $query->get();
        return view('po.index', compact('po'));
    }

    public function create()
    {
        return view('po.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_po' => 'required',
            'wide' => 'required',
            'size_run' => 'required',
            'colour_way' => 'required',
            'style' => 'required',
            'market' => 'required',
            'qty_original' => 'required|integer',
            'size.*' => 'required',
            'total.*' => 'required|integer',
        ]);

        // Cek total size order harus sama dengan qty_original
        $totalSizeOrder = array_sum($request->total);
        if ($totalSizeOrder != $request->qty_original) {
            return back()
                ->withInput()
                ->withErrors(['total' => 'Jumlah total Size Order PO harus sama dengan Qty Original!']);
        }

        DB::transaction(function () use ($request) {
            $po = Po::create($request->only([
                'no_po',
                'wide',
                'size_run',
                'colour_way',
                'style',
                'market',
                'qty_original'
            ]));

            foreach ($request->size as $i => $size) {
                SizeOrderPo::create([
                    'size' => $size,
                    'total' => $request->total[$i],
                    'id_po' => $po->id,
                ]);
            }
        });
        Alert::success('Success', 'PO berhasil ditambahkan');
        return redirect()->route('po.index')->with('success', 'PO berhasil ditambahkan');
    }

    public function edit($id)
    {
        $po = Po::with('sizeOrderPos')->findOrFail($id);
        return view('po.edit', compact('po'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'no_po' => 'required',
            'wide' => 'required',
            'size_run' => 'required',
            'colour_way' => 'required',
            'style' => 'required',
            'market' => 'required',
            'qty_original' => 'required|integer',
            'size.*' => 'required',
            'total.*' => 'required|integer',
        ]);

        // Cek total size order harus sama dengan qty_original
        $totalSizeOrder = array_sum($request->total);
        if ($totalSizeOrder != $request->qty_original) {
            return back()
                ->withInput()
                ->withErrors(['total' => 'Jumlah total Size Order PO harus sama dengan Qty Original!']);
        }

        DB::transaction(function () use ($request, $id) {
            $po = Po::findOrFail($id);
            $po->update($request->only([
                'no_po',
                'wide',
                'size_run',
                'colour_way',
                'style',
                'market',
                'qty_original'
            ]));

            // Hapus size lama, insert ulang
            SizeOrderPo::where('id_po', $po->id)->delete();
            foreach ($request->size as $i => $size) {
                SizeOrderPo::create([
                    'size' => $size,
                    'total' => $request->total[$i],
                    'id_po' => $po->id,
                ]);
            }
        });
        Alert::success('Success', 'PO berhasil diupdate');
        return redirect()->route('po.index')->with('success', 'PO berhasil diupdate');
    }

    public function destroy($id)
    {
        Po::findOrFail($id)->delete();
        Alert::success('Success', 'PO berhasil dihapus');
        return redirect()->route('po.index')->with('success', 'PO berhasil dihapus');
    }
}
