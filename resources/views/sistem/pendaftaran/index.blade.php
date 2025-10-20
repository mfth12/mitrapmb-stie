@extends('components.theme.back')

@section('container')
  <div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <h2 class="page-title">Manajemen Pendaftaran PMB</h2>
          <div class="page-pretitle">Gerbang pendaftaran calon mahasiswa baru melalui agen PMB</div>
        </div>
        <div class="col-auto ms-auto d-print-none">
          @can('pendaftaran_create')
            <a href="{{ route('pendaftaran.create') }}" class="btn btn-primary">
              <i class="ti ti-plus fs-2 me-1"></i>
              Buat Pendaftaran
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
      <div class="card">
        <div class="card-body">

          {{-- Form filter --}}
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


          {{-- Tabel pendaftaran --}}
          <div class="table-responsive">
            <table class="table table-vcenter table-bordered table-striped table-hover">
              <thead>
                <tr>
                  <th class="w-1">No</th>
                  <th>Calon Mahasiswa</th>
                  <th>Program Studi</th>
                  <th>Akademik</th>
                  <th>Biaya</th>
                  <th>Status</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($pendaftaran as $daftar)
                  <tr>
                    <td class="text-muted">
                      {{ $loop->iteration + ($pendaftaran->currentPage() - 1) * $pendaftaran->perPage() }}</td>
                    <td>
                      <div class="d-flex align-items-center">
                        <div class="avatar avatar-sm me-3 bg-blue-lt">
                          <span class="avatar-text">{{ substr($daftar->nama_lengkap, 0, 2) }}</span>
                        </div>
                        <div>
                          <div class="font-weight-medium">
                            <a href="{{ route('pendaftaran.show', $daftar) }}" class="text-reset link-hover-underline">
                              {{ $daftar->nama_lengkap }}
                            </a>
                          </div>
                          <div class="text-muted small">
                            <i class="ti ti-mail me-1"></i>{{ $daftar->email }}
                          </div>
                          @if ($daftar->id_calon_mahasiswa)
                            <div class="text-muted small">
                              <i class="ti ti-id me-1"></i>{{ $daftar->id_calon_mahasiswa }}
                            </div>
                          @endif
                        </div>
                      </div>
                    </td>
                    <td>
                      <div class="font-weight-medium">{{ $daftar->prodi_nama }}</div>
                      <div class="text-muted small">Kelas: {{ $daftar->nama_kelas }}</div>
                    </td>
                    <td>
                      <div class="font-weight-medium">{{ $daftar->tahun }}/{{ $daftar->gelombang }}</div>
                      <div class="text-muted small">{{ $daftar->created_at->format('d/m/Y H:i') }}</div>
                    </td>
                    <td>
                      <div class="font-weight-medium">{{ $daftar->biaya_formatted }}</div>
                    </td>
                    <td>
                      {!! $daftar->status_badge !!}
                    </td>
                    <td class="text-center">
                      <div class="btn-list justify-content-center">
                        <a href="{{ route('pendaftaran.show', $daftar) }}" class="btn btn-sm btn-default" title="Detail"
                          data-bs-toggle="tooltip" data-bs-placement="top">
                          <i class="ti ti-eye fs-3 me-1"></i>
                          Detail
                        </a>
                        @can('pendaftaran_edit')
                          @if ($daftar->status === 'pending')
                            <a href="{{ route('pendaftaran.edit', $daftar) }}" class="btn btn-sm btn-default"
                              title="Edit" data-bs-toggle="tooltip" data-bs-placement="top">
                              <i class="ti ti-edit fs-3"></i>
                              {{-- Edit --}}
                            </a>
                          @endif
                        @endcan
                        @if ($daftar->password_text && $daftar->username_siakad)
                          <a href="#"
                            onclick="showCredentials('{{ $daftar->username_siakad }}', '{{ $daftar->password_text }}')"
                            class="btn btn-sm btn-default text-success d-none d-sm-inline-block" data-bs-toggle="modal"
                            data-bs-target="#credentials-modal" title="Kredensial" data-bs-toggle="tooltip"
                            data-bs-placement="top">
                            <i class="ti ti-key fs-3"></i>
                          </a>
                        @endif
                        @can('pendaftaran_delete')
                          <button type="button" class="btn btn-sm btn-default text-danger delete-btn" title="Hapus"
                            data-bs-toggle="tooltip" data-bs-placement="top" data-name="{{ $daftar->nama_lengkap }}"
                            data-url="{{ route('pendaftaran.destroy', $daftar) }}">
                            <i class="ti ti-trash fs-3"></i>
                            {{-- Hapus --}}
                          </button>
                        @endcan
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="7" class="text-center py-4">
                      <div class="empty">
                        <div class=" mb-2">
                          <i class="ti ti-users fs-1"></i>
                        </div>
                        <p class="empty-title">Tidak ada data pendaftaran</p>
                        <p class="empty-subtitle text-muted">
                          Mulai dengan menambahkan pendaftaran baru
                        </p>
                        @can('pendaftaran_create')
                          <div class="empty-action">
                            <a href="{{ route('pendaftaran.create') }}" class="btn btn-primary">
                              <i class="ti ti-plus fs-2 me-1"></i>
                              Buat
                            </a>
                          </div>
                        @endcan
                      </div>
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          {{-- Pagination --}}
          @if ($pendaftaran->hasPages())
            <div class="card-footer d-flex align-items-center">
              <p class="m-0 text-muted">
                Menampilkan <span>{{ $pendaftaran->firstItem() }}</span> sampai
                <span>{{ $pendaftaran->lastItem() }}</span> dari
                <span>{{ $pendaftaran->total() }}</span> data
              </p>
              <ul class="pagination m-0 ms-auto">
                {{ $pendaftaran->links('vendor.pagination.tabler') }}
              </ul>
            </div>
          @endif
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
                <small>Berikan kredensial ini ke calon mahasiswa untuk login ke PMB SIAKAD2</small>
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
              <button class="btn btn-default text-success" type="button" onclick="copyModalPassword()">
                <i class="ti ti-copy fs-3"></i>
              </button>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" data-bs-dismiss="modal">
            <i class="ti ti-check fs-2 me-1"></i>
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
  </style>
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
  {{-- TAMBAHAN JS UNTUK PAGE DASBOR --}}
  {{-- @vite(['resources/js/pages/...']) --}}
  {{-- KOMPONEN INKLUD --}}
  @include('components.back.konfig-tampilan', ['floating' => false])


  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // // Initialize tooltips
      // var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
      // var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
      //   return new bootstrap.Tooltip(tooltipTriggerEl)
      // });

      // Delete confirmation
      document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
          const userName = this.getAttribute('data-name');
          const url = this.getAttribute('data-url');

          showDeleteConfirmation(() => {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = url;
            form.innerHTML = `
                        @csrf
                        @method('DELETE')
                    `;
            document.body.appendChild(form);
            form.submit();
          }, `pendaftaran ${userName}`);
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
