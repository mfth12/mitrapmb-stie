@extends('components.theme.back')

@section('container')
  <div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <h2 class="page-title">Manajemen Pendaftaran</h2>
          <div class="page-pretitle">Gerbang pendaftaran calon mahasiswa baru melalui agen PMB</div>
        </div>
        <div class="col-4 col-md-auto ms-auto d-print-none">
          @can('pendaftaran_create')
            <a href="{{ route('pendaftaran.create') }}" class="btn btn-primary me-1">
              <i class="ti ti-plus fs-2 me-2"></i>
              Buat Pendaftaran
            </a>
          @endcan
          @can('pendaftaran_create')
            <a href="#" class="btn btn-default">
              <i class="ti ti-cloud-down fs-2 me-2"></i>
              Sinkronisasi
            </a>
          @endcan
        </div>
      </div>
    </div>
  </div>

  <div class="page-body">
    <div class="container-xl">
      {{-- Stats Cards Baru --}}
      <div class="row row-cards mb-4 mt-0">
        <div class="col-sm-6 col-lg-3">
          <div class="card card-sm">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-auto">
                  <span class="bg-x text-white avatar">
                    <i class="ti ti-file-isr fs-1"></i>
                  </span>
                </div>
                <div class="col">
                  <div class="h2 mb-0">{{ $pendaftaran->total() }}</div>
                  <div class="text-secondary">Total Pendaftaran</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="card card-sm">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-auto">
                  <span class="bg-green text-white avatar">
                    <i class="ti ti-cloud-check fs-1"></i>
                  </span>
                </div>
                <div class="col">
                  <div class="h2 mb-0">{{ $pendaftaran->where('status', 'success')->count() }}</div>
                  <div class="text-secondary">Berhasil</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="card card-sm">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-auto">
                  <span class="bg-warning text-white avatar">
                    <i class="ti ti-progress-alert fs-1"></i>
                  </span>
                </div>
                <div class="col">
                  <div class="h2 mb-0">{{ $pendaftaran->where('status', 'pending')->count() }}</div>
                  <div class="text-secondary">Pending</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="card card-sm">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-auto">
                  <span class="bg-danger text-white avatar">
                    <i class="ti ti-cloud-off fs-1"></i>
                  </span>
                </div>
                <div class="col">
                  <div class="h2 mb-0">{{ $pendaftaran->where('status', 'failed')->count() }}</div>
                  <div class="text-secondary">Gagal</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- <div class="card mb-4">
        <div class="card-body">
          <form method="GET" class="row g-3 mb-4">
            <div class="col-md-5">
              <input type="text" name="cari" class="form-control"
                placeholder="Cari nama, email, ID calon mahasiswa..." value="{{ request('cari') }}">
            </div>
            <div class="col-md-4">
              <select name="status" class="form-select">
                <option value="">Semua Status</option>
                <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Berhasil</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Gagal</option>
              </select>
            </div>
            <div class="col-md-3">
              <button type="submit" class="btn btn-default w-100">
                <i class="ti ti-filter me-1"></i>
                Filter
              </button>
            </div>
          </form>
        </div>
      </div> --}}

      <div class="card">
        <div class="card">
          <div class="card-header">
            <div class="row w-full">
              <div class="col">
                <h3 class="card-title mb-0">Daftar Calon Mahasiswa</h3>
                <p class="text-secondary m-0">Berikut data calon mahasiswa yang telah didaftarkan</p>
              </div>
              <div class="col-md-auto col-sm-12">
                <div class="ms-auto d-flex flex-wrap btn-list">
                  <form method="GET" class="row g-3">
                    <div class="col">
                      <select name="status" class="form-select mt-2 mt-md-0">
                        <option value="">Semua Status</option>
                        <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Berhasil</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Gagal</option>
                      </select>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          {{-- Tabel pendaftaran --}}
          <div class="table-responsive" style="padding: 1rem">
            <table id="pendaftaran-table" class="table table-vcenter table-bordered table-md table-hover">
              <thead>
                <tr>
                  <th class="w-1">No</th>
                  <th>Calon Mahasiswa</th>
                  <th>Program Studi</th>
                  <th>Akademik</th>
                  <th>Biaya</th>
                  <th>Status</th>
                  <th>Agen Sekolah</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                {{-- Data akan diisi oleh DataTables --}}
              </tbody>
            </table>
          </div>
          {{-- end --}}
        </div>
      </div>
    </div>
  </div>
