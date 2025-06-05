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

class AdminPerumahanController extends Controller
{
      // ============ PERUMAHAN ================

    public function indexPerumahan()
    {
        $perumahan = Perumahan::all();
        $user = Auth::user();
        return view('admin.perumahan.index', [
            'perumahan' => $perumahan,
            // 'user' => $user,
        ]);
    }

    public function images()
    {
        return $this->hasMany(PerumahanImage::class);
    }


    public function createPerumahan(){
        return view('admin.perumahan.createPerumahan');
    }

    public function showPerumahan(Perumahan $perumahan)
    {
        $perumahan = Perumahan::with('position')->findOrFail($management->id);
        $perumahan->keunggulan = json_decode($perumahan->keunggulan);
        return view('admin.teacher.showTeacher', compact([
            'management',
        ]));
    }

    public function storePerumahan(Request $request)
    {
        $validatedData = $request->validate([
            'images.*' => 'image|file|max:5120|mimes:jpeg,png,jpg,webp',
            'perumahan' => 'required',
            'luas' => 'required',
            'unit' => 'required',
            'lokasi' => 'required',
            'kota' => 'required',
            'satuan' => 'required',
            'harga' => 'required',
            'harga_asli' => 'required',
            'status' => 'required',
            'deskripsi' => 'required',
            'brosur' => 'nullable|file|max:20480|mimes:pdf,doc,docx,ppt,pptx',
            'pricelist' => 'nullable|file|max:20480|mimes:pdf,doc,docx,ppt,pptx',
            'keunggulan' => 'nullable|array',
            'keunggulan.*' => 'string|max:255',
            'tipe' => 'nullable|array',
            'tipe.*' => 'string|max:255',
            'maps' => 'required',
            'fasilitas' => 'required|array',
            'fasilitas.*' => 'string|max:255',
            // 'video' => 'nullable|url|regex:/^(https:\/\/(www\.)?youtube\.com\/|https:\/\/youtu\.be\/)/i',
            'video' => ['nullable', 'url', function ($attribute, $value, $fail) {
                if (!str_contains($value, 'youtube.com') && !str_contains($value, 'youtu.be')) {
                    $fail('URL video harus berasal dari YouTube.');
                }
            }],

        ]);

        // Simpan data JSON jika ada
        if ($request->has('fasilitas')) {
            $validatedData['fasilitas'] = json_encode($request->fasilitas);
        }
        if ($request->has('keunggulan')) {
            $validatedData['keunggulan'] = json_encode($request->keunggulan);
        }
        if ($request->has('tipe')) {
            $validatedData['tipe'] = json_encode($request->tipe);
        }

        // Upload file
        if ($request->hasFile('brosur')) {
            $validatedData['brosur'] = $request->file('brosur')->store('brosur', 'public');
        }
        if ($request->hasFile('pricelist')) {
            $validatedData['pricelist'] = $request->file('pricelist')->store('pricelist', 'public');
        }

        // Simpan data perumahan dan ambil objeknya
        $perumahan = Perumahan::create($validatedData);

        // Jika ada URL video, ubah ke embed URL
        if ($perumahan->video) {
            $videoUrl = $perumahan->video;

            if (str_contains($videoUrl, 'youtu.be')) {
                $videoId = last(explode('/', parse_url($videoUrl, PHP_URL_PATH)));
                $embedUrl = "https://www.youtube.com/embed/{$videoId}";
            } else {
                $embedUrl = str_replace('watch?v=', 'embed/', $videoUrl);
            }

            // Update properti video dengan URL embed
            $perumahan->update(['video' => $embedUrl]);
        }


        // Simpan gambar terkait jika ada
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('foto-perumahan', 'public');
                PerumahanImage::create([
                    'perumahan_id' => $perumahan->id, // Gunakan $perumahan yang sudah didefinisikan
                    'image_path' => $path,
                ]);
            }
        }

        return redirect('/perumahan')->with('success', 'Berhasil Menambahkan Perumahan');
}




    public function downloadBrosur($id)
    {
        $brosur = DB::table('units')->where('id', $id)->first();

        if ($brosur) {
            $pathToFile = storage_path("app/public/{$brosur->brosur}");
            return Response::download($pathToFile);
        } else {
            // Tambahkan logika untuk menangani jika brosur tidak ditemukan
            return redirect()->back()->with('error', 'Brosur tidak ditemukan');
        }
    }
    public function downloadPricelist($id)
    {
        $pricelist = DB::table('units')->where('id', $id)->first();

        if ($pricelist) {
            $pathToFile = storage_path("app/public/{$pricelist->pricelist}");
            return Response::download($pathToFile);
        } else {
            // Tambahkan logika untuk menangani jika brosur tidak ditemukan
            return redirect()->back()->with('error', 'Pricelist tidak ditemukan');
        }
    }

    // public function editPerumahan($id)
    // {
    //     $perumahan = Perumahan::find($id);

    //     return view('admin.perumahan.editPerumahan', [
    //         'perumahan' => $perumahan,
    //     ]);
    // }

    public function editPerumahan($id)
    {
        $perumahan = Perumahan::find($id);
        $perumahan->tipe = json_decode($perumahan->tipe, true);
        $perumahan->keunggulan = json_decode($perumahan->keunggulan, true);
        $perumahan->fasilitas = json_decode($perumahan->fasilitas, true);
        $images = PerumahanImage::where('perumahan_id', $id)->get();



        return view('admin.perumahan.editPerumahan', [
            'perumahan' => $perumahan,
            'images' => $images, // Kirim gambar ke view
        ]);
    }

    public function removeImage(Request $request)
    {
        try {
            Log::info('Request diterima:', $request->all());
            $imagePath = $request->input('image');

            // Hapus dari database
            $deleted = PerumahanImage::where('image_path', $imagePath)->delete();
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


    public function updatePerumahan(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'perumahan' => 'required|max:255',
            'luas' => 'required|numeric',
            'unit' => 'required|numeric',
            'lokasi' => 'required|max:255',
            'kota' => 'required|max:255',
            'satuan' => 'required|max:255',
            'harga' => 'required|numeric',
            'harga_asli' => 'required|numeric',
            'status' => 'required|max:255',
            'deskripsi' => 'required',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'keunggulan' => 'nullable|array',
            'keunggulan.*' => 'string|max:255',
            'tipe' => 'nullable|array',
            'tipe.*' => 'string|max:255',
            'maps' => 'required',
            'fasilitas' => 'required|array',
            'fasilitas.*' => 'string|max:255',
            'brosur' => 'nullable|mimes:pdf|max:2048',
            'pricelist' => 'nullable|mimes:pdf|max:2048',
            'remove_images' => 'nullable|array',
            'remove_images.*' => 'integer',
            'video' => ['nullable', 'url', function ($attribute, $value, $fail) {
                if (!str_contains($value, 'youtube.com') && !str_contains($value, 'youtu.be')) {
                    $fail('URL video harus berasal dari YouTube.');
                }
            }],
        ]);

        // Ambil data perumahan
        $perumahan = Perumahan::findOrFail($id);

        // Update data utama
        $perumahan->update([
            'perumahan' => $request->perumahan,
            'luas' => $request->luas,
            'unit' => $request->unit,
            'lokasi' => $request->lokasi,
            'kota' => $request->kota,
            'satuan' => $request->satuan,
            'harga' => $request->harga,
            'harga_asli' => $request->harga_asli,
            'status' => $request->status,
            'deskripsi' => $request->deskripsi,
            'maps' => $request->maps,
            'video' => $request->video,
            'fasilitas' => json_encode($request->fasilitas),
            'keunggulan' => json_encode($request->keunggulan),
            'tipe' => json_encode($request->tipe),
        ]);

        // Menangani gambar baru
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('perumahan_images', 'public');
                PerumahanImage::create([
                    'perumahan_id' => $perumahan->id,
                    'image_path' => $path,
                ]);
            }
        }

        $keunggulan = $request->input('keunggulan', []); // Ambil array keunggulan dari form
        $perumahan->keunggulan = json_encode(array_filter($keunggulan)); // Hapus nilai kosong dan encode JSON

        // Simpan fasilitas baru
        $fasilitas = $request->input('fasilitas', []); // Ambil array fasilitas dari form
        $perumahan->fasilitas = json_encode(array_filter($fasilitas)); // Hapus nilai kosong dan encode JSON

        // Update brosur
        if ($request->hasFile('brosur')) {
            if ($perumahan->brosur && Storage::exists('public/' . $perumahan->brosur)) {
                Storage::delete('public/' . $perumahan->brosur);
            }
            $perumahan->brosur = $request->file('brosur')->store('brosur', 'public');
        }

        // Update pricelist
        if ($request->hasFile('pricelist')) {
            if ($perumahan->pricelist && Storage::exists('public/' . $perumahan->pricelist)) {
                Storage::delete('public/' . $perumahan->pricelist);
            }
            $perumahan->pricelist = $request->file('pricelist')->store('pricelist', 'public');
        }

        // Simpan perubahan
        $perumahan->save();

        return redirect()->route('admin.perumahan')->with('success', 'Data perumahan berhasil diperbarui.');
    }

    public function destroyImage(Request $request)
    {
        // Debugging
        \Log::info($request->all());
        \Log::info('Request ID: ' . $request->image_id);
        // Temukan gambar berdasarkan ID
        $image = PerumahanImage::findOrFail($request->image_id);

        // Hapus file fisik
        $filePath = storage_path('app/public/' . $image->image_path);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Hapus dari database
        $image->delete();

        return redirect()->back()->with('success', 'Gambar berhasil dihapus.');
        }


    public function destroyPerumahan(Request $request)
    {
        // Debug untuk melihat data yang diterima
        \Log::info($request->id);

        // Ambil data perumahan berdasarkan ID
        $perumahan = Perumahan::findOrFail($request->id);

        // Hapus data
        $perumahan->delete();

        // Redirect dengan pesan sukses
        return redirect('/perumahan')->with('success', 'Berhasil Menghapus Perumahan');
    }


    // ============ END PERUMAHAN ================

}
