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

class AdminInfoController extends Controller
{
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

         return redirect('/info-home')->with('success', 'Berhasil Menambahkan Data Tanah');
    }

    public function editInfo($id)
    {
        $info = Info::find($id);
        $images = InfoImage::where('info_id', $id)->get();

        return view('admin.info.editInfo', [
            'info' => $info,
            'images' => $images,
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
         Log::info($request->all());
         Log::info('Request ID: ' . $request->image_id);
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
         Log::info($request->id);

         // Ambil data perumahan berdasarkan ID
         $info = Info::findOrFail($request->id);

         // Hapus data
         $info->delete();

         // Redirect dengan pesan sukses
         return redirect('/info-home')->with('success', 'Berhasil Menghapus Data Info');
     }

    // ============ END INFO ================

}
