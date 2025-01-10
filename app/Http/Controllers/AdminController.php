<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use App\Exports\ExportReport;

use Maatwebsite\Excel\Facades\Excel;

use App\Models\Visit;
use App\Models\Perumahan;
use App\Models\Secondary;
use App\Models\Rumah;
use App\Models\Konsumen;
use App\Models\Land;
use App\Models\Agent;
use App\Models\Report;
use App\Models\Penawaran;
use App\Models\PerumahanImage;
use App\Models\SecondaryImage;
use App\Models\LandImage;
use App\Models\Info;
use App\Models\InfoImage;
use App\Models\Testimony;
use App\Models\TestimonyImage;
use App\Models\Announcement;
use Illuminate\Support\Str;
use App\Models\CategoryBursa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Cviebrock\EloquentSluggable\Services\SlugService;

class AdminController extends Controller
{
    public function indexAdmin()
    {
        $todayDate = Carbon::now()->format('Y-m-d');
        $monthDate = Carbon::now()->format('m');

        $totalVisits = Visit::count();
        $todayVisits = Visit::whereDate('visited_at', $todayDate)->count();
        $monthVisits = Visit::whereMonth('visited_at', $monthDate)->count();

        // $employee = Employee::all();

        return view('admin.index', compact([
            // 'employee',
            'totalVisits',
            'todayVisits',
            'monthVisits',
        ]));
    }

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


     // ============ SECONDARY ================

     public function indexSecondary()
     {
         $secondary = Secondary::with('imagesSecondary')->get(); // Eager loading relasi
         $user = Auth::user();
         return view('admin.secondary.index', [
             'secondary' => $secondary,
             // 'user' => $user,
         ]);
     }


     public function imagesSecondary()
     {
         return $this->hasMany(SecondaryImage::class);
     }




     public function createSecondary(){
         return view('admin.secondary.createSecondary');
     }

     public function showSecondary(Secondary $secondary)
     {
         $secondary = Secondary::with('position')->findOrFail($management->id);
         $perumahan->keunggulan = json_decode($perumahan->keunggulan);
         return view('admin.teacher.showTeacher', compact([
             'management',
         ]));
     }

