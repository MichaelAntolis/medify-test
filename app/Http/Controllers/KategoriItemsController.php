<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriItem;
use Barryvdh\DomPDF\Facade\Pdf;

class KategoriItemsController extends Controller
{
    public function index(Request $request)
    {
        $kode = $request->kode;
        $nama = $request->nama;
        $query = KategoriItem::query();
        if (!empty($kode)) {
            $query->where('kode', 'LIKE', '%' . $kode . '%');
        }
        if (!empty($nama)) {
            $query->where('nama', 'LIKE', '%' . $nama . '%');
        }
        $data['kategori_list'] = $query->orderBy('id')->get();
        $data['filter_kode'] = $kode;
        $data['filter_nama'] = $nama;
        return view('kategori_items.index.index', $data);
    }
    public function singleView($id)
    {
        $data['kategori'] = KategoriItem::with('masterItems')->findOrFail($id);
        return view('kategori_items.single.index', $data);
    }
    public function formView($method, $id = 0)
    {
        if ($method == 'new') {
            $kategori = new KategoriItem;
        } else {
            $kategori = KategoriItem::findOrFail($id);
        }
        $data['kategori'] = $kategori;
        $data['method'] = $method;
        return view('kategori_items.form.index', $data);
    }
    public function formSubmit(Request $request, $method, $id = 0)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:50',
        ]);
        if ($method == 'new') {
            $kategori = new KategoriItem;
        } else {
            $kategori = KategoriItem::findOrFail($id);
        }
        $kategori->nama = $request->nama;
        $kategori->kode = $request->kode;
        $kategori->save();
        return redirect('kategori-items');
    }
    public function delete($id)
    {
        KategoriItem::findOrFail($id)->delete();
        return redirect('kategori-items');
    }

    public function downloadPdf($id){
        $kategori = KategoriItem::with('masterItems')->findOrFail($id);
        $tanggalCetak = now()->locale('id')->isoFormat('dddd, D MMMM YYYY HH:mm:ss');
        $pdf = Pdf::loadView('kategori_items.pdf.index', [
            'kategori' => $kategori,
            'tanggalCetak' => $tanggalCetak
        ]);
        $filename = 'kategori-' . $kategori->kode . '.pdf';
        return $pdf->download($filename);
    }
}
