<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Land;
use App\Models\LandImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;


class AdminLandController extends Controller
{
     // ============ LAND ================

     public function indexLand()
     {
         $user = Auth::user();

         if($user->role === 'salesAdmin'){
               $land = Land::with('imagesLand','user')
               ->where('user_id', $user->id)
               ->get();
        }else{
             $land = Land::with('imagesLand','user')->get();
        }
        $users = User::all();

        return view('admin.land.index', [
             'land' => $land,
             'user' => $user,
             'users' => $users,
         ]);
     }



     public function imagesLand()
     {
         return $this->hasMany(LandImage::class);
     }


     public function createLand(){
         return view('admin.land.createLand');
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
             'user_id' => 'required',
             'video' => ['nullable', 'url', function ($attribute, $value, $fail) {
                if (!str_contains($value, 'youtube.com') && !str_contains($value, 'youtu.be')) {
                    $fail('URL video harus berasal dari YouTube.');
                }
            }],

         ]);


         // Simpan data perumahan dan ambil objeknya
         $land = Land::create($validatedData);
          // Jika ada URL video, ubah ke embed URL
        if ($land->video) {
            $videoUrl = $land->video;

            if (str_contains($videoUrl, 'youtu.be')) {
                $videoId = last(explode('/', parse_url($videoUrl, PHP_URL_PATH)));
                $embedUrl = "https://www.youtube.com/embed/{$videoId}";
            } else {
                $embedUrl = str_replace('watch?v=', 'embed/', $videoUrl);
            }

            // Update properti video dengan URL embed
            $land->update(['video' => $embedUrl]);
        }
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

         return redirect('/land-home')->with('success', 'Berhasil Menambahkan Data Tanah');
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
             'user_id' => 'required',
             'video' => ['nullable', 'url', function ($attribute, $value, $fail) {
                if (!str_contains($value, 'youtube.com') && !str_contains($value, 'youtu.be')) {
                    $fail('URL video harus berasal dari YouTube.');
                }
            }],
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
             'video' => $request->video,
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
         Log::info($request->all());
         Log::info('Request ID: ' . $request->image_id);
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
         Log::info($request->id);

         // Ambil data perumahan berdasarkan ID
         $land = Land::findOrFail($request->id);

         // Hapus data
         $land->delete();

         // Redirect dengan pesan sukses
         return redirect('/land-home')->with('success', 'Berhasil Menghapus Data Tanah');
     }

    public function updateUserIdLand(Request $request, $id)
        {
            $request->validate([
                'user_id' => 'required|exists:users,id',
            ]);

            $land = Land::findOrFail($id);
            $land->user_id = $request->user_id;
            $land->save();

            return redirect()->back()->with('success', 'User berhasil diperbarui');
        }

    // ============ END LAND ================
}
