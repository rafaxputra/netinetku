<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\User;
use App\Models\Paket;
use App\Models\Tagihan;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PelangganExport;
use Illuminate\Support\Facades\Log;

class PelangganController extends Controller
{


    public function index(Request $request)
    {
        $cari = $request->input('cari');

        $users = User::with(['pelanggan', 'pelanggan.paket'])
            ->where('role', 'pelanggan');

        if ($cari) {
            $users->where(function ($query) use ($cari) {
                $query->where('name', 'like', '%' . $cari . '%')
                    ->orWhere('email', 'like', '%' . $cari . '%')
                    ->orWhereHas('pelanggan', function ($query) use ($cari) {
                        $query->where('alamat', 'like', '%' . $cari . '%')
                            ->orWhere('no_hp', 'like', '%' . $cari . '%');
                    });
            });
        }

        $users = $users->paginate(10);


        return view('pelanggan.index', compact('users'));
    }


    public function create()
    {
        $users = User::where('role', 'pelanggan')->get();
        $paketList = Paket::all();
        return view('pelanggan.create', compact('users', 'paketList'));

    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'alamat' => 'required|string',
            'no_hp' => 'required|string',
            'tanggal_pendaftaran' => 'required|date',
            'paket_id' => 'required|exists:tb_paket,id',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        // Buat data user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'pelanggan', // Default role sebagai pelanggan
        ]);

        // Tambahkan data pelanggan
        Pelanggan::create([
            'user_id' => $user->id,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'tanggal_pendaftaran' => $request->tanggal_pendaftaran,
            'paket_id' => $request->paket_id,
            'status' => $request->status,
        ]);

        // Create a new tagihan (bill) for the customer
        $tanggal_jatuh_tempo = now()->parse($request->tanggal_pendaftaran)->addMonth();
        Tagihan::create([
            'pelanggan_id' => $user->pelanggan->id,
            'paket_id' => $request->paket_id,
            'tanggal_jatuh_tempo' => $tanggal_jatuh_tempo,
            'tanggal' => $request->tanggal_pendaftaran,
            'status' => 'belum lunas', // Default status for new bills
        ]);

        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil ditambahkan.');
    }


    public function edit($user_id)
    {
        // Cari data pelanggan berdasarkan user_id di tabel pelanggan
        $pelanggan = Pelanggan::where('user_id', $user_id)->firstOrFail();

        // Ambil data user yang sesuai dengan user_id untuk edit data user
        $user = User::findOrFail($user_id);

        // Ambil semua data paket untuk dropdown paket
        $paketList = Paket::all();

        // Return view pelanggan.edit dengan data pelanggan, user, dan paketList
        return view('pelanggan.edit', compact('pelanggan', 'user', 'paketList'));
    }


    public function update(Request $request, $user_id)
    {

        // Ambil data pelanggan berdasarkan user_id
        $pelanggan = Pelanggan::where('user_id', $user_id)->firstOrFail();
        // Validasi input dari form
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $pelanggan->user_id,
            'password' => 'nullable|min:8',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:15',
            'tanggal_pendaftaran' => 'required|date',
            'paket_id' => 'required|exists:tb_paket,id',
            'status' => 'required|in:aktif,nonaktif',
        ]);




        // Update data di tabel pelanggan
        $pelanggan->update([
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'tanggal_pendaftaran' => $request->tanggal_pendaftaran,
            'paket_id' => $request->paket_id,
            'status' => $request->status,
        ]);

        // Update data di tabel users
        $user = User::findOrFail($user_id);
        $user->name = $request->name;
        $user->email = $request->email;

        // Jika password diisi, update password
        if (!empty($request->password)) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        // Redirect dengan pesan sukses
        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();
        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil dihapus.');
    }

    public function exportExcel()
    {
        $date = now()->format('Y-m-d');
        return Excel::download(new PelangganExport, "data_pelanggan_{$date}.xlsx");
    }
}
