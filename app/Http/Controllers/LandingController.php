<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Article;
use Carbon\Carbon;
use App\Models\Ebook;
use App\Models\Employee;
use App\Models\Perumahan;
use App\Models\Secondary;
use App\Models\Rumah;
use App\Models\Penawaran;
use App\Models\Agent;
use App\Models\PerumahanImage;
use App\Models\Konsumen;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class LandingController extends Controller
{

    public function index(Request $request)
    {
        $status = $request->query('status', 'all'); // Default: all
        $todayDate = Carbon::now()->format('Y-m-d');
        $monthDate = Carbon::now()->format('m');

        $totalVisits = Visit::count();
        $todayVisits = Visit::whereDate('visited_at', $todayDate)->count();
        $monthVisits = Visit::whereMonth('visited_at', $monthDate)->count();

        $allPerumahan = Perumahan::orderBy('created_at', 'desc')->get();

        // $secondary = Secondary::orderBy('created_at', 'desc')->get();
        $secondary = Secondary::with('images')->orderBy('created_at', 'desc')->get();

        $perumahanStat = Perumahan::where('status', 'Available')->get();

        $kotas = Perumahan::whereIn('id', function ($query) {
            $query->selectRaw('MAX(id)')
                ->from('perumahan')
                ->groupBy('kota');
        })->orderBy('created_at', 'desc')->get();

        $query = Perumahan::orderBy('created_at', 'desc');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $perumahan = $query->get();

        return view('client.page.index', compact([
            'totalVisits',
            'todayVisits',
            'monthVisits',
            'perumahan',
            'kotas',
            'allPerumahan',
            'perumahanStat',
            'secondary',
        ]));
    }



        public function filterPerumahan(Request $request)
        {
            $status = $request->input('status');
            $perumahan = Perumahan::where('status', $status)->get();

            return response()->json([
                'perumahan' => $perumahan
            ]);
        }


    public function boot()
    {
        View::composer('client.component.NavigationComponent.ProjectDropdown', function ($view) {
            \Log::info('View composer for ProjectDropdown executed');
            $kotas = Perumahan::select('kota')->distinct()->get();
            $view->with('kotas', $kotas);
        });

        View::composer('client.component.NavigationComponent.SecondaryDropdown', function ($view) {
            \Log::info('SecondaryDropdown data: ', Secondary::select('kota')->distinct()->get()->toArray());
            $secondaryKotas = Secondary::select('kota')->distinct()->get();
            dd($secondaryKotas);  // Debug untuk melihat data yang dikembalikan

            $view->with('secondaryKotas', $secondaryKotas);
        });


        View::composer('client.layouts.partials.footer', function ($view) {
            $view->with('perumahan', Perumahan::all());
        });
    }

    public function indexSecondary()
    {
        $secondary = Secondary::all();
        $allPerumahan = Perumahan::orderBy('created_at', 'desc')->get();
        return view('client.component.landing.indexSecondary', [
            'secondary' => $secondary,
            'allPerumahan' => $allPerumahan,
            // 'user' => $user,
        ]);
    }
    public function showPage()
    {
        $kotas = Perumahan::select('kota')->distinct()->get();
        return view('halaman.anda', compact('kotas'));
    }

    public function images()
    {
        return $this->hasMany(PerumahanImage::class);
    }

    public function perumahanAll()
    {
        $perumahan = Perumahan::all();
        View::share('perumahanAll', $perumahan);
    }

    public function secondaryAll()
    {
        $secondary = Secondary::all();
        View::share('secondaryAll', $secondary);
    }


    // public function project(){
    //     return view('client.page.project');
    // }

    // public function showPerumahan($id){
    //     return view('client.page.project',[
    //         'perumahan' => Perumahan::findorFail($id),
    //     ]);
    // }

    // public function showPerumahan($id)
    // {
    //     $perumahan = Perumahan::with('images')->findOrFail($id); // Eager load images


    //     return view('client.page.project', [
    //         'perumahan' => $perumahan,
    //     ]);
    // }
    public function showPerumahan($id)
    {
        // Mengambil data Perumahan beserta gambar
        $perumahan = Perumahan::with('images')->findOrFail($id);
        $allPerumahan = Perumahan::orderBy('created_at', 'desc')->get();
        $kotas = Perumahan::select('kota')->distinct()->get();
        // Logika video jika ada
        $embedUrl = $perumahan->video;
        if (str_contains($perumahan->video, 'youtu.be')) {
            $videoId = last(explode('/', parse_url($perumahan->video, PHP_URL_PATH)));
            $embedUrl = "https://www.youtube.com/embed/{$videoId}";
        } elseif (str_contains($perumahan->video, 'watch?v=')) {
            $embedUrl = str_replace('watch?v=', 'embed/', $perumahan->video);
        }

        return view('client.page.project', [
            'perumahan' => $perumahan,
            'embedUrl' => $embedUrl,
            'allPerumahan' => $allPerumahan,
            'kotas' => $kotas,
        ]);
    }


    public function showProject($kota)
    {
        $perumahan = Perumahan::where('kota', $kota)
        ->with('images')
        ->orderBy('created_at', 'desc')
        ->get(); // Ambil perumahan berdasarkan kota dan urutkan dari yang terbaru

        $allPerumahan = Perumahan::orderBy('created_at', 'desc')->get(); // Urutkan semua perumahan dari yang terbaru

        $kotas = Perumahan::select('kota')->distinct()->get();

        return view('client.component.project.showProject', [
            'perumahan' => $perumahan, // Kirim data perumahan ke view
            'kota' => $kota,
            'allPerumahan' => $allPerumahan,
            'kotas' => $kotas,
        ]);
    }

    public function contact(){
        $allPerumahan = Perumahan::orderBy('created_at', 'desc')->get();
        $kotas = Perumahan::select('kota')->distinct()->get();
        return view('client.page.contact', compact('kotas','allPerumahan'));
    }

    public function about(){
        $allPerumahan = Perumahan::all();
        $kotas = Perumahan::select('kota')->distinct()->get();
        return view('client.page.aboutt', compact('kotas','allPerumahan'));
    }

    public function form($id)
    {
        $allPerumahan = Perumahan::all(); // Ambil semua data Perumahan
        $selectedPerumahan = Perumahan::findOrFail($id); // Data spesifik berdasarkan ID
        // $agents = Agent::all();
        $agents = Agent::whereJsonContains('perumahan_id', $id)->get();

        return view('client.page.form', compact('allPerumahan', 'selectedPerumahan', 'agents'));
    }


    public function storeKonsumen(Request $request, $id)
    {
    $validatedData = $request->validate([
        'nama_konsumen' => 'required',
        'email' => 'nullable|email',
        'no_hp' => 'required',
        'domisili' => 'required',
        'pekerjaan' => 'required',
        'nama_kantor' => 'required',
        'perumahan' => 'required',
        'sumber_informasi' => 'required',
        'agent_id' => 'nullable',
    ]);

        $perumahan = Perumahan::findOrFail($id);

        Konsumen::create($validatedData);

        // Pemberitahuan berhasil
        try {
            Konsumen::create($validatedData);
            return redirect()
                ->route('download.form', ['id' => $perumahan->id])
                ->with('success', 'Data konsumen berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.'])
                ->withInput();
        }
    }


    public function formPenawaran($id)
    {
        $allPerumahan = Perumahan::all();

        // Filter agents berdasarkan perumahan_id (dengan JSON)
        $agents = Agent::whereJsonContains('perumahan_id', $id)->get();

        // Ambil data rumah berdasarkan perumahan_id
        $rumah = Rumah::where('perumahan_id', $id)->orderBy('no_kavling', 'asc')->get();

        // Data perumahan yang dipilih
        $selectedPerumahan = Perumahan::findOrFail($id);

        // Kembalikan data ke view
        return view('client.page.formPenawaran', compact('allPerumahan', 'agents', 'rumah', 'selectedPerumahan'));
    }


    public function storePenawaranKonsumen(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'email' => 'nullable',
            'no_hp' => 'required',
            'domisili' => 'required',
            'pekerjaan' => 'required',
            'nama_kantor' => 'required',
            'sumber_informasi' => 'required',
            'perumahan_id' => 'required',
            'agent_id' => 'nullable',
            'payment' => 'required',
            'income' => 'required',
            'dp' => 'required',
            'rumah_id' => 'required',
        ]);

        try {
            Penawaran::create($validatedData);
            return redirect()
                ->route('dashboard')
                ->with('success', 'Anda telah berhasil mengajukan penawaran.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.'])
                ->withInput();
        }
    }



    public function downloadBrosur($id)
    {
        $brosur = DB::table('perumahan')->where('id', $id)->first();

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
        $pricelist = DB::table('perumahan')->where('id', $id)->first();

        if ($pricelist) {
            $pathToFile = storage_path("app/public/{$pricelist->pricelist}");
            return Response::download($pathToFile);
        } else {
            // Tambahkan logika untuk menangani jika brosur tidak ditemukan
            return redirect()->back()->with('error', 'Pricelist tidak ditemukan');
        }
    }

    public function download($id)
    {
        $allPerumahan = Perumahan::all();
        return view('client.page.downloadForm', [
            'perumahan' => Perumahan::findOrFail($id),
            'allPerumahan' => $allPerumahan
        ]);
    }

    public function show($page)
    {
        // // Logika untuk menentukan halaman
        // $content = view("pages.$page")->render();
        // return response()->json(['content' => $content]);

        // Validasi halaman agar hanya mengizinkan halaman tertentu
        $validPages = ['learnerProfile', 'curriculum', 'achievement', 'activities', 'download'];
        if (!in_array($page, $validPages)) {
            abort(404); // Halaman tidak ditemukan
        }

        if ($page === 'download') {
            $ebook = Ebook::latest()->get();
            return view('client.component.landing.menuComponent.download', compact('ebook'));
        }

        return view("client.component.landing.menuComponent.$page");
    }


    //============== SECONDARY ===============
    public function showSecondary($kota)
    {
        $secondary = Secondary::where('kota', $kota)
            ->with('images')
            ->orderBy('created_at', 'desc')
            ->get();
         $allPerumahan = Perumahan::orderBy('created_at', 'desc')->get();
        $allSecondary = Secondary::orderBy('created_at', 'desc')->get();
        $kotas = Secondary::select('kota')->distinct()->get();


        return view('client.component.secondary.index', [
            'secondary' => $secondary,
            'kota' => $kota,
            'allSecondary' => $allSecondary,
            'kotas' => $kotas,
            'allPerumahan' => $allPerumahan,
        ]);
    }


}
