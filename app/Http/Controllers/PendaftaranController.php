<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Services\SiakadService;
use App\Models\PendaftaranModel;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\PendaftaranStoreRequest;
use App\Http\Requests\PendaftaranUpdateRequest;

class PendaftaranController extends Controller
{
    protected $siakadService;

    public function __construct(SiakadService $siakadService)
    {
        $this->siakadService = $siakadService;
    }

    /**
     * Menampilkan daftar pendaftaran
     */
    public function index(Request $request): View
    {
        $query = PendaftaranModel::with(['user', 'agen']);

        // Filter berdasarkan role user
        if (auth()->user()->hasRole('agen')) {
            $query->where('agen_id', auth()->id());
        }

        // Filter berdasarkan pencarian
        if ($request->has('cari') && $request->cari != '') {
            $search = $request->cari;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('id_calon_mahasiswa', 'like', "%{$search}%")
                    ->orWhere('no_transaksi', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $pendaftaran = $query->latest()->paginate(10);

        return view('sistem.pendaftaran.index', [
            'title' => 'Manajemen Pendaftaran',
            'pendaftaran' => $pendaftaran,
        ]);
    }

    /**
     * Menampilkan form tambah pendaftaran
     */
    public function create(): View
    {
        // Ambil info prodi dan jadwal dari SIAKAD2
        $infoPendaftaran = $this->siakadService->getInfoPendaftaran();

        if (!$infoPendaftaran['success']) {
            return view('sistem.pendaftaran.create', [
                'title' => 'Tambah Pendaftaran Baru',
                'error' => $infoPendaftaran['message'] ?? 'Gagal mengambil data dari SIAKAD2',
                'prodi' => [],
                'jadwal' => null,
            ]);
        }

        return view('sistem.pendaftaran.create', [
            'title' => 'Tambah Pendaftaran Baru',
            'prodi' => $infoPendaftaran['data']['prodi'] ?? [],
            'jadwal' => $infoPendaftaran['data']['jadwal'] ?? null,
        ]);
    }

    /**
     * Menyimpan pendaftaran baru
     */
    public function store(PendaftaranStoreRequest $request): RedirectResponse
    {
        try {
            // Cek ketersediaan jadwal
            $infoPendaftaran = $this->siakadService->getInfoPendaftaran();
            if (!$infoPendaftaran['success'] || !isset($infoPendaftaran['data']['jadwal'])) {
                return back()->withInput()
                    ->with('error', 'Jadwal pendaftaran tidak tersedia. Silakan coba lagi nanti.');
            }

            $jadwal = $infoPendaftaran['data']['jadwal'];
            $prodi = $infoPendaftaran['data']['prodi'][$request->prodi_id] ?? '';

            // Data untuk dikirim ke SIAKAD2
            $dataSiakad = [
                'prodi_id' => $request->prodi_id,
                'tahun' => $jadwal['TAHUN'],
                'gelombang' => $jadwal['GELOMBANG'],
                'biaya' => $jadwal['BIAYA'],
                'kelas' => $request->kelas,
                'nama' => $request->nama_lengkap,
                'email' => $request->email,
                'hp' => $request->nomor_hp,
                'hp2' => $request->nomor_hp2,
                'password' => $request->password,
                'agen_id' => auth()->user()->username,
            ];

            // Kirim ke SIAKAD2
            $response = $this->siakadService->registerCalonMahasiswa($dataSiakad);

            if (!$response['success']) {
                // Simpan sebagai pendaftaran gagal - TAMBAHKAN password_text
                $pendaftaran = PendaftaranModel::create([
                    'user_id' => null, // Belum ada user
                    'agen_id' => auth()->id(),
                    'id_calon_mahasiswa' => '',
                    'username_siakad' => '',
                    'no_transaksi' => '',
                    'prodi_id' => $request->prodi_id,
                    'prodi_nama' => $prodi,
                    'tahun' => $jadwal['TAHUN'],
                    'gelombang' => $jadwal['GELOMBANG'],
                    'biaya' => $jadwal['BIAYA'],
                    'kelas' => $request->kelas,
                    'nama_lengkap' => $request->nama_lengkap,
                    'email' => $request->email,
                    'nomor_hp' => $request->nomor_hp,
                    'nomor_hp2' => $request->nomor_hp2,
                    'password_text' => $request->password, // SIMPAN PASSWORD PLAIN TEXT
                    'status' => 'failed',
                    'keterangan' => $response['message'] ?? 'Gagal terhubung ke SIAKAD2',
                    'response_data' => $response,
                ]);

                return back()->withInput()
                    ->with('error', 'Pendaftaran gagal: ' . ($response['message'] ?? 'Terjadi kesalahan'));
            }

            // Simpan sebagai pendaftaran berhasil - TAMBAHKAN password_text
            $pendaftaran = PendaftaranModel::create([
                'user_id' => null, // Opsional: bisa dibuat user lokal nanti untuk mhs ybs jika diperlukan
                'agen_id' => auth()->id(),
                'id_calon_mahasiswa' => $response['data']['id_calon_mahasiswa'],
                'username_siakad' => $response['data']['username'],
                'no_transaksi' => $response['data']['no_transaksi'],
                'prodi_id' => $request->prodi_id,
                'prodi_nama' => $prodi,
                'tahun' => $jadwal['TAHUN'],
                'gelombang' => $jadwal['GELOMBANG'],
                'biaya' => $response['data']['total_biaya'],
                'kelas' => $request->kelas,
                'nama_lengkap' => $response['data']['nama'],
                'email' => $response['data']['email'],
                'nomor_hp' => $request->nomor_hp,
                'nomor_hp2' => $request->nomor_hp2,
                'password_text' => $request->password, // SIMPAN PASSWORD PLAIN TEXT
                'status' => 'success',
                'keterangan' => 'Pendaftaran berhasil via Agen PMB',
                'response_data' => $response,
                'synced_at' => now(),
            ]);

            return redirect()->route('pendaftaran.index')
                ->with('success', 'Pendaftaran ' . $pendaftaran->nama_lengkap . ' berhasil dibuat.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Gagal menyimpan pendaftaran: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail pendaftaran
     */
    public function show(PendaftaranModel $pendaftaran): View
    {
        // Authorization check
        if (auth()->user()->hasRole('agen') && $pendaftaran->agen_id != auth()->id()) {
            abort(403);
        }

        return view('sistem.pendaftaran.show', [
            'title' => 'Detail Pendaftaran - ' . $pendaftaran->nama_lengkap,
            'pendaftaran' => $pendaftaran,
        ]);
    }

    /**
     * Menampilkan form edit pendaftaran
     */
    public function edit(PendaftaranModel $pendaftaran): View
    {
        // Authorization check
        if (auth()->user()->hasRole('agen') && $pendaftaran->agen_id != auth()->id()) {
            abort(403);
        }

        // Hanya bisa edit pendaftaran yang pending
        if ($pendaftaran->status !== 'pending') {
            abort(403, 'Hanya pendaftaran dengan status pending yang dapat diedit');
        }

        $infoPendaftaran = $this->siakadService->getInfoPendaftaran();
        $prodi = $infoPendaftaran['data']['prodi'] ?? [];

        return view('sistem.pendaftaran.edit', [
            'title' => 'Edit Pendaftaran - ' . $pendaftaran->nama_lengkap,
            'pendaftaran' => $pendaftaran,
            'prodi' => $prodi,
        ]);
    }

    /**
     * Update data pendaftaran
     */
    public function update(PendaftaranUpdateRequest $request, PendaftaranModel $pendaftaran): RedirectResponse
    {
        // Authorization check
        if (auth()->user()->hasRole('agen') && $pendaftaran->agen_id != auth()->id()) {
            abort(403);
        }

        try {
            $pendaftaran->update([
                'prodi_id' => $request->prodi_id,
                'kelas' => $request->kelas,
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'nomor_hp' => $request->nomor_hp,
                'nomor_hp2' => $request->nomor_hp2,
            ]);

            return redirect()->route('pendaftaran.index')
                ->with('success', 'Data pendaftaran ' . $pendaftaran->nama_lengkap . ' berhasil diperbarui.');
        } catch (Exception $e) {
            return back()->withInput()
                ->with('error', 'Gagal memperbarui pendaftaran: ' . $e->getMessage());
        }
    }

    /**
     * Hapus pendaftaran
     */
    public function destroy(PendaftaranModel $pendaftaran): RedirectResponse
    {
        // Authorization check
        if (auth()->user()->hasRole('agen') && $pendaftaran->agen_id != auth()->id()) {
            abort(403);
        }

        try {
            $nama = $pendaftaran->nama_lengkap;
            $pendaftaran->delete();

            return redirect()->route('pendaftaran.index')
                ->with('success', 'Pendaftaran ' . $nama . ' berhasil dihapus.');
        } catch (Exception $e) {
            return back()->with('error', 'Gagal menghapus pendaftaran: ' . $e->getMessage());
        }
    }
}