     public function storeSecondary(Request $request)
     {
         $validatedData = $request->validate([
             'images.*' => 'image|file|max:5120|mimes:jpeg,png,jpg,webp',
             'judul' => 'required',
             'available' => 'required',
             'lt' => 'required',
             'lb' => 'required',
             'kt' => 'required',
             'ktp' => 'required',
             'km' => 'required',
             'kmp' => 'required',
             'carport' => 'required',
             'garasi' => 'required',
             'listrik' => 'required',
             'air' => 'required',
             'surat' => 'required',
             'imb' => 'required',
             'posisi' => 'required',
             'furnish' => 'required',
             'harga' => 'required',
             'lokasi' => 'required',
             'kecamatan' => 'required',
             'kota' => 'required',
             'deskripsi' => 'required',


         ]);


         // Simpan data perumahan dan ambil objeknya
         $secondary = Secondary::create($validatedData);

         // Simpan gambar terkait jika ada
         if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('foto-secondary', 'public');
                SecondaryImage::create([
                    'secondary_id' => $secondary->id,
                    'image_path' => $path,
                ]);
            }
        }

         return redirect('/secondary')->with('success', 'Berhasil Menambahkan Perumahan');
 }



     public function editSecondary($id)
     {
         $secondary = Secondary::find($id);
         $images = SecondaryImage::where('secondary_id', $id)->get();


         return view('admin.secondary.editSecondary', [
             'secondary' => $secondary,
             'images' => $images, // Kirim gambar ke view
         ]);
     }

     public function removeImageSecondary(Request $request)
     {
         try {
             Log::info('Request diterima:', $request->all());
             $imagePath = $request->input('image');

             // Hapus dari database
             $deleted = SecondaryImage::where('image_path', $imagePath)->delete();
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


     public function updateSecondary(Request $request, $id)
     {
         // Validasi input
         $request->validate([
            'images.*' => 'image|file|max:5120|mimes:jpeg,png,jpg,webp',
             'judul' => 'required',
             'available' => 'required',
             'status' => 'required',
             'lt' => 'required',
             'lb' => 'required',
             'kt' => 'required',
             'ktp' => 'required',
             'km' => 'required',
             'kmp' => 'required',
             'carport' => 'required',
             'garasi' => 'required',
             'listrik' => 'required',
             'air' => 'required',
             'surat' => 'required',
             'imb' => 'required',
             'hadap' => 'required',
             'posisi' => 'required',
             'furnish' => 'required',
             'harga' => 'required',
             'lokasi' => 'required',
             'kecamatan' => 'required',
             'kota' => 'required',
             'deskripsi' => 'required',
         ]);

         // Ambil data perumahan
         $secondary = Secondary::findOrFail($id);

         // Update data utama
         $secondary->update([
             'judul' => $request->judul,
             'status' => $request->status,
             'available' => $request->available,
             'lt' => $request->lt,
             'lb' => $request->lb,
             'kt' => $request->kt,
             'ktp' => $request->ktp,
             'km' => $request->km,
             'kmp' => $request->kmp,
             'carport' => $request->carport,
             'garasi' => $request->garasi,
             'listrik' => $request->listrik,
             'air' => $request->air,
             'surat' => $request->surat,
             'imb' => $request->imb,
             'hadap' => $request->hadap,
             'posisi' => $request->posisi,
             'furnish' => $request->furnish,
             'harga' => $request->harga,
             'lokasi' => $request->lokasi,
             'kecamatan' => $request->kecamatan,
             'kota' => $request->kota,
             'deskripsi' => $request->deskripsi,
         ]);

         // Menangani gambar baru
         if ($request->hasFile('images')) {
             foreach ($request->file('images') as $file) {
                 $path = $file->store('secondary_images', 'public');
                 SecondaryImage::create([
                     'secondary_id' => $secondary->id,
                     'image_path' => $path,
                 ]);
             }
         }


         // Simpan perubahan
         $secondary->save();

         return redirect()->route('admin.secondary')->with('success', 'Data perumahan berhasil diperbarui.');
     }

     public function destroyImageSecondary(Request $request)
     {
         // Debugging
         \Log::info($request->all());
         \Log::info('Request ID: ' . $request->image_id);
         // Temukan gambar berdasarkan ID
         $image = SecondaryImage::findOrFail($request->image_id);

         // Hapus file fisik
         $filePath = storage_path('app/public/' . $image->image_path);
         if (file_exists($filePath)) {
             unlink($filePath);
         }

         // Hapus dari database
         $image->delete();

         return redirect()->back()->with('success', 'Gambar berhasil dihapus.');
         }


     public function destroySecondary(Request $request)
     {
         // Debug untuk melihat data yang diterima
         \Log::info($request->id);

         // Ambil data perumahan berdasarkan ID
         $secondary = Secondary::findOrFail($request->id);

         // Hapus data
         $secondary->delete();

         // Redirect dengan pesan sukses
         return redirect('/secondary')->with('success', 'Berhasil Menghapus Perumahan');
     }

    // ============ END SECONDARY ================

     // ============ LAND ================

     public function indexLand()
     {
        //  $land = Land::all();
        $land = Land::with('imagesLand')->get();
         $user = Auth::user();
         return view('admin.land.index', [
             'land' => $land,
             // 'user' => $user,
         ]);
     }

     public function imagesLand()
     {
         return $this->hasMany(LandImage::class);
     }


     public function createLand(){
         return view('admin.land.createLand');
     }

     public function showLand(Land $land)
     {
         $land = Land::with('position')->findOrFail($management->id);
         $perumahan->keunggulan = json_decode($perumahan->keunggulan);
         return view('admin.teacher.showTeacher', compact([
             'management',
         ]));
     }

     public function storeLand(Request $request)
     {
         $validatedData = $request->validate([
             'images.*' => 'image|file|max:5120|mimes:jpeg,png,jpg,webp',
             'judul' => 'required',
             'lt' => 'required',
             'surat' => 'required',
             'imb' => 'required',
             'harga' => 'required',
             'lokasi' => 'required',
             'kecamatan' => 'required',
             'kota' => 'required',
             'deskripsi' => 'required',

         ]);


         // Simpan data perumahan dan ambil objeknya
         $land = Land::create($validatedData);

         // Simpan gambar terkait jika ada
         if ($request->hasFile('images')) {
             foreach ($request->file('images') as $image) {
                 $path = $image->store('foto-land', 'public');
                 LandImage::create([
                     'land_id' => $land->id, // Gunakan $secondary yang sudah didefinisikan
                     'image_path' => $path,
                 ]);
             }
         }

         return redirect('/land')->with('success', 'Berhasil Menambahkan Data Tanah');
 }



     public function editLand($id)
     {
         $land = Land::find($id);
         $images = LandImage::where('land_id', $id)->get();


         return view('admin.land.editLand', [
             'land' => $land,
             'images' => $images, // Kirim gambar ke view
         ]);
     }

     public function removeImageLand(Request $request)
     {
         try {
             Log::info('Request diterima:', $request->all());
             $imagePath = $request->input('image');

             // Hapus dari database
             $deleted = LandImage::where('image_path', $imagePath)->delete();
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


     public function updateLand(Request $request, $id)
     {
         // Validasi input
         $request->validate([
            'images.*' => 'image|file|max:5120|mimes:jpeg,png,jpg,webp',
             'judul' => 'required',
             'lt' => 'required',
             'surat' => 'required',
             'imb' => 'required',
             'harga' => 'required',
             'lokasi' => 'required',
             'kecamatan' => 'required',
             'kota' => 'required',
             'deskripsi' => 'required',
         ]);

         // Ambil data perumahan
         $land = Land::findOrFail($id);

         // Update data utama
         $land->update([
             'judul' => $request->judul,
             'lt' => $request->lt,
             'surat' => $request->surat,
             'imb' => $request->imb,
             'harga' => $request->harga,
             'lokasi' => $request->lokasi,
             'kecamatan' => $request->kecamatan,
             'kota' => $request->kota,
             'deskripsi' => $request->deskripsi,
         ]);

         // Menangani gambar baru
         if ($request->hasFile('images')) {
             foreach ($request->file('images') as $file) {
                 $path = $file->store('land_images', 'public');
                 LandImage::create([
                     'land_id' => $land->id,
                     'image_path' => $path,
                 ]);
             }
         }


         // Simpan perubahan
         $land->save();

         return redirect()->route('admin.land')->with('success', 'Data tanah berhasil diperbarui.');
     }

     public function destroyImageLand(Request $request)
     {
         // Debugging
         \Log::info($request->all());
         \Log::info('Request ID: ' . $request->image_id);
         // Temukan gambar berdasarkan ID
         $image = LandImage::findOrFail($request->image_id);

         // Hapus file fisik
         $filePath = storage_path('app/public/' . $image->image_path);
         if (file_exists($filePath)) {
             unlink($filePath);
         }

         // Hapus dari database
         $image->delete();

         return redirect()->back()->with('success', 'Gambar berhasil dihapus.');
         }


     public function destroyLand(Request $request)
     {
         // Debug untuk melihat data yang diterima
         \Log::info($request->id);

         // Ambil data perumahan berdasarkan ID
         $land = Land::findOrFail($request->id);

         // Hapus data
         $land->delete();

         // Redirect dengan pesan sukses
         return redirect('/land')->with('success', 'Berhasil Menghapus Data Tanah');
     }

    // ============ END LAND ================

    // ============ RUMAH ================
    public function indexRumah(Request $request)
{
    // Ambil list semua perumahan untuk dropdown
    $listPerumahan = Perumahan::all();

    // Query untuk mendapatkan data rumah, default menampilkan semua
    $query = Rumah::query();

    // Jika filter perumahan_id ada, tambahkan kondisi ke query
    if ($request->has('perumahan_id') && $request->perumahan_id != '') {
        $query->where('perumahan_id', $request->perumahan_id);
    }

    $rumah = $query->get();

    return view('admin.rumah.index', [
        'rumah' => $rumah,
        'listPerumahan' => $listPerumahan,
    ]);
}

     public function createRumah(){
        $perumahan= Perumahan::all();
        return view('admin.rumah.createRumah', compact('perumahan'));
        // return view('admin.rumah.createRumah');
    }

    public function storeRumah(Request $request)
    {
        $validatedData = $request->validate([

            'no_kavling' => 'required',
            'luas_tanah' => 'nullable',
            'luas_bangunan' => 'nullable',
            'posisi' => 'required',
            'harga' => 'required',
            'perumahan_id' => 'required|numeric',
            'status' => 'required',
        ]);

        Rumah::create($validatedData);
        return redirect('/rumah')->with('success', 'Berhasil Menambahkan Rumah');
    }


    public function editRumah($id)
    {
        // Coba temukan data agent berdasarkan ID
        $rumah = Rumah::find($id);
        $perumahan= Perumahan::all();

        // Jika agent tidak ditemukan, tampilkan pesan error atau redirect
        if (!$rumah) {
            return redirect()->route('admin.agent')->with('error', 'Data Rumah tidak ditemukan');
        }

        // Jika ditemukan, kirim data ke view
        return view('admin.rumah.editRumah', [
            'rumah' => $rumah,
            'perumahan' => $perumahan,
        ]);
    }
    public function destroyRumah(Request $request)
    {
        // Ambil ID dari request
        \Log::info($request->id);

        $rumah = Rumah::findOrFail($request->id);

        // Hapus data
        $rumah->delete();

        // Redirect kembali dengan pesan sukses
        return redirect('/rumah')->with('success', 'Berhasil Menghapus Rumah');
    }
     public function updateRumah(Request $request, $id)
     {
         // Find the agent by id
         $rumah = Rumah::find($id);

         // Update the agent's data
         $rumah->no_kavling = $request->input('no_kavling');
         $rumah->luas_tanah = $request->input('luas_tanah');
         $rumah->luas_bangunan = $request->input('luas_bangunan');
         $rumah->posisi = $request->input('posisi');
         $rumah->harga = $request->input('harga');
         $rumah->perumahan_id = $request->input('perumahan_id');
         $rumah->status = $request->input('status');

         // Save the changes to the database
         $rumah->save();

         // Redirect back or to any other page
         return redirect('/rumah');
     }



    // ============ END RUMAH ================
// ============ KONSUMEN ================
    public function indexKonsumen()
    {
        $konsumen = Konsumen::with('agent')->get();
        // $konsumen = Konsumen::all();
        $user = Auth::user();
        return view('admin.konsumen.index', [
            'konsumen' => $konsumen,
            // 'user' => $user,
        ]);
    }

    public function createKonsumen(){
        $perumahan= Perumahan::all();
        $agent = Agent::all();
        return view('admin.konsumen.createKonsumen', compact('perumahan','agent'));
    }

    public function storeKonsumen(Request $request)
        {
            $validatedData = $request->validate([
                'nama_konsumen' => 'required',
                'no_hp' => 'required',
                'domisili' => 'nullable',
                'email' => 'nullable|email',
                'pekerjaan' => 'nullable',
                'nama_kantor' => 'nullable',
                'perumahan' => 'required',
                'sumber_informasi' => 'required',
                'agent_id' => 'nullable',
            ]);

           // Jika agent_id adalah 'pilih', set ke null
            if ($request->input('agent_id') === 'pilih') {
                $validatedData['agent_id'] = null;
            } else {
                $validatedData['agent_id'] = $request->input('agent_id');
            }

            // Set created_at ke tanggal dari input atau tanggal saat ini jika tidak diisi
            $validatedData['created_at'] = $request->input('tanggal') ? $request->input('tanggal') : Carbon::now();

            try {
                Konsumen::create($validatedData);
                return redirect('/konsumen')->with('success', 'Konsumen berhasil disimpan.');
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.']);
            }
}


    public function destroyKonsumen(Request $request)
    {
        // Ambil ID dari request
        $konsumen = Konsumen::findOrFail($request->id);

        // Hapus data
        $konsumen->delete();

        // Redirect kembali dengan pesan sukses
        return redirect('/konsumen')->with('success', 'Berhasil Menghapus Konsumen');
    }

    public function editKonsumen($id)
    {
        // Coba temukan data konsumen berdasarkan ID
        $konsumen = Konsumen::find($id);
        $rumah = Rumah::find($id);
        $perumahan = Perumahan::all();
        $agent = Agent::all();

        // Jika konsumen tidak ditemukan, tampilkan pesan error atau redirect
        if (!$konsumen) {
            return redirect()->route('admin.konsumen')->with('error', 'Data Konsumen tidak ditemukan');
        }

        // Jika ditemukan, kirim data ke view
        return view('admin.konsumen.editKonsumen', [
            'konsumen' => $konsumen,
            'perumahan' => $perumahan,
            'agent' => $agent,
            'rumah' => $rumah,
        ]);
    }


    public function updateKonsumen(Request $request, $id)
    {
        // Find the agent by id
        $konsumen = konsumen::find($id);

        // Update the agent's data
        $konsumen->nama_konsumen = $request->input('nama_konsumen');
        $konsumen->no_hp = $request->input('no_hp');
        $konsumen->domisili = $request->input('domisili');
        $konsumen->email = $request->input('email');
        $konsumen->pekerjaan = $request->input('pekerjaan');
        $konsumen->nama_kantor = $request->input('nama_kantor');
        $konsumen->perumahan = $request->input('perumahan');
        $konsumen->sumber_informasi = $request->input('sumber_informasi');
        $konsumen->agent_id = $request->input('agent_id');

        // Save the changes to the database
        $konsumen->save();

        // Redirect back or to any other page
        return redirect('/konsumen');
    }
    // ============ END KONSUMEN ================


    // ============ PENAWARAN ================
    public function indexPenawaran()
    {
        $penawaran = Penawaran::with(['agent', 'perumahan', 'rumah'])->get();
        // $konsumen = Konsumen::all();
        $user = Auth::user();
        return view('admin.penawaran.index', compact('penawaran'));
    }

    public function createPenawaran(){
        $perumahan= Perumahan::all();
        $agent = Agent::all();
        return view('admin.penawaran.createPenawaran', compact('perumahan','agent'));
    }

    public function storePenawaran(Request $request)
        {
            $validatedData = $request->validate([
                'nama_konsumen' => 'required',
                'no_hp' => 'required',
                'domisili' => 'nullable',
                'email' => 'nullable|email',
                'pekerjaan' => 'nullable',
                'nama_kantor' => 'nullable',
                'perumahan' => 'required',
                'sumber_informasi' => 'required',
                'agent_id' => 'nullable',
            ]);

           // Jika agent_id adalah 'pilih', set ke null
            if ($request->input('agent_id') === 'pilih') {
                $validatedData['agent_id'] = null;
            } else {
                $validatedData['agent_id'] = $request->input('agent_id');
            }

            // Set created_at ke tanggal dari input atau tanggal saat ini jika tidak diisi
            $validatedData['created_at'] = $request->input('tanggal') ? $request->input('tanggal') : Carbon::now();

            try {
                Konsumen::create($validatedData);
                return redirect('/konsumen')->with('success', 'Konsumen berhasil disimpan.');
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.']);
            }
    }


    public function destroyPenawaran(Request $request)
    {
        // Ambil ID dari request
        $penawaran = Penawaran::findOrFail($request->id);

        // Hapus data
        $penawaran->delete();

        // Redirect kembali dengan pesan sukses
        return redirect('/penawaran')->with('success', 'Berhasil Menghapus Konsumen');
    }
    // ============ END KONSUMEN ================



     // ============ START AGENT  ================

     public function indexAgent()
     {
         $perumahan = Perumahan::all();
         $agents = Agent::all();
         $user = Auth::user();
         return view('admin.agent.index', [
             'agents' => $agents,
             'perumahan' => $perumahan,
             // 'user' => $user,
         ]);
     }

     public function createAgent(){
        $perumahan= Perumahan::all();
        return view('admin.agent.createAgent', compact('perumahan'));
    }

    public function storeAgent(Request $request)
    {
        $validatedData = $request->validate([

            'nama' => 'required',
            'kantor' => 'nullable',
            'tipe' => 'required',
            'no_hp' => 'required',
            'alamat' => 'required',
            'perumahan_id' => 'nullable|array',
            'perumahan_id.*' => 'string|max:255',
        ]);
        if ($request->has('perumahan_id')) {
            $validatedData['perumahan_id'] = json_encode($request->perumahan_id);
        }
        Agent::create($validatedData);
        return redirect('/agent')->with('success', 'Berhasil Menambahkan Agent');
    }


    public function editAgent($id)
    {
        $agent = Agent::find($id);

        if (!$agent) {
            return redirect()->route('admin.agent')->with('error', 'Data Agent tidak ditemukan');
        }

        // Decode JSON perumahan_id
        $agent->perumahan_id = json_decode($agent->perumahan_id, true);

        // Ambil data perumahan berdasarkan ID yang ada di perumahan_id
         $perumahan = Perumahan::all();


        return view('admin.agent.editAgent', [
            'agent' => $agent,
            'perumahan' => $perumahan, // Data perumahan yang cocok
        ]);
    }



    public function updateAgent(Request $request, $id)
    {
        // Validasi data
        $request->validate([
            'nama' => 'required|max:255',
            'tipe' => 'required|string  ',
            'kantor' => 'required|string    ',
            'no_hp' => 'required|max:255',
            'alamat' => 'required|max:255',
            'perumahan_id' => 'required|array',
            'perumahan_id.*' => 'string|max:255',
        ]);

        // Temukan agent berdasarkan id
        $agent = Agent::find($id);

        // Update agent data
        $agent->update([
            'nama' => $request->nama,
            'tipe' => $request->tipe,
            'kantor' => $request->kantor,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'perumahan_id' => json_encode($request->perumahan_id),
        ]);

        // Simpan perubahan
        $agent->save();

        // Redirect kembali ke halaman agent
        return redirect('/agent');
    }



    public function destroyAgent(Request $request)
    {
        // Ambil ID dari request
        $agent = Agent::findOrFail($request->id);

        // Hapus data
        $agent->delete();

        // Redirect kembali dengan pesan sukses
        return redirect('/agent')->with('success', 'Berhasil Menghapus Agent');
    }

      // ============ END AGENT ================


      // ============ START REPORT  ================

      public function indexReport()
      {
        //   $report = Report::all();
          $report = Report::with('konsumen')->get();
          $user = Auth::user();
          return view('admin.report.index', [
              'report' => $report,
              // 'user' => $user,
          ]);
      }

    public function createReport(){
        $user = auth()->user();

        $konsumen = Konsumen::all();
        $username = $user->name;
        return view('admin.report.createReport', compact('konsumen', 'username'));
    }

    public function getKonsumen($id)
    {
        $konsumen = Konsumen::find($id);
        return response()->json([
            'no_hp' => $konsumen->no_hp,
            'perumahan' => $konsumen->perumahan, // pastikan ini diambil dari database
            'sumber_informasi' => $konsumen->sumber_informasi,
            'PIC' => $konsumen->PIC,
        ]);
    }
    public function storeReport(Request $request)
    {


        $validatedData = $request->validate([
            'konsumen_id' => 'required',
            'pic' => 'nullable',
            'follow_up' => 'required',
            'status' => 'required',
            'no_hp' => 'required',
            // 'perumahan' =>   'required',
           'tanggal' => 'required|date|date_format:Y-m-d',
            // 'sumber_informasi' => 'required',
            'alasan' => 'nullable',
            'koresponden' => 'required',

        ]);

        if ($request->filled('tanggal')) {
            $validatedData['tanggal'] = Carbon::parse($request->tanggal)->format('Y-m-d');
        }
        // Cek duplikasi data
        $existingReport = Report::where('konsumen_id', $request->konsumen_id)
            ->where('no_hp', $request->no_hp)
            ->first();

        if ($existingReport) {
            return redirect()->back()->withErrors(['error' => 'Data dengan nama konsumen dan nomor HP yang sama sudah ada.']);
        }
        // Buat laporan dengan data yang disediakan dalam form
        Report::create($validatedData);

        return redirect('/report')->with('success', 'Report berhasil ditambahkan.');
    }

    public function editReport($id)
    {
        $konsumen = Konsumen::all();
        $report = Report::findOrFail($id);

        return view('admin.report.editReport', [
            'report' => $report,
            'konsumen' => $konsumen

        ]);
    }

    public function updateReports(Request $request, $id)
    {
        $validatedData = $request->validate([
            'status' => 'nullable',
            'follow_up' => 'nullable',
            'koresponden' => 'nullable',
            'alasan' => 'nullable',
        ]);

        $report = Report::findOrFail($id);

        // Periksa apakah follow_up telah diisi di formulir
        if (!$request->filled('follow_up')) {
            // Biarkan follow up tetap sama jika tidak diubah di formulir
            $validatedData['follow_up'] = $report->follow_up;
        }

        // Periksa apakah tanggal telah diisi di formulir, dan lakukan perubahan seperti sebelumnya

        $report->update($validatedData);

        // Redirect back or to any other page
        return redirect('/report')->with('success', 'Report berhasil diperbarui.');
    }



    public function addReports($id)
    {
        $user = auth()->user();

        $report = Report::with('konsumen')->findOrFail($id);
        $username = $user->name;

        return view('admin.report.addReport', [
            'report' => $report,
            'konsumen' => $report->konsumen,
            'username' => $username,

        ]);
    }

    public function addedReports(Request $request, $id)
    {
        $validatedData = $request->validate([
            'status' => 'nullable',
            'follow_up' => 'nullable',
            'koresponden' => 'nullable',
            'alasan' => 'nullable',

        ]);

        $report = Report::findOrFail($id);

        // Proses field follow_up
        if ($request->filled('follow_up')) {
            $newFollowUp = $this->incrementFollowUp($report->follow_up);
            $validatedData['follow_up'] = $report->follow_up ? $report->follow_up . "\n" . $newFollowUp : $newFollowUp;
        } else {
            $validatedData['follow_up'] = $report->follow_up;
        }



        // Proses field koresponden
        if ($request->filled('koresponden')) {
            $validatedData['koresponden'] = $report->koresponden ? $report->koresponden . "\n" . $request->koresponden : $request->koresponden;
        } else {
            $validatedData['koresponden'] = $report->koresponden;
        }

        // Proses field status
        if ($request->filled('status')) {
            $validatedData['status'] = $report->status ? $report->status . "\n" . $request->status : $request->status;
        } else {
            $validatedData['status'] = $report->status;
        }

        // Proses field keterangan
        if ($request->filled('alasan')) {
            $validatedData['alasan'] = $report->alasan ? $report->alasan . "\n" . $request->alasan : $request->alasan;
        } else {
            $validatedData['alasan'] = $report->alasan;
        }

        // Tambahkan tanggal hari ini ke field updated
        $validatedData['updated'] = $report->updated ? $report->updated . "\n" . Carbon::now()->toDateString() : Carbon::now()->toDateString();

        // Isi kolom PIC dengan data yang dikirimkan melalui form
        // dan tambahkan nama PIC dari user yang sedang login
        $user = auth()->user();
        $validatedData['pic'] = $report->pic ? $report->pic . "\n" . $user->name : $user->name;

        $report->update($validatedData);

        // Redirect back or to any other page
        return redirect('/report')->with('success', 'Report berhasil diperbarui.');
    }



    private function incrementFollowUp($currentFollowUp)
    {
        if (!$currentFollowUp) {
            return "FU1";
        }

        $followUps = explode("\n", $currentFollowUp);
        $lastFollowUp = end($followUps);

        if (preg_match('/^FU(\d+)$/', $lastFollowUp, $matches)) {
            $currentNumber = (int)$matches[1];
            $nextNumber = $currentNumber + 1;
            // Batasi hingga FU20
            if ($nextNumber > 20) {
                $nextNumber = 20;
            }
            return "FU" . $nextNumber;
        }

        // Default jika tidak sesuai format
        return "FU1";
    }

    public function destroyReport(Request $request)
    {
        // Ambil ID dari request
        $report = Report::findOrFail($request->id);

        // Hapus data
        $report->delete();

        // Redirect kembali dengan pesan sukses
        return redirect('/report')->with('success', 'Berhasil Menghapus Report');
    }

      // ============ END REPORT ================

      public function exportExcel(Request $request)
      {
          $request->validate([
              'export_option' => 'required',
              'month' => 'required_if:export_option,month_year|integer|min:1|max:12',
              'year' => 'required_if:export_option,month_year|integer|min:2000|max:' . date('Y'),
          ]);

          $exportOption = $request->input('export_option');
          $month = $request->input('month');
          $year = $request->input('year');

          if ($exportOption == 'all') {
              $konsumen = Konsumen::all();
          } elseif ($exportOption == 'month_year') {
              $konsumen = Konsumen::whereYear('created_at', $year)
                  ->whereMonth('created_at', $month)
                  ->get();
          } else {
              return redirect()->back()->with('error', 'Opsi ekspor tidak valid.');
          }

          if ($konsumen->isEmpty()) {
              return redirect()->back()->with('error', 'Data tidak tersedia untuk bulan dan tahun yang dipilih.');
          }

          return Excel::download(new ExportKonsum($konsumen), "Konsumen.xlsx");
      }
      public function exportReport(Request $request)
      {
          $request->validate([
              'export_option' => 'required',
              'month' => 'required_if:export_option,month_year|integer|min:1|max:12',
              'year' => 'required_if:export_option,month_year|integer|min:2000|max:' . date('Y'),
          ]);

          $exportOption = $request->input('export_option');
          $month = $request->input('month');
          $year = $request->input('year');
          $fil = null;
          if ($month < 10) {
              $fil = $year . '-0' . $month;
          } else {
              $fil = $year . '-' . $month;
          }
          $report = null; // Initialize $report variable

          if ($exportOption == 'all') {
              $report = Report::all();
          } elseif ($exportOption == 'month_year') {
              $report = Report::where("tanggal", "LIKE", "%{$fil}%")->get();
              // $report = Report::whereYear('tanggal', $year)
              //     ->whereMonth('tanggal', $month)
              //     ->get();
              // $report = Report::where('tanggal', 'LIKE', '%' . $year. '-'. '$month' . '%')->get();
          } else {
              return redirect()->back()->with('error', 'Opsi ekspor tidak valid.');
          }

          if ($report->isEmpty()) {
              // return $report;
              return redirect()->back()->with('error', 'Data tidak tersedia untuk bulan dan tahun yang dipilih.');
          }
          // var_dump($report);

          // return $report;
          return Excel::download(new ExportReport($report), "Report.xlsx");
      }

      // ============ INFO ================

      public function indexInfo()
     {
        //  $info = Info::all();
        $info = Info::with('imagesInfo')->get();
         $user = Auth::user();
         return view('admin.info.index', [
             'info' => $info,
             // 'user' => $user,
         ]);
     }

     public function imagesInfo()
     {
         return $this->hasMany(InfoImage::class);
     }


     public function createInfo(){
         return view('admin.info.createInfo');
     }

     public function showInfo(Info $info)
     {
         $info = Info::with('position')->findOrFail($management->id);
         $perumahan->keunggulan = json_decode($perumahan->keunggulan);
         return view('admin.teacher.showTeacher', compact([
             'management',
         ]));
     }

     public function storeInfo(Request $request)
     {
         $validatedData = $request->validate([
             'images.*' => 'image|file|max:5120|mimes:jpeg,png,jpg,webp',
             'title' => 'required',
             'headline' => 'required',
             'description' => 'required',

         ]);


         // Simpan data perumahan dan ambil objeknya
         $info = Info::create($validatedData);

         // Simpan gambar terkait jika ada
         if ($request->hasFile('images')) {
             foreach ($request->file('images') as $image) {
                 $path = $image->store('foto-info', 'public');
                 InfoImage::create([
                     'info_id' => $info->id, // Gunakan $secondary yang sudah didefinisikan
                     'image_path' => $path,
                 ]);
             }
         }

         return redirect('/info')->with('success', 'Berhasil Menambahkan Data Tanah');
 }



     public function editInfo($id)
     {
         $info = Info::find($id);
         $images = InfoImage::where('info_id', $id)->get();


         return view('admin.info.editInfo', [
             'info' => $info,
             'images' => $images, // Kirim gambar ke view
         ]);
     }

     public function removeImageInfo(Request $request)
     {
         try {
             Log::info('Request diterima:', $request->all());
             $imagePath = $request->input('image');

             // Hapus dari database
             $deleted = InfoImage::where('image_path', $imagePath)->delete();
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


     public function updateInfo(Request $request, $id)
     {
         // Validasi input
         $request->validate([
            'images.*' => 'image|file|max:5120|mimes:jpeg,png,jpg,webp',
            'title' => 'required',
            'headline' => 'required',
            'description' => 'required',
         ]);

         // Ambil data perumahan
         $info = Info::findOrFail($id);

         // Update data utama
         $info->update([
             'title' => $request->title,
             'headline' => $request->headline,
             'description' => $request->description,
         ]);

         // Menangani gambar baru
         if ($request->hasFile('images')) {
             foreach ($request->file('images') as $file) {
                 $path = $file->store('info_images', 'public');
                 InfoImage::create([
                     'info_id' => $info->id,
                     'image_path' => $path,
                 ]);
             }
         }


         // Simpan perubahan
         $info->save();

         return redirect()->route('admin.info')->with('success', 'Data tanah berhasil diperbarui.');
     }

     public function destroyImageInfo(Request $request)
     {
         // Debugging
         \Log::info($request->all());
         \Log::info('Request ID: ' . $request->image_id);
         // Temukan gambar berdasarkan ID
         $image = InfoImage::findOrFail($request->image_id);

         // Hapus file fisik
         $filePath = storage_path('app/public/' . $image->image_path);
         if (file_exists($filePath)) {
             unlink($filePath);
         }

         // Hapus dari database
         $image->delete();

         return redirect()->back()->with('success', 'Gambar berhasil dihapus.');
         }


     public function destroyInfo(Request $request)
     {
         // Debug untuk melihat data yang diterima
         \Log::info($request->id);

         // Ambil data perumahan berdasarkan ID
         $info = Info::findOrFail($request->id);

         // Hapus data
         $info->delete();

         // Redirect dengan pesan sukses
         return redirect('/info')->with('success', 'Berhasil Menghapus Data Info');
     }

    // ============ END INFO ================

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

    public function showTestimony(Testimony $testimony)
    {
        $info = Info::with('position')->findOrFail($management->id);
        $perumahan->keunggulan = json_decode($perumahan->keunggulan);
        return view('admin.teacher.showTeacher', compact([
            'management',
        ]));
    }

    public function storeTestimony(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'image' => 'image|file|max:5120|mimes:jpeg,png,jpg,webp',
            'testimony' => 'required',
        ]);


    // Simpan gambar jika ada
    if ($request->hasFile('image')) {
        $validatedData['image'] = $request->file('image')->store('foto-testimony', 'public');
    }

    // Simpan data ke tabel testimony
    Testimony::create($validatedData);
    return redirect('/testimony')->with('success', 'Berhasil Menambahkan Data Testimony');
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
        $testimony->testimony = $request->testimony;

        // Simpan perubahan
        $testimony->save();

        return redirect()->route('admin.testimony')->with('success', 'Data testimony berhasil diperbarui.');
    }


    public function destroyImageTestimony(Request $request)
    {
        // Debugging
        \Log::info($request->all());
        \Log::info('Request ID: ' . $request->image_id);
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
        \Log::info($request->id);

        // Ambil data perumahan berdasarkan ID
        $testimony = Testimony::findOrFail($request->id);

        // Hapus data
        $testimony->delete();

        // Redirect dengan pesan sukses
        return redirect('/testimony')->with('success', 'Berhasil Menghapus Data Testimony');
    }

   // ============ END INFO ================
}
