<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Services\SiakadService;
use App\Models\PendaftaranModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Yajra\DataTables\Facades\DataTables;
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
     * Menyediakan data untuk DataTables
     */
    public function data(Request $request): JsonResponse
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

        // Gunakan Yajra DataTables untuk mengolah query
        return DataTables::eloquent($query)
            ->addIndexColumn() // Kolom DT_RowIndex
            ->addColumn('calon_mahasiswa', function ($row) {
                $html = '<div class="d-flex align-items-center">
                        <div class="avatar avatar-sm me-3 bg-blue-lt">
                          <span class="avatar-text">' . substr($row->nama_lengkap, 0, 2) . '</span>
                        </div>
                        <div>
                          <div class="font-weight-medium">
                            <a href="' . route('pendaftaran.show', $row) . '" class="text-reset link-hover-underline">
                              ' . $row->nama_lengkap . '
                            </a>
                          </div>
                          <div class="text-muted small">
                            <i class="ti ti-mail me-1"></i>' . $row->email . '
                          </div>';
                if ($row->id_calon_mahasiswa) {
                    $html .= '<div class="text-muted small">
                            <i class="ti ti-id me-1"></i>' . $row->id_calon_mahasiswa . '
                          </div>';
                }
                $html .= '</div></div>';
                return $html;
            })
            ->addColumn('prodi', function ($row) {
                return '<div class="font-weight-medium">S1-' . $row->prodi_nama . '</div>
                    <div class="text-muted small">Kelas: ' . $row->nama_kelas . '</div>';
            })
            ->addColumn('akademik', function ($row) {
                return '<div class="font-weight-medium">' . $row->tahun . '/' . $row->gelombang . '</div>
                    <div class="text-muted small">' . $row->created_at->format('d/m/Y H:i') . '</div>';
            })
            ->addColumn('biaya', function ($row) {
                return '<div class="font-weight-medium">' . $row->biaya_formatted . '</div>';
            })
            ->addColumn('status_badge', function ($row) {
                return $row->status_badge;
            })
            ->addColumn('aksi', function ($row) {
                $html = '<div class="btn-list justify-content-center">
                        <a href="' . route('pendaftaran.show', $row) . '" class="btn btn-sm btn-default" title="Detail"
                          data-bs-toggle="tooltip" data-bs-placement="top">
                          <i class="ti ti-eye fs-3 me-1"></i>
                          Detail
                        </a>';

                // Edit Button
                if (auth()->user()->can('pendaftaran_edit') && $row->status === 'pending') {
                    $html .= '<a href="' . route('pendaftaran.edit', $row) . '" class="btn btn-sm btn-default"
                              title="Edit" data-bs-toggle="tooltip" data-bs-placement="top">
                              <i class="ti ti-edit fs-3"></i>
                          </a>';
                }

                // Credential Button
                if ($row->password_text && $row->username_siakad) {
                    $html .= '<a href="#"
                            onclick="showCredentials(\'' . addslashes($row->username_siakad) . '\', \'' . addslashes($row->password_text) . '\')"
                            class="btn btn-sm btn-default text-success d-none d-sm-inline-block" data-bs-toggle="modal"
                            data-bs-target="#credentials-modal" title="Kredensial" data-bs-toggle="tooltip"
                            data-bs-placement="top">
                            <i class="ti ti-key fs-3"></i>
                          </a>';
                }

                // Delete Button
                if (auth()->user()->can('pendaftaran_delete')) {
                    $html .= '<button type="button" class="btn btn-sm btn-default text-danger delete-btn" title="Hapus"
                            data-bs-toggle="tooltip" data-bs-placement="top" data-name="' . addslashes($row->nama_lengkap) . '"
                            data-url="' . route('pendaftaran.destroy', $row) . '">
                            <i class="ti ti-trash fs-3"></i>
                          </button>';
                }

                $html .= '</div>';
                return $html;
            })
            ->rawColumns(['calon_mahasiswa', 'prodi', 'akademik', 'biaya', 'status_badge', 'aksi']) // Kolom yang berisi HTML
            ->make(true);
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

        $pendaftaran = $query->latest()->paginate(15);

        return view('sistem.pendaftaran.index', [
            'title' => 'Manajemen Pendaftaran',
            'pendaftaran' => $pendaftaran,
        ]);
    }

    /**
     * Menampilkan form buat pendaftaran
     */
    public function create(): View
    {
        // Ambil info prodi dan jadwal dari PMB SIAKAD2
        $infoPendaftaran = $this->siakadService->getInfoPendaftaran();
        $kelasList = PendaftaranModel::daftarKelas();

        if (!$infoPendaftaran['success']) {
            return view('sistem.pendaftaran.create', [
                'title' => 'Buat Pendaftaran',
                'error' => $infoPendaftaran['message'] ?? 'Gagal mengambil data dari PMB SIAKAD2',
                'prodi' => [],
                'jadwal' => null,
            ]);
        }

        return view('sistem.pendaftaran.create', [
            'title' => 'Buat Pendaftaran',
            'prodi' => $infoPendaftaran['data']['prodi'] ?? [],
            'jadwal' => $infoPendaftaran['data']['jadwal'] ?? null,
            'kelasList' => $kelasList
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
            $biayadiscount = $jadwal['BIAYA'] - 100000;

            // Data untuk dikirim ke PMB SIAKAD2
            $dataSiakad = [
                'prodi_id' => $request->prodi_id,
                'tahun' => $jadwal['TAHUN'],
                'gelombang' => $jadwal['GELOMBANG'],
                'biaya' => $biayadiscount,
                'kelas' => $request->kelas,
                'nama' => $request->nama_lengkap,
                'email' => $request->email,
                'hp' => $request->nomor_hp,
                'hp2' => $request->nomor_hp2,
                'password' => $request->password,
                'agen_id' => auth()->user()->username,
                'agen_nama' => auth()->user()->name,
                'agen_asalsma' => auth()->user()->asal_sekolah,
            ];

            // Kirim ke PMB SIAKAD2
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
                    'keterangan' => $response['message'] ?? 'Gagal terhubung ke PMB SIAKAD2',
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
                'keterangan' => 'Pendaftaran berhasil via ' . konfigs('NAMA_SISTEM') . '. Diskon formulir pendaftaran berhasil diterapkan sebesar Rp 100.000.',
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
        $kelas = PendaftaranModel::daftarKelas();

        return view('sistem.pendaftaran.edit', [
            'title' => 'Edit Pendaftaran - ' . $pendaftaran->nama_lengkap,
            'pendaftaran' => $pendaftaran,
            'prodi' => $prodi,
            'kelas' => $kelas,
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
