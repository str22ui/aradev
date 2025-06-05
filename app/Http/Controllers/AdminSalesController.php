<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Perumahan;

use Illuminate\Http\Request;

class AdminSalesController extends Controller
{

    public function indexSales()
    {
        $perumahan = Perumahan::all();
        $sales = User::where('role', 'sales')->get();

        return view('admin.sales.index', [
            'sales' => $sales,
            'perumahan' => $perumahan,
            // 'user' => $user,
        ]);
    }

    public function createSales(){
        $perumahan= Perumahan::all();
        return view('admin.sales.createSales', compact('perumahan'));
    }

    public function storeSales(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required',
            'perumahan_id' => 'nullable|array',
            'perumahan_id.*' => 'string|max:255',

        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

         if ($request->has('perumahan_id')) {
        $validatedData['perumahan_id'] = json_encode($request->perumahan_id);
        }

        User::create($validatedData);

        return redirect('/sales-home')->with('success', 'Berhasil Menambahkan Data User');
   }

   public function editSales($id)
   {
       $sales = User::find($id);
        // Decode JSON perumahan_id
        $sales->perumahan_id = json_decode($sales->perumahan_id, true);

        // Ambil data perumahan berdasarkan ID yang ada di perumahan_id
        $perumahan = Perumahan::all();
       return view('admin.sales.editSales', [
           'sales' => $sales,
           'perumahan' => $perumahan,

       ]);
   }


    public function updateSales(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'nullable',
            'role' => 'required',
            'perumahan_id' => 'required|array',
            'perumahan_id.*' => 'string|max:255',
        ]);

        // Ambil data perumahan
        $sales = User::findOrFail($id);

        // Update data utama
        $sales->update([
            'name' => $request->name,
            'email' => $request->email,
            // 'password' => Hash::make($request->password),
            'password' => $request->filled('password') ? Hash::make($request->password) : $sales->password,
            'role' => $request->role,
            'perumahan_id' => json_encode($request->perumahan_id),
        ]);

        // Simpan perubahan
        $sales->save();

        return redirect()->route('admin.sales')->with('success', 'Data User berhasil diperbarui.');
    }

    public function destroySales(Request $request)
    {
        // Debug untuk melihat data yang diterima
        \Log::info($request->id);

        // Ambil data perumahan berdasarkan ID
        $sales = User::findOrFail($request->id);

        // Hapus data
        $sales->delete();

        // Redirect dengan pesan sukses
        return redirect('/sales-home')->with('success', 'Berhasil Menghapus Data User');
    }
}
