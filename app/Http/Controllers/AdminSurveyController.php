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

class AdminSurveyController extends Controller
{
    // ============ SURVEY ================
     public function indexSurvey()
    {
        $user = Auth::user();

        if ($user->role === 'sales') {
            $survey = Survey::with('agent')
                ->where('user_id', $user->id)
                ->get();
        } else {
            $survey = Survey::with('agent')->get();
        }

        $users = User::all();
        return view('admin.survey.index', [
            'survey' => $survey,
            'users' => $users,
        ]);
    }

      public function createSurvey(){
        $perumahan= Perumahan::all();
        $agent = Agent::all();
        $reseller = Reseller::all();
        $sales = User::where('role', 'sales')->get();
        return view('admin.survey.createSurvey', compact('perumahan','agent', 'reseller','sales'));
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
            'user_id' => 'nullable',
        ]);

        if ($request->input('agent_id') === 'pilih') {
            $validatedData['agent_id'] = null;
        } else {
            $validatedData['agent_id'] = $request->input('agent_id');
        }

        try {
            Survey::create($validatedData);

            $konsumenData = $validatedData;
            unset($konsumenData['tanggal_janjian'], $konsumenData['waktu_janjian']);

            Konsumen::create($konsumenData);

            // Redirect ke halaman /survey setelah berhasil
            return redirect('/survey')->with('success', 'Survey dan data konsumen berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data.']);
        }
    }




      public function destroySurvey(Request $request)
      {
          // Ambil ID dari request
          $survey = Survey::findOrFail($request->id);

          // Hapus data
          $survey->delete();

          // Redirect kembali dengan pesan sukses
          return redirect('/survey')->with('success', 'Berhasil Menghapus Konsumen');
      }

      public function editSurvey($id)
      {
          // Coba temukan data konsumen berdasarkan ID
          $survey = Survey::find($id);
          $rumah = Rumah::find($id);
          $perumahan = Perumahan::all();
          $agent = Agent::all();
          $reseller = Reseller::all();

          // Jika konsumen tidak ditemukan, tampilkan pesan error atau redirect
          if (!$survey) {
              return redirect()->route('admin.survey')->with('error', 'Data Konsumen tidak ditemukan');
          }

          // Jika ditemukan, kirim data ke view
          return view('admin.survey.editSurvey', [
              'survey' => $survey,
              'perumahan' => $perumahan,
              'agent' => $agent,
              'rumah' => $rumah,
              'reseller' => $reseller,
          ]);
      }


      public function updateSurvey(Request $request, $id)
      {
          // Find the agent by id
          $survey = Survey::find($id);

          // Update the agent's data
          $survey->nama_konsumen = $request->input('nama_konsumen');
          $survey->no_hp = $request->input('no_hp');
          $survey->domisili = $request->input('domisili');
          $survey->email = $request->input('email');
          $survey->pekerjaan = $request->input('pekerjaan');
          $survey->nama_kantor = $request->input('nama_kantor');
          $survey->perumahan = $request->input('perumahan');
          $survey->tanggal_janjian = $request->input('tanggal_janjian');
          $survey->waktu_janjian = $request->input('waktu_janjian');
          $survey->sumber_informasi = $request->input('sumber_informasi');
          $survey->agent_id = $request->input('agent_id');
          $survey->reseller_id = $request->input('reseller_id');
          $survey->user_id = $request->input('user_id');

          // Save the changes to the database
          $survey->save();

          // Redirect back or to any other page
          return redirect('/survey');
      }

    public function updateUserIdSurvey(Request $request, $id)
        {
            $request->validate([
                'user_id' => 'required|exists:users,id',
            ]);

            $survey = Survey::findOrFail($id);
            $survey->user_id = $request->user_id;
            $survey->save();

            return redirect()->back()->with('success', 'User berhasil diperbarui');
        }


      // ============ END SURVEY ================
}
