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

class AdminSecondaryController extends Controller
{
     // ============ SECONDARY ================

     public function indexSecondary()
     {
         $user = Auth::user();
        if($user->role === 'salesAdmin'){
               $secondary = Secondary::with('imagesSecondary','user')
               ->where('user_id', $user->id)
               ->get();
        }else{

            $secondary = Secondary::with('imagesSecondary','user')->get(); // Eager loading relasi
        }

         $users = User::all();

         return view('admin.secondary.index', [
             'secondary' => $secondary,
             'user' => $user,
             'users' => $users,
         ]);
     }


     public function imagesSecondary()
     {
         return $this->hasMany(SecondaryImage::class);
     }




     public function createSecondary(){
         return view('admin.secondary.createSecondary');
     }


     public function storeSecondary(Request $request)
    {
        $validatedData = $request->validate([
            'images.*' => 'image|file|max:5120|mimes:jpeg,png,jpg,webp',
            'judul' => 'required',
            'available' => 'required',
            'kondisi' => 'required',
            'status' => 'required', // Pastikan status dijual/disewakan ada
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
            'lantai' => 'required',
            'harga' => 'required',
            'lokasi' => 'required',
            'kecamatan' => 'required',
            'kota' => 'required',
            'deskripsi' => 'required',
            'user_id' => 'required',
            'video' => ['nullable', 'url', function ($attribute, $value, $fail) {
                if (!str_contains($value, 'youtube.com') && !str_contains($value, 'youtu.be')) {
                    $fail('URL video harus berasal dari YouTube.');
                }
            }],
        ]);

        // Tentukan kode status (1 untuk dijual, 2 untuk disewakan)
        $statusCode = $request->status === 'Dijual' ? '1' : '2';

        // Ambil nomor urut terakhir
        $lastSecondary = Secondary::latest('id')->first();
        $nextNumber = $lastSecondary ? sprintf('%03d', $lastSecondary->id + 1) : '001';

        // Ambil bulan dan tahun saat ini
        $currentMonth = now()->format('m');
        $currentYear = now()->format('y');

        // Generate kode listing
        $kodeListing = $statusCode . $nextNumber . $currentMonth . $currentYear;

        // Tambahkan kode listing ke data yang divalidasi
        $validatedData['kode_listing'] = $kodeListing;

        // Simpan data perumahan
        $secondary = Secondary::create($validatedData);

         // Jika ada URL video, ubah ke embed URL
        if ($secondary->video) {
            $videoUrl = $secondary->video;

            if (str_contains($videoUrl, 'youtu.be')) {
                $videoId = last(explode('/', parse_url($videoUrl, PHP_URL_PATH)));
                $embedUrl = "https://www.youtube.com/embed/{$videoId}";
            } else {
                $embedUrl = str_replace('watch?v=', 'embed/', $videoUrl);
            }

            // Update properti video dengan URL embed
            $secondary->update(['video' => $embedUrl]);
        }

        // Simpan gambar jika ada
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('foto-secondary', 'public');
                SecondaryImage::create([
                    'secondary_id' => $secondary->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect('/secondary-home')->with('success', 'Berhasil Menambahkan Perumahan');
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
             'kondisi' => 'required',
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
             'lantai' => 'required',
             'harga' => 'required',
             'lokasi' => 'required',
             'kecamatan' => 'required',
             'kota' => 'required',
             'deskripsi' => 'required',
             'user_id' => 'required',
             'video' => ['nullable', 'url', function ($attribute, $value, $fail) {
                if (!str_contains($value, 'youtube.com') && !str_contains($value, 'youtu.be')) {
                    $fail('URL video harus berasal dari YouTube.');
                }
            }],
         ]);

         // Ambil data perumahan
         $secondary = Secondary::findOrFail($id);

         // Update data utama
         $secondary->update([
             'judul' => $request->judul,
             'status' => $request->status,
             'available' => $request->available,
             'kondisi' => $request->kondisi,
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
             'lantai' => $request->lantai,
             'harga' => $request->harga,
             'lokasi' => $request->lokasi,
             'kecamatan' => $request->kecamatan,
             'kota' => $request->kota,
             'deskripsi' => $request->deskripsi,
             'user_id' => $request->user_id,
             'video' => $request->video,
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

         return redirect()->route('admin.secondary-home')->with('success', 'Data perumahan berhasil diperbarui.');
     }

     public function destroyImageSecondary(Request $request)
     {
         // Debugging
         Log::info($request->all());
         Log::info('Request ID: ' . $request->image_id);
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
         Log::info($request->id);

         // Ambil data perumahan berdasarkan ID
         $secondary = Secondary::findOrFail($request->id);

         // Hapus data
         $secondary->delete();

         // Redirect dengan pesan sukses
         return redirect('/secondary-home')->with('success', 'Berhasil Menghapus Perumahan');
     }

     public function updateUserIdSecondary(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $secondary = Secondary::findOrFail($id);
        $secondary->user_id = $request->user_id;
        $secondary->save();

        return redirect()->back()->with('success', 'User berhasil diperbarui');
    }

    // ============ END SECONDARY ================
}
