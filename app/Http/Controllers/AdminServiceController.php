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


class AdminServiceController extends Controller
{


    // ============ SERVICES ================

    public function indexService()
    {
        //  $info = Info::all();
        $service = Service::with('imagesService')->get();
         $user = Auth::user();
         return view('admin.service.index', [
             'service' => $service,
             // 'user' => $user,
         ]);
     }

     public function imagesService()
     {
         return $this->hasMany(ServiceImage::class);
     }


     public function createService(){
         return view('admin.service.createService');
     }

     public function storeService(Request $request)
     {
         $validatedData = $request->validate([
             'images.*' => 'image|file|max:5120|mimes:jpeg,png,jpg,webp',
             'judul' => ' required',
             'short_desc'  => 'required',
             'image' => 'image|file|max:5120|mimes:jpeg,png,jpg,webp',
             'long_desc'  => 'required',
             'no_hp' => 'required',

         ]);


        //  // Simpan data perumahan dan ambil objeknya
        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('banner-service', 'public');
        }

        $service = Service::create($validatedData);
         // Simpan gambar terkait jika ada
         if ($request->hasFile('images')) {
             foreach ($request->file('images') as $image) {
                 $path = $image->store('foto-service', 'public');
                 ServiceImage::create([
                     'service_id' => $service->id, // Gunakan $secondary yang sudah didefinisikan
                     'image_path' => $path,
                 ]);
             }
         }
        //  Service::create($validatedData);
         return redirect('/service-home')->with('success', 'Berhasil Menambahkan Data Services');
    }

    public function editService($id)
    {
        $service = Service::find($id);
        $images = ServiceImage::where('service_id', $id)->get();

        return view('admin.service.editService', [
            'service' => $service,
            'images' => $images,
        ]);
    }


     public function removeImageService(Request $request)
     {
         try {
             Log::service('Request diterima:', $request->all());
             $imagePath = $request->input('image');

             // Hapus dari database
             $deleted = ServiceImage::where('image_path', $imagePath)->delete();
             Log::service('Hasil penghapusan dari database:', ['deleted' => $deleted]);

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


     public function updateService(Request $request, $id)
     {
         // Validasi input
         $request->validate([
            'images.*' => 'image|file|max:5120|mimes:jpeg,png,jpg,webp',
            'judul' => 'required',
            'short_desc' => 'required',
            'no_hp' => 'required',
            'image' => 'image|file|max:5120|mimes:jpeg,png,jpg,webp',
            'long_desc' => 'required',
         ]);

         // Ambil data perumahan
         $service = Service::findOrFail($id);
         if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }

            // Simpan gambar baru
            $imagePath = $request->file('image')->store('banner-service', 'public');
            $service->image = $imagePath;
        }
         // Update data utama
         $service->update([
             'judul' => $request->judul,
             'short_desc' => $request->short_desc,
             'long_desc' => $request->long_desc,
             'no_hp' => $request->no_hp,
         ]);

         // Menangani gambar baru
         if ($request->hasFile('images')) {
             foreach ($request->file('images') as $file) {
                 $path = $file->store('service_images', 'public');
                 ServiceImage::create([
                     'service_id' => $service->id,
                     'image_path' => $path,
                 ]);
             }
         }


         // Simpan perubahan
         $service->save();

         return redirect()->route('admin.service')->with('success', 'Data tanah berhasil diperbarui.');
     }

     public function destroyImageService(Request $request)
     {
         // Debugging
        //  \Log::service($request->all());
        //  \Log::service('Request ID: ' . $request->image_id);
         // Temukan gambar berdasarkan ID
         $image = ServiceImage::findOrFail($request->image_id);

         // Hapus file fisik
         $filePath = storage_path('app/public/' . $image->image_path);
         if (file_exists($filePath)) {
             unlink($filePath);
         }

         // Hapus dari database
         $image->delete();

         return redirect()->back()->with('success', 'Gambar berhasil dihapus.');
         }


         public function destroyService(Request $request)
         {
             // Debug untuk melihat data yang diterima
            //  \Log::service($request->id);

             // Ambil data perumahan berdasarkan ID
             $service = Service::findOrFail($request->id);

             // Hapus data
             $service->delete();

             // Redirect dengan pesan sukses
             return redirect('/service-home')->with('success', 'Berhasil Menghapus Data Service');
         }


    // ============ END SERVICE ================
}
