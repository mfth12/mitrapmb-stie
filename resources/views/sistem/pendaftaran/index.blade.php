@extends('components.theme.back')

@section('container')
  <div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <h2 class="page-title">Manajemen Pendaftaran</h2>
          <div class="page-pretitle">Semua pendaftaran calon mahasiswa</div>
        </div>
        <div class="col-auto ms-auto d-print-none">
          @can('pendaftaran_create')
            <a href="{{ route('pendaftaran.create') }}" class="btn btn-primary">
              <i class="ti ti-plus fs-2 me-1"></i>
              Tambah Pendaftaran
            </a>
          @endcan
        </div>
      </div>
    </div>
  </div>

  <div class="page-body">
    <div class="container-xl">
      <div class="card">
        <div class="card-body my-2">
          {{-- Form filter --}}
          <form method="GET" class="row g-3 mb-4">
            <div class="col-md-6">
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
            <div class="col-md-2">
              <button type="submit" class="btn btn-default w-100">
                <i class="ti ti-filter me-1"></i>
                Filter
              </button>
            </div>
          </form>

          {{-- Tabel pendaftaran --}}
          <div class="table-responsive">
            <table class="table table-vcenter table-bordered table-striped">
              <thead>
                <tr>
                  <th>ID Calon Mhs</th>
                  <th>Nama Lengkap</th>
                  <th>Program Studi</th>
                  <th>Tahun/Gelombang</th>
                  <th>Biaya</th>
                  <th>Status</th>
                  <th>Tanggal Daftar</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($pendaftaran as $daftar)
                  <tr>
                    <td>
                      <code>{{ $daftar->id_calon_mahasiswa ?: '-' }}</code>
                    </td>
                    <td>
                      <strong>{{ $daftar->nama_lengkap }}</strong>
                      <br>
                      <small class="text-muted">{{ $daftar->email }}</small>
                    </td>
                    <td>{{ $daftar->prodi_nama }}</td>
                    <td>
                      {{ $daftar->tahun }}/{{ $daftar->gelombang }}
                      <br>
                      {{-- <small class="text-muted">Kelas: {{ $daftar->kelas }}</small> --}}
                      <small class="text-muted">Kelas: {{ $daftar->nama_kelas }}</small>
                    </td>
                    <td>{{ $daftar->biaya_formatted }}</td>
                    <td>{!! $daftar->status_badge !!}</td>
                    <td>{{ $daftar->created_at->format('d/m/Y H:i') }}</td>
                    <td class="text-center" style="width: 1%;">
                      <div class="btn-list justify-content-center flex-nowrap">
                        <a href="{{ route('pendaftaran.show', $daftar) }}" class="btn btn-sm btn-default" title="Detail">
                          Detail
                        </a>
                        @if ($daftar->password_text && $daftar->username_siakad)
                          <button class="btn btn-sm btn-default"
                            onclick="showCredentials('{{ $daftar->username_siakad }}', '{{ $daftar->password_text }}')">
                            <i class="ti ti-key me-1"></i>
                            Lihat
                          </button>
                        @else
                          <span class="text-muted">-</span>
                        @endif
                        @can('pendaftaran_edit')
                          @if ($daftar->status === 'pending')
                            <a href="{{ route('pendaftaran.edit', $daftar) }}" class="btn btn-sm btn-default"
                              title="Edit">
                              Edit
                            </a>
                          @endif
                        @endcan
                        @can('pendaftaran_delete')
                          <form action="{{ route('pendaftaran.destroy', $daftar) }}" method="POST"
                            class="d-inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-default text-danger delete-btn" title="Hapus"
                              data-name="{{ $daftar->nama_lengkap }}">
                              Hapus
                            </button>
                          </form>
                        @endcan
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="8" class="text-center text-muted">Tidak ada data pendaftaran</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          {{-- Pagination --}}
          @if ($pendaftaran->hasPages())
            <div class="mt-4">
              <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="text-muted">
                  Menampilkan
                  <strong>{{ $pendaftaran->firstItem() }}</strong> -
                  <strong>{{ $pendaftaran->lastItem() }}</strong>
                  dari
                  <strong>{{ $pendaftaran->total() }}</strong>
                  data
                </div>

                <div>
                  {{ $pendaftaran->links('vendor.pagination.tabler') }}
                </div>
              </div>
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
          <h5 class="modal-title">Kredensial Login SIAKAD2</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Username</label>
            <div class="input-group">
              <input type="text" class="form-control" id="modal-username" readonly value="">
              <button class="btn btn-outline-secondary" type="button" onclick="copyModalUsername()">
                <i class="ti ti-copy"></i>
              </button>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="input-group">
              <input type="password" class="form-control" id="modal-password" readonly value="">
              <button class="btn btn-outline-secondary" type="button" onclick="toggleModalPassword()">
                <i class="ti ti-eye" id="modal-password-icon"></i>
              </button>
              <button class="btn btn-outline-primary" type="button" onclick="copyModalPassword()">
                <i class="ti ti-copy"></i>
              </button>
            </div>
          </div>
          <div class="alert alert-info">
            <div class="d-flex">
              <div>
                <i class="ti ti-info-circle me-2"></i>
              </div>
              <div>
                <small>Berikan kredensial ini ke calon mahasiswa untuk login ke SIAKAD2</small>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
            Tutup
          </button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js_bawah')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Delete confirmation (existing code)
      document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
          const form = this.closest('form');
          const userName = this.getAttribute('data-name');

          showDeleteConfirmation(() => {
            form.submit();
          }, `pendaftaran ${userName}`);
        });
      });

      // Initialize Tooltips (jika ada)
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
      var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
      });
    });

    // Fungsi untuk menampilkan kredensial
    function showCredentials(username, password) {
      document.getElementById('modal-username').value = username;
      document.getElementById('modal-password').value = password;

      // Reset ke state awal
      document.getElementById('modal-password').type = 'password';
      document.getElementById('modal-password-icon').className = 'ti ti-eye';

      // Show modal menggunakan Bootstrap 5
      var modal = new bootstrap.Modal(document.getElementById('credentials-modal'));
      modal.show();
    }

    // Toggle show/hide password di modal
    function toggleModalPassword() {
      const passwordField = document.getElementById('modal-password');
      const passwordIcon = document.getElementById('modal-password-icon');

      if (passwordField.type === 'password') {
        passwordField.type = 'text';
        passwordIcon.className = 'ti ti-eye-off';
      } else {
        passwordField.type = 'password';
        passwordIcon.className = 'ti ti-eye';
      }
    }

    // Copy username dari modal
    function copyModalUsername() {
      const field = document.getElementById('modal-username');
      field.select();
      field.setSelectionRange(0, 99999); // For mobile devices

      try {
        navigator.clipboard.writeText(field.value).then(function() {
          showToast('Username berhasil disalin!', 'success');
        });
      } catch (err) {
        // Fallback untuk browser lama
        document.execCommand('copy');
        showToast('Username berhasil disalin!', 'success');
      }
    }

    // Copy password dari modal
    function copyModalPassword() {
      const field = document.getElementById('modal-password');
      field.select();
      field.setSelectionRange(0, 99999); // For mobile devices

      try {
        navigator.clipboard.writeText(field.value).then(function() {
          showToast('Password berhasil disalin!', 'success');
        });
      } catch (err) {
        // Fallback untuk browser lama
        document.execCommand('copy');
        showToast('Password berhasil disalin!', 'success');
      }
    }

    // Toast notification untuk Tabler
    function showToast(message, type = 'info') {
      // Gunakan toast Tabler jika ada
      if (typeof toastify === 'function') {
        const background = type === 'success' ? 'bg-success' : 'bg-info';
        toastify({
          text: message,
          duration: 3000,
          gravity: "top",
          position: "right",
          className: `bg-${type}`,
          stopOnFocus: true
        }).showToast();
      } else {
        // Fallback simple alert
        alert(message);
      }
    }

    document.addEventListener('DOMContentLoaded', function() {
      // Delete confirmation
      document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
          const form = this.closest('form');
          const userName = this.getAttribute('data-name');

          showDeleteConfirmation(() => {
            form.submit();
          }, `pendaftaran ${userName}`);
        });
      });
    });
  </script>
@endsection
