<?php

namespace App\Http\Controllers;

use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TiketController extends Controller
{
    public function index()
    {
        // Mengambil semua data tiket dari database
        $tikets = Tiket::all();
        return response()->json($tikets);
    }

    public function show($id)
    {
        // Mengambil satu tiket berdasarkan ID
        $tiket = Tiket::findOrFail($id);
        return response()->json($tiket);
    }

    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'status' => 'required|in:open,closed,in_progress', // Hanya menerima status yang valid
            'lampiran' => 'nullable|file|mimes:jpeg,png,jpg,pdf,doc,docx|max:10240', // Lampiran opsional
        ]);

        // Menyimpan lampiran jika ada
        $data = $request->all();
        if ($request->hasFile('lampiran')) {
            $data['lampiran'] = '/storage/' . $request->file('lampiran')->store('tikets', 'public');
        }

        // Membuat tiket baru
        $tiket = Tiket::create($data);

        return response()->json([
            'message' => 'Tiket berhasil dibuat',
            'data' => $tiket
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validasi data
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'status' => 'required|in:open,closed,in_progress',
            //'lampiran' => 'nullable|file|mimes:jpeg,png,jpg,pdf,doc,docx|max:10240',
        ]);

        // Mengambil tiket yang akan di-update
        $tiket = Tiket::findOrFail($id);

        // Menghapus lampiran lama jika ada yang baru diupload
        if ($request->hasFile('lampiran')) {
            if ($tiket->lampiran) {
                $oldFile = str_replace('/storage/', '', $tiket->lampiran);
                Storage::disk('public')->delete($oldFile);
            }
            $data['lampiran'] = '/storage/' . $request->file('lampiran')->store('tikets', 'public');
        }

        // Mengupdate data tiket
        $tiket->update($request->all());

        return response()->json([
            'message' => 'Tiket berhasil diupdate',
            'data' => $tiket
        ]);
    }

    public function destroy($id)
    {
        // Menghapus tiket berdasarkan ID
        $tiket = Tiket::findOrFail($id);

        // Hapus lampiran jika ada
        if ($tiket->lampiran) {
            $filePath = str_replace('/storage/', '', $tiket->lampiran);
            Storage::disk('public')->delete($filePath);
        }

        // Hapus data tiket
        $tiket->delete();

        return response()->json([
            'message' => 'Tiket berhasil dihapus'
        ]);
    }
}