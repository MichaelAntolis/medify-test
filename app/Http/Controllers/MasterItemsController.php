<?php

namespace App\Http\Controllers;

use App\Models\MasterItem;
use App\Models\KategoriItem;
use Illuminate\Http\Request;
use App\Exports\MasterItemsExport;
use Maatwebsite\Excel\Facades\Excel;

class MasterItemsController extends Controller
{
    public function index()
    {
        return view('master_items.index.index');
    }

    public function search(Request $request)
    {
        $kode = $request->kode;
        $nama = $request->nama;
        $hargamin = $request->hargamin;
        $hargamax = $request->hargamax;

        $data_search = MasterItem::query();

        if (!empty($kode)) $data_search = $data_search->where('kode', $kode);
        if (!empty($nama)) $data_search = $data_search->where('nama', 'LIKE', '%' . $nama . '%');
        // if (!empty($hargamin)) $data_search = $data_search->where('harga_beli', '>=', $hargamin)->where('harga_beli', '<=', $hargamax);
        if (isset($hargamin) && $hargamin !== '') {
            $data_search = $data_search->where('harga_beli', '>=', $hargamin); 
            if (isset($hargamax) && $hargamax !== '') {
                $data_search = $data_search->where('harga_beli', '<=', $hargamax);
            }
        }

        $data_search = $data_search->select('kode', 'nama', 'jenis', 'harga_beli', 'laba', 'supplier')->orderBy('id')->get();


        return json_encode([
            'status' => 200,
            'data' => $data_search
        ]);
    }

    public function formView($method, $id = 0)
    {
        if ($method == 'new') {
            $item = new MasterItem;
        } else {
            $item = MasterItem::find($id);
        }
        $data['item'] = $item;
        $data['method'] = $method;

        $data['kategori_list'] = KategoriItem::orderBy('nama')->get();
        $data['selected_kategori'] = ($method == 'edit' && $item) ? $item->kategoriItems->pluck('id')->toArray(): [];

        return view('master_items.form.index', $data);
    }

    public function singleView($kode)
    {
        $data['data'] = MasterItem::where('kode', $kode)->first();
        return view('master_items.single.index', $data);
    }

    public function formSubmit(Request $request, $method, $id = 0)
    {
        if ($method == 'new') {
            $data_item = new MasterItem;
            $kode = MasterItem::count('id');
            $kode = $kode + 1;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);
            sleep(3);
        } else {
            $data_item = MasterItem::find($id);
            $kode = $data_item->kode;
        }

        $data_item->nama = $request->nama;
        $data_item->harga_beli = $request->harga_beli;
        $data_item->laba = $request->laba;
        $data_item->kode = $kode;
        $data_item->supplier = $request->supplier;
        $data_item->jenis = $request->jenis;

        if($request->hasFile('foto')){
            $file = $request->file('foto');
            $nama_file = time() . "_" . $file->getClientOriginalName();
            $tujuan_upload = 'images/items';
            $file->move($tujuan_upload, $nama_file);
            $data_item->foto = $tujuan_upload . '/' . $nama_file;
        }

        $data_item->save();

        $kategori_ids = $request->kategori_ids ?? [];
        $data_item->kategoriItems()->sync($kategori_ids);

        return redirect('master-items');
    }

    public function delete($id)
    {
        MasterItem::find($id)->delete();
        return redirect('master-items');
    }

    public function updateRandomData()
    {
        $data = MasterItem::get();
        foreach($data as $item)
        {
            $kode = $item->id;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);

            $item->harga_beli = rand(100,1000000);
            $item->laba = rand(10,99);
            $item->kode = $kode;
            $item->supplier = $this->getRandomSupplier();
            $item->jenis = $this->getRandomJenis();
            $item->save();
        }
    }

    private function getRandomSupplier()
    {
        $array = ['Tokopaedi','Bukulapuk','TokoBagas','E Commurz','Blublu'];
        $random = rand(0,4);
        return $array[$random];
    }

    private function getRandomJenis()
    {
        $array = ['Obat','Alkes','Matkes','Umum','ATK'];
        $random = rand(0,4);
        return $array[$random];
    }

    public function exportExcel()
    {
        $filename = 'master-items_' . date('Ymd-His') . '.xlsx';
        return Excel::download(new MasterItemsExport, $filename);
    }
}