@endsection


@section('modals')
  {{-- Modal Kredensial --}}
  <div class="modal modal-blur fade" id="credentials-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            <i class="ti ti-key fs-2 me-2 text-success"></i>
            Kredensial Login PMB SIAKAD2
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="alert alert-info">
            <div class="d-flex">
              <div>
                <i class="ti ti-info-circle fs-2 me-2"></i>
              </div>
              <div>
                <small>Berikan kredensial ini ke calon mahasiswa untuk login ke <a
                    href="{{ env('URL_SERVICE_SIAKAD') }}/login" target="_blank">PMB SIAKAD2</a></small>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Username</label>
            <div class="input-group">
              <input type="text" class="form-control font-monospace" id="modal-username" readonly value="">
              <button class="btn btn-default" type="button" onclick="copyModalUsername()">
                <i class="ti ti-copy fs-3"></i>
              </button>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="input-group">
              <input type="password" class="form-control font-monospace" id="modal-password" readonly value="">
              <button class="btn btn-default" type="button" onclick="toggleModalPassword()">
                <i class="ti ti-eye fs-3" id="modal-password-icon"></i>
              </button>
              <button class="btn btn-default" type="button" onclick="copyModalPassword()">
                <i class="ti ti-copy fs-3"></i>
              </button>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" data-bs-dismiss="modal">
            Oke
          </button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('style')
  <style>
    .avatar-text {
      font-weight: 600;
      text-transform: uppercase;
    }

    .font-monospace {
      font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
    }

    /* Toast di tengah atas */
    .custom-toast {
      top: 20px;
      left: 50%;
      transform: translateX(-50%) translateY(-30px);
      opacity: 0;
      transition: all 0.4s ease;
      z-index: 1060;
    }

    /* Saat muncul */
    .custom-toast.showing {
      transform: translateX(-50%) translateY(0);
      opacity: 1;
    }

    /* Saat hilang ke bawah */
    .custom-toast.hiding {
      transform: translateX(-50%) translateY(30px);
      opacity: 0;
    }

    /* Gaya untuk loading di DataTables */
    .dataTables_processing {
      margin-top: 4rem;
      /* background: rgba(255, 255, 255, 0.9); */
      /* position: absolute; */
      /* top: 50%; */
      /* left: 50%; */
      /* transform: translate(-50%, -50%); */
      /* padding: 50px; */
      /* border: 1px solid #ccc; */
      /* z-index: 9999; */
    }
  </style>

  {{-- DataTables CSS --}}
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
@endsection

@section('js_atas')
  {{-- kosong --}}
@endsection

