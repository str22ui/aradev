<?php

namespace App\Http\Controllers;


use Carbon\Carbon;

use App\Exports\ExportReport;
use App\Exports\ExportKonsumen;
use App\Exports\ExportSurvey;
use App\Exports\ExportPenawaran;
use App\Exports\ExportAgent;
use App\Exports\ExportReseller;

use Maatwebsite\Excel\Facades\Excel;

use App\Models\Visit;
use App\Models\Perumahan;
use App\Models\User;
use App\Models\Secondary;
use App\Models\Rumah;
use App\Models\Konsumen;
use App\Models\Survey;
use App\Models\Land;
use App\Models\Agent;
use App\Models\Reseller;
use App\Models\Report;
use App\Models\Penawaran;
use App\Models\PerumahanImage;
use App\Models\SecondaryImage;
use App\Models\LandImage;
use App\Models\Info;
use App\Models\InfoImage;
use App\Models\Service;
use App\Models\Wishlist;
use App\Models\ServiceImage;
use App\Models\Testimony;
use App\Models\TestimonyImage;
use App\Models\Announcement;
use Illuminate\Support\Str;
use App\Models\CategoryBursa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\Log;

class AdminTestimonyController extends Controller
{


    // ============ TESTIMONY ================

    public function indexTestimony()
    {
        $testimony = Testimony::all();
    //    $testimony = Testimony::with('imagesTestimony')->get();
        $user = Auth::user();
        return view('admin.testimony.index', [
            'testimony' => $testimony,
            // 'user' => $user,
        ]);
    }

    public function imagesTestimony()
    {
        return $this->hasMany(TestimonyImage::class);
    }


    public function createTestimony(){
        return view('admin.testimony.createTestimony');
    }


    public function storeTestimony(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'kota' => 'required',
            'pekerjaan' => 'required',
            'image' => 'image|file|max:5120|mimes:jpeg,png,jpg,webp',
            'testimony' => 'required',
        ]);


    // Simpan gambar jika ada
    if ($request->hasFile('image')) {
        $validatedData['image'] = $request->file('image')->store('foto-testimony', 'public');
    }

    // Simpan data ke tabel testimony
    Testimony::create($validatedData);
    return redirect('/testimony-home')->with('success', 'Berhasil Menambahkan Data Testimony');
}



    public function editTestimony($id)
    {
        $testimony = Testimony::find($id);

        return view('admin.testimony.editTestimony', [
            'testimony' => $testimony,
        ]);
    }

    public function removeImageTestimony(Request $request)
    {
        try {
            Log::info('Request diterima:', $request->all());
            $imagePath = $request->input('image');

            // Hapus dari database
            $deleted = TestimonyImage::where('image_path', $imagePath)->delete();
            Log::info('Hasil penghapusan dari database:', ['deleted' => $deleted]);

            if (!$deleted) {
                return response()->json(['success' => false, 'message' => 'Gambar tidak ditemukan di database']);
            }

            // Hapus file fisik
            $filePath = public_path('storage/' . $imagePath);
            if (file_exists($filePath)) {
                unlink($filePath);
                Log::info('File berhasil dihapus:', [$filePath]);
            } else {
                Log::warning('File tidak ditemukan:', [$filePath]);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Terjadi kesalahan:', [$e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan server'], 500);
        }
    }


    public function updateTestimony(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required',
            'kota' => 'required',
            'pekerjaan' => 'required',
            'image' => 'image|file|max:5120|mimes:jpeg,png,jpg,webp',
            'testimony' => 'required',
        ]);

        $testimony = Testimony::findOrFail($id);

        // Jika ada file gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($testimony->image) {
                Storage::disk('public')->delete($testimony->image);
            }

            // Simpan gambar baru
            $imagePath = $request->file('image')->store('foto-testimony', 'public');
            $testimony->image = $imagePath;
        }

        // Update data lainnya
        $testimony->name = $request->name;
        $testimony->kota = $request->kota;
        $testimony->pekerjaan = $request->pekerjaan;
        $testimony->testimony = $request->testimony;

        // Simpan perubahan
        $testimony->save();

        return redirect()->route('admin.testimony')->with('success', 'Data testimony berhasil diperbarui.');
    }


    public function destroyImageTestimony(Request $request)
    {
        // Debugging
        Log::info($request->all());
        Log::info('Request ID: ' . $request->image_id);
        // Temukan gambar berdasarkan ID
        $image = TestimonyImage::findOrFail($request->image_id);

        // Hapus file fisik
        $filePath = storage_path('app/public/' . $image->image_path);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Hapus dari database
        $image->delete();

        return redirect()->back()->with('success', 'Gambar berhasil dihapus.');
        }


    public function destroyTestimony(Request $request)
    {
        // Debug untuk melihat data yang diterima
        Log::info($request->id);

        // Ambil data perumahan berdasarkan ID
        $testimony = Testimony::findOrFail($request->id);

        // Hapus data
        $testimony->delete();

        // Redirect dengan pesan sukses
        return redirect('/testimony-home')->with('success', 'Berhasil Menghapus Data Testimony');
    }

   // ============ END TESTIMONY ================
}
