<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Article;
use Carbon\Carbon;
use App\Models\Ebook;
use App\Models\Employee;
use App\Models\Perumahan;
use App\Models\Secondary;
use App\Models\Land;
use App\Models\Info;
use App\Models\Service;
use App\Models\Testimony;
use App\Models\Rumah;
use App\Models\Penawaran;
use App\Models\Wishlist;
use App\Models\Agent;
use App\Models\Reseller;
use App\Models\PerumahanImage;
use App\Models\Konsumen;
use App\Models\Survey;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class LandingController extends Controller
{



    // =================== START LANDING ===================
    public function index(Request $request)
    {
        $status = $request->query('status', 'all'); // Default: all
        $todayDate = Carbon::now()->format('Y-m-d');
        $monthDate = Carbon::now()->format('m');

        $totalVisits = Visit::count();
        $todayVisits = Visit::whereDate('visited_at', $todayDate)->count();
        $monthVisits = Visit::whereMonth('visited_at', $monthDate)->count();

        $allPerumahan = Perumahan::orderBy('created_at', 'desc')->get();


        // $secondary = Secondary::with('imagesSecondary')->orderBy('created_at', 'desc')->take(6)->get();
        $kodeListing = $request->query('kode_listing');

        $secondaryQuery = Secondary::with('imagesSecondary')->orderBy('created_at', 'desc');

        $kotasSecondary = Secondary::select('kota')->distinct()->get();

        $kotaLand = Land::select('lokasi')->distinct()->get();

        $wishlist = Wishlist::where('approval','tampilkan')->take(5)->get();

        if (!empty($kodeListing)) {
            $secondaryQuery->where('kode_listing', 'like', "%$kodeListing%");
        }

        $secondary = $secondaryQuery->take(6)->get();

        $perumahanStat = Perumahan::where('status', 'Available')
        ->orderBy('created_at', 'desc') // Mengurutkan berdasarkan tanggal terbaru
        ->get();

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
            'kotasSecondary',
            'kotaLand',
            'wishlist',
        ]));
    }

    public function search(Request $request)
    {
        $kodeListing = $request->query('kode_listing');

        $secondary = Secondary::where('kode_listing', 'like', "%$kodeListing%")
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($secondary);
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

        View::composer('client.component.NavigationComponent.secondaryDropdown', function ($view) {
            \Log::info('View composer for ProjectDropdown executed');
            $kotasSecondary = Secondary::select('kota')->distinct()->get();
            $view->with('kotasSecondary', $kotasSecondary);
        });

        View::composer('client.layouts.partials.footer', function ($view) {
            $view->with('perumahan', Perumahan::all());
        });
    }


    // =================== END LANDING ===================

    // =================== START SECONDARY ===================


     public function indexSecondary(Request $request)
    {
        $kodeListing = $request->query('kode_listing');

        $secondaryQuery = Secondary::with('imagesSecondary')->orderBy('created_at', 'desc');

        if (!empty($kodeListing)) {
            $secondaryQuery->where('kode_listing', 'like', "%$kodeListing%");
        }

        $secondary = $secondaryQuery->get();

        // $secondary = Secondary::with('imagesSecondary')->orderBy('created_at', 'desc')->get();
        $allPerumahan = Perumahan::all();
        $kotas = Perumahan::select('kota')->distinct()->get();
        $kotasSecondary = Secondary::select('kota')->distinct()->get();
        $kotaLand = Land::select('lokasi')->distinct()->get();

        return view('client.component.secondary.indexSecondary', compact('secondary', 'allPerumahan','kotas','kotasSecondary','kotaLand'));

    }

    public function kotaSecondary($kota)
    {
        $secondary = Secondary::where('kota', $kota)
        ->with('imagesSecondary')
        ->orderBy('created_at', 'desc')
        ->get(); // Ambil secondary berdasarkan kota dan urutkan dari yang terbaru

        $allPerumahan = Perumahan::orderBy('created_at', 'desc')->get(); // Urutkan semua perumahan dari yang terbaru
        $allSecondary = Secondary::orderBy('created_at', 'desc')->get(); // Urutkan semua secondary dari yang terbaru

        $kotas = Perumahan::select('kota')->distinct()->get();
        $kotasSecondary = Secondary::select('kota')->distinct()->get();
        $kotaLand = Land::select('lokasi')->distinct()->get();

        return view('client.component.secondary.kotaSecondary', [
            'secondary' => $secondary, // Kirim data perumahan ke view
            'kota' => $kota,
            'allPerumahan' => $allPerumahan,
            'allSecondary' => $allSecondary,
            'kotas' => $kotas,
            'kotasSecondary' => $kotasSecondary,
            'kotaLand' => $kotaLand,
        ]);
    }



     public function showSecondary($id)
    {
        // Mengambil data Perumahan beserta gambar
        $secondary = Secondary::with('imagesSecondary')->findOrFail($id);
        $allPerumahan = Perumahan::all();
        $kotas = Perumahan::select('kota')->distinct()->get();
        $kotasSecondary = Secondary::select('kota')->distinct()->get();
        $kotaLand = Land::select('lokasi')->distinct()->get();
        $embedUrl = $secondary->video;
        if (str_contains($secondary->video, 'youtu.be')) {
            $videoId = last(explode('/', parse_url($secondary->video, PHP_URL_PATH)));
            $embedUrl = "https://www.youtube.com/embed/{$videoId}";
        } elseif (str_contains($secondary->video, 'watch?v=')) {
            $embedUrl = str_replace('watch?v=', 'embed/', $secondary->video);
        }

        return view('client.component.secondary.showSecondary', compact('secondary', 'allPerumahan','kotas','kotasSecondary','kotaLand','embedUrl'));

    }


    // =================== END SECONDARY ===================


    // =================== START LAND ===================
    public function indexLand(Request $request)
    {
        $search = $request->query('query');

        $secondaryQuery = Land::with('imagesLand')->orderBy('created_at', 'desc');

        if (!empty($search)) {
            $secondaryQuery->where(function ($query) use($search){
                $query->where('judul','like',"%$search%")
                ->orWhere('lokasi','like',"%$search%")
                ->orWhere('kecamatan','like',"%$search%")
                ->orWhere('kota','like',"%$search%");
            });
        }

        $land = $secondaryQuery->get();

        // $land = Land::all();
        $allPerumahan = Perumahan::orderBy('created_at', 'desc')->get();
        $kotas = Perumahan::select('kota')->distinct()->get();
        $kotasSecondary = Secondary::select('kota')->distinct()->get();
        $kotaLand = Land::select('lokasi')->distinct()->get();

        return view('client.component.land.indexLand', compact('land', 'allPerumahan', 'kotas','kotasSecondary','kotaLand'));
    }


    public function showLand($id)
    {
        // Mengambil data Perumahan beserta gambar
        $land = Land::with('imagesLand')->findOrFail($id);
        $allPerumahan = Perumahan::orderBy('created_at', 'desc')->get();
        $kotas = Perumahan::select('kota')->distinct()->get();
        $kotasSecondary = Secondary::select('kota')->distinct()->get();
        $kotaLand = Land::select('lokasi')->distinct()->get();
        $embedUrl = $land->video;
        if (str_contains($land->video, 'youtu.be')) {
            $videoId = last(explode('/', parse_url($land->video, PHP_URL_PATH)));
            $embedUrl = "https://www.youtube.com/embed/{$videoId}";
        } elseif (str_contains($land->video, 'watch?v=')) {
            $embedUrl = str_replace('watch?v=', 'embed/', $land->video);
        }

        return view('client.component.land.showLand', compact('land','allPerumahan', 'kotas','kotasSecondary','kotaLand','embedUrl'));

    }

    public function kotaLand($lokasi)
    {
        $land = Land::where('lokasi', $lokasi)
        ->with('imagesLand')
        ->orderBy('created_at', 'desc')
        ->get(); // Ambil secondary berdasarkan kota dan urutkan dari yang terbaru

        $allPerumahan = Perumahan::orderBy('created_at', 'desc')->get(); // Urutkan semua perumahan dari yang terbaru
        $allLand = Land::orderBy('created_at', 'desc')->get(); // Urutkan semua secondary dari yang terbaru

        $kotas = Perumahan::select('kota')->distinct()->get();
        $kotasSecondary = Secondary::select('kota')->distinct()->get();
        $kotaLand = Land::select('lokasi')->distinct()->get();

        return view('client.component.land.kotaLand', [
            'land' => $land, // Kirim data perumahan ke view
            'lokasi' => $lokasi,
            'allPerumahan' => $allPerumahan,
            'kotas' => $kotas,
            'kotasSecondary' => $kotasSecondary,
            'kotaLand' => $kotaLand,
        ]);
    }

    // =================== END LAND ===================

    // =================== START SERVICES ===================

    public function services(){
        $allPerumahan = Perumahan::all();
        $kotas = Perumahan::select('kota')->distinct()->get();
        $kotasSecondary = Secondary::select('kota')->distinct()->get();
        $kotaLand = Land::select('lokasi')->distinct()->get();
        $service = Service::all();
        return view('client.page.service', compact('kotas','allPerumahan','kotasSecondary','kotaLand', 'service'));
    }

    public function showService($id)
    {
        // Mengambil data Perumahan beserta gambar
        $service = Service::with('imagesService')->findOrFail($id);
        $allPerumahan = Perumahan::all();
        $kotas = Perumahan::select('kota')->distinct()->get();
        $kotasSecondary = Secondary::select('kota')->distinct()->get();
        $kotaLand = Land::select('lokasi')->distinct()->get();

        return view('client.component.service.showService', compact('service', 'allPerumahan','kotas','kotasSecondary','kotaLand'));

    }

    // =================== END SERVICES ===================

    // =================== START INFO ===================
    public function indexInfo()
    {
        $info = Info::all();
        $allPerumahan = Perumahan::orderBy('created_at', 'desc')->get();
        $kotas = Perumahan::select('kota')->distinct()->get();
        $kotasSecondary = Secondary::select('kota')->distinct()->get();
        $kotaLand = Land::select('lokasi')->distinct()->get();

        return view('client.component.info.indexInfo', compact('info', 'allPerumahan', 'kotas','kotasSecondary','kotaLand'));
    }

    public function showInfo($id)
    {
        $info= Info::findOrFail($id);
        $allPerumahan = Perumahan::orderBy('created_at', 'desc')->get();
        $kotas = Perumahan::select('kota')->distinct()->get();
        $kotasSecondary = Secondary::select('kota')->distinct()->get();
        $kotaLand = Land::select('lokasi')->distinct()->get();

        return view('client.component.info.show', compact('info','allPerumahan','kotas','kotasSecondary','kotaLand'));
    }

    // =================== END INFO ===================

    // =================== START TESTIMONY ===================
    public function indexTestimony()
    {
        // $testimony = Testimony::all();
        $testimony = Testimony::orderBy('created_at', 'desc')->get();
        $allPerumahan = Perumahan::orderBy('created_at', 'desc')->get();
        $kotas = Perumahan::select('kota')->distinct()->get();
        $kotasSecondary = Secondary::select('kota')->distinct()->get();
        $kotaLand = Land::select('lokasi')->distinct()->get();

        return view('client.component.testimony.indexTestimony', compact('testimony', 'allPerumahan', 'kotas','kotasSecondary','kotaLand'));

    }
    // =================== END TESTIMONY ===================


    public function showPage()
    {
        $kotas = Perumahan::select('kota')->distinct()->get();
        $kotasSecondary = Secondary::select('kota')->distinct()->get();
        return view('halaman.anda', compact('kotas','kotasSecondary'));
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

    public function showPerumahan($id)
    {
        // Mengambil data Perumahan beserta gambar
        $perumahan = Perumahan::with('images')->findOrFail($id);
        $allPerumahan = Perumahan::orderBy('created_at', 'desc')->get();
        $kotas = Perumahan::select('kota')->distinct()->get();
        $kotasSecondary = Secondary::select('kota')->distinct()->get();
        $kotaLand = Land::select('lokasi')->distinct()->get();
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
            'kotasSecondary' => $kotasSecondary,
            'kotaLand' => $kotaLand,
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
        $kotasSecondary = Secondary::select('kota')->distinct()->get();
        $kotaLand = Land::select('lokasi')->distinct()->get();

        return view('client.component.project.showProject', [
            'perumahan' => $perumahan, // Kirim data perumahan ke view
            'kota' => $kota,
            'allPerumahan' => $allPerumahan,
            'kotas' => $kotas,
            'kotasSecondary' => $kotasSecondary,
            'kotaLand' => $kotaLand,
        ]);
    }

    public function contact(){
        $allPerumahan = Perumahan::orderBy('created_at', 'desc')->get();
        $kotas = Perumahan::select('kota')->distinct()->get();
        $kotasSecondary = Secondary::select('kota')->distinct()->get();
        $kotaLand = Land::select('lokasi')->distinct()->get();

        return view('client.page.contact', compact('kotas','allPerumahan','kotasSecondary','kotaLand'));
    }

    public function about(){
        $allPerumahan = Perumahan::all();
        $kotas = Perumahan::select('kota')->distinct()->get();
        $kotasSecondary = Secondary::select('kota')->distinct()->get();
        $kotaLand = Land::select('lokasi')->distinct()->get();

        return view('client.page.aboutt', compact('kotas','allPerumahan','kotasSecondary','kotaLand'));
    }

    public function form($id)
    {
        $allPerumahan = Perumahan::all(); // Ambil semua data Perumahan
        $selectedPerumahan = Perumahan::findOrFail($id); // Data spesifik berdasarkan ID
        // $agents = Agent::all();
        $agents = Agent::whereJsonContains('perumahan_id', $id)->get();
        $reseller = Reseller::all();

        return view('client.page.form', compact('allPerumahan', 'selectedPerumahan', 'agents', 'reseller'));
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
        'reseller_id' => 'nullable',
    ]);

        $perumahan = Perumahan::findOrFail($id);

        // Konsumen::create($validatedData);

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
        $kotasSecondary = Secondary::select('kota')->distinct()->get();

        // Filter agents berdasarkan perumahan_id (dengan JSON)
        $agents = Agent::whereJsonContains('perumahan_id', $id)->get();
        $reseller = Reseller::all();

        // Ambil data rumah berdasarkan perumahan_id
        $rumah = Rumah::where('perumahan_id', $id)->orderBy('no_kavling', 'asc')->get();

        // Data perumahan yang dipilih
        $selectedPerumahan = Perumahan::findOrFail($id);

        // Kembalikan data ke view
        return view('client.page.formPenawaran', compact('allPerumahan', 'agents', 'rumah', 'selectedPerumahan', 'reseller', 'kotasSecondary'));
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
            'reseller_id' => 'nullable',
            'payment' => 'required',
            'income' => 'required',
            'dp' => 'required',
            'harga_pengajuan' => 'required',
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


    // =================== START WISHLIST ===================

    public function wishlist(){
        $allPerumahan = Perumahan::orderBy('created_at', 'desc')->get();
        $kotas = Perumahan::select('kota')->distinct()->get();
        $kotasSecondary = Secondary::select('kota')->distinct()->get();
        $kotaLand = Land::select('lokasi')->distinct()->get();
        $wishlist = Wishlist::all();
        return view('client.page.wishlist', compact('kotas','allPerumahan','kotasSecondary','kotaLand','wishlist'));
    }
    public function storeWishlist(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'no_hp' => 'required',
            'domisili' => 'nullable',
            'permintaan' => 'required',
            'jenis' => 'required',
            'lokasi' => 'required',
            'spesifik_lokasi' => 'required',
            'harga_budget' => 'required',
            'keterangan' => 'required',
        ]);

        // Set default approval "Sembunyikan"
        $validatedData['approval'] = 'Sembunyikan';

        Wishlist::create($validatedData);
        return redirect('/')->with('success', 'Berhasil Menambahkan Wishlist');
    }


    public function formWishlist()
    {
        $allPerumahan = Perumahan::all();
        return view('client.page.formWishlist', compact('allPerumahan'));
    }
    // =================== END WISHLIST ===================


    //==================== SURVEY ====================
    public function formSurvey($id)
    {
        $allPerumahan = Perumahan::all(); // Ambil semua data Perumahan

        $selectedPerumahan = Perumahan::findOrFail($id); // Data spesifik berdasarkan ID
        // $agents = Agent::all();
        $agents = Agent::whereJsonContains('perumahan_id', $id)->get();
        $reseller = Reseller::all();

        return view('client.page.formSurvey', compact('allPerumahan', 'selectedPerumahan', 'agents','reseller'));
    }


    public function storeSurvey(Request $request)
    {
        $validatedData = $request->validate([
            'nama_konsumen' => 'required',
            'no_hp' => 'required',
            'domisili' => 'nullable',
            'email' => 'nullable|email',
            'pekerjaan' => 'nullable',
            'nama_kantor' => 'nullable',
            'perumahan' => 'required',
            'tanggal_janjian' => 'required|date',
            'waktu_janjian' => 'required',
            'sumber_informasi' => 'required',
            'agent_id' => 'nullable',
            'reseller_id' => 'nullable',
        ]);

        // Jika agent_id adalah 'pilih', set ke null
        if ($request->input('agent_id') === 'pilih') {
            $validatedData['agent_id'] = null;
        } else {
            $validatedData['agent_id'] = $request->input('agent_id');
        }

        try {
            // Simpan data ke tabel survey
            Survey::create($validatedData);

            // Persiapkan data untuk tabel konsumen
            $konsumenData = $validatedData;
            unset($konsumenData['tanggal_janjian'], $konsumenData['waktu_janjian']); // Hapus kolom yang tidak ada di tabel konsumen

            // Simpan data ke tabel konsumen
            Konsumen::create($konsumenData);

            return redirect()->back()->with('success', 'Survey dan data konsumen berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data.']);
        }
    }

    //==================== END SURVEY ====================

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



}