@section('js_bawah')
  {{-- DEPENDENSI UNTUK PAGE DASBOR --}}
  {{-- <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/libs/apexcharts/dist/apexcharts.min.js"></script> --}}
  {{-- <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/libs/jsvectormap/dist/jsvectormap.min.js"></script> --}}
  {{-- <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/libs/jsvectormap/dist/maps/world.js"></script> --}}
  {{-- <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/libs/jsvectormap/dist/maps/world-merc.js"></script> --}}
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
  {{-- TAMBAHAN JS UNTUK PAGE DASBOR --}}
  {{-- @vite(['resources/js/pages/...']) --}}
  {{-- KOMPONEN INKLUD --}}
  @include('components.back.konfig-tampilan', ['floating' => false])


  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Inisialisasi DataTables
      let table = $('#pendaftaran-table').DataTable({
        processing: true, // Tampilkan proses loading
        serverSide: true, // Aktifkan server-side processing
        responsive: false, // Aktifkan responsif
        stateSave: true,
        searchDelay: 500,
        ajax: {
          url: "{{ route('pendaftaran.data') }}", // Ganti dengan route yang akan kita buat untuk data
          type: 'GET',
          data: function(d) {
            // Kirim parameter filter ke server
            d.cari = $('input[name="cari"]').val();
            d.status = $('select[name="status"]').val();
          }
        },
        columns: [{
            data: 'DT_RowIndex',
            name: 'pendaftaran_id',
            orderable: true,
            searchable: false,
            className: 'text-muted text-center'
          },
          {
            data: 'calon_mahasiswa',
            name: 'nama_lengkap'
          },
          {
            data: 'prodi',
            name: 'prodi_nama'
          },
          {
            data: 'akademik',
            name: 'tahun'
          },
          {
            data: 'biaya',
            name: 'biaya'
          },
          {
            data: 'status_badge',
            name: 'status'
          },
          {
            data: 'agen_id',
            name: 'agen_id'
          },
          {
            data: 'aksi',
            name: 'aksi',
            orderable: false,
            searchable: false,
            className: 'text-center'
          }
        ],
        columnDefs: [{
            targets: [6],
            orderable: false
          } // Kolom No dan Aksi tidak bisa diurutkan
        ],
        pageLength: 25,
        lengthMenu: [
          [10, 25, 50, 100, -1],
          [10, 25, 50, 100, "Semua"]
        ], //jumlah data yang ditampilkan
        order: [
          [0, 'desc']
        ], // Urutkan berdasarkan kolom tahun (indeks 0) secara descending
        language: {
          url: '/data/datatables-id.json' // Bahasa Indonesia
        },
      });

      // Trigger ulang pencarian saat filter diubah
      $('input[name="cari"], select[name="status"]').on('keyup change', function() {
        table.draw();
      });

      // Delete confirmation (gunakan event delegation karena elemen di-load oleh DataTables)
      $(document).on('click', '.delete-btn', function() {
        const userName = $(this).data('name');
        const url = $(this).data('url');

        showDeleteConfirmation({}, `pendaftaran ${userName}`).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: url,
              type: 'POST',
              data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                '_method': 'DELETE'
              },
              success: function(response) {
                table.ajax.reload(); // Reload tabel setelah penghapusan
                // Gunakan Toast.fire untuk pesan sukses
                Swal.fire({
                  icon: 'success',
                  title: response.success || 'Pendaftaran berhasil dihapus.'
                });
              },
              error: function(xhr) {
                let msg = 'Gagal menghapus pendaftaran.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                  msg = xhr.responseJSON.message;
                }
                // Gunakan Toast.fire untuk pesan error
                Swal.fire({
                  icon: 'error',
                  title: msg
                });
              }
            });
          }
        });
      });
    });

    // Fungsi untuk menampilkan kredensial
    function showCredentials(username, password) {
      document.getElementById('modal-username').value = username;
      document.getElementById('modal-password').value = password;

      // Reset ke state awal
      document.getElementById('modal-password').type = 'password';
      document.getElementById('modal-password-icon').className = 'ti ti-eye fs-2';

      // Show modal menggunakan Bootstrap 5 (Tabler)
      const modalElement = document.getElementById('credentials-modal');
      modalElement.show();
    }

    // Toggle show/hide password di modal
    function toggleModalPassword() {
      const passwordField = document.getElementById('modal-password');
      const passwordIcon = document.getElementById('modal-password-icon');

      if (passwordField.type === 'password') {
        passwordField.type = 'text';
        passwordIcon.className = 'ti ti-eye-off fs-2';
      } else {
        passwordField.type = 'password';
        passwordIcon.className = 'ti ti-eye fs-2';
      }
    }

    // Copy username dari modal - GUNAKAN iziToast
    function copyModalUsername() {
      const field = document.getElementById('modal-username');
      field.select();
      field.setSelectionRange(0, 99999);

      navigator.clipboard.writeText(field.value).then(function() {
        showToast('Username berhasil disalin!', 'success');
      }).catch(function() {
        document.execCommand('copy');
        showToast('Username berhasil disalin!', 'success');
      });
    }

    // Copy password dari modal - GUNAKAN iziToast
    function copyModalPassword() {
      const field = document.getElementById('modal-password');
      field.select();
      field.setSelectionRange(0, 99999);

      navigator.clipboard.writeText(field.value).then(function() {
        showToast('Password berhasil disalin!', 'success');
      }).catch(function() {
        document.execCommand('copy');
        showToast('Password berhasil disalin!', 'success');
      });
    }
  </script>
@endsection
