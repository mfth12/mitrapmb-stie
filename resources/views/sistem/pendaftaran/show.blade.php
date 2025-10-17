@extends('components.theme.back')

@section('container')
  <div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <h2 class="page-title">Detail Pendaftar - {{ Str::of($pendaftaran->nama_lengkap)->explode(' ')->first() }}</h2>
          <div class="page-pretitle">Informasi lengkap calon mahasiswa STIE</div>
        </div>
      </div>
    </div>
  </div>

  <div class="page-body">
    <div class="container-xl">
      <div class="row justify-content-center">
        <div class="col-md-10 col-lg-9">
          <div class="card">
            <div class="card-body my-3">
              <div class="row mb-4">
                <div class="col-md-4 text-center">
                  <div class="avatar avatar-xl mb-3 bg-primary-lt">
                    <i class="ti ti-user fs-2 text-primary"></i>
                  </div>
                  <h4 class="mb-1">{{ $pendaftaran->nama_lengkap }}</h4>
                  {!! $pendaftaran->status_badge !!}
                </div>

                <div class="col-md-8">
                  <div class="row">
                    <div class="col-md-6 mt-3 mt-md-0">
                      <strong>Email:</strong><br>
                      {{ $pendaftaran->email }}
                    </div>
                    <div class="col-md-6 mt-3 mt-md-0">
                      <strong>Nomor HP:</strong><br>
                      {{ $pendaftaran->nomor_hp }}
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6 mt-3">
                      <strong>Program Studi:</strong><br>
                      {{ $pendaftaran->prodi_nama }}
                    </div>
                    <div class="col-md-6 mt-3">
                      <strong>Kelas:</strong><br>
                      {{ $pendaftaran->nama_kelas }}
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6 mt-3">
                      <strong>Tahun Akademik:</strong><br>
                      {{ $pendaftaran->tahun }}/{{ $pendaftaran->tahun + 1 }} - Gel. {{ $pendaftaran->gelombang }}
                    </div>
                    <div class="col-md-6 mt-3">
                      <strong>Biaya Pendaftaran:</strong><br>
                      <span class="fw-bold text-success">{{ $pendaftaran->biaya_formatted }}</span>
                    </div>
                  </div>
                </div>
              </div>

              {{-- KREDENSIAL SIAKAD2 --}}
              @if ($pendaftaran->id_calon_mahasiswa)
                <div class="alert alert-success mt-4">
                  <h4 class="alert-title mb-3">
                    <i class="ti ti-check me-2"></i>
                    Kredensial SIAKAD2
                  </h4>
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label class="form-label">Username</label>
                      <div class="input-group">
                        <input type="text" class="form-control font-monospace"
                          value="{{ $pendaftaran->username_siakad }}" readonly>
                        <button class="btn btn-outline-secondary" type="button"
                          onclick="copyToClipboard('{{ $pendaftaran->username_siakad }}', 'Username')">
                          <i class="ti ti-copy"></i>
                        </button>
                      </div>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="form-label">Password</label>
                      <div class="input-group">
                        <input type="password" class="form-control font-monospace" id="passwordField"
                          value="{{ $pendaftaran->password_text }}" readonly>
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">
                          <i class="ti ti-eye" id="passwordIcon"></i>
                        </button>
                        <button class="btn btn-outline-primary" type="button"
                          onclick="copyToClipboard('{{ $pendaftaran->password_text }}', 'Password')">
                          <i class="ti ti-copy"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="mt-2 text-muted small">
                    <i class="ti ti-info-circle me-1"></i>
                    Berikan kredensial ini ke calon mahasiswa untuk login ke SIAKAD2
                  </div>
                </div>
              @endif

              {{-- KETERANGAN --}}
              @if ($pendaftaran->keterangan)
                <div class="alert mt-4 {{ $pendaftaran->status === 'failed' ? 'alert-danger' : 'alert-info' }}">
                  <h4 class="alert-title mb-2">
                    <i class="ti ti-{{ $pendaftaran->status === 'failed' ? 'alert-triangle' : 'info-circle' }} me-2"></i>
                    Keterangan
                  </h4>
                  {{ $pendaftaran->keterangan }}
                </div>
              @endif

              {{-- RESPONSE SIAKAD2 --}}
              @if ($pendaftaran->response_data && is_array($pendaftaran->response_data))
                <div class="card mt-4">
                  <div class="card-header">
                    <h3 class="card-title">
                      <i class="ti ti-code me-2 text-purple"></i>
                      Response SIAKAD2
                    </h3>
                  </div>
                  <div class="card-body">
                    <pre class="bg-dark text-light p-3 rounded mb-0"><code>{{ json_encode($pendaftaran->response_data, JSON_PRETTY_PRINT) }}</code></pre>
                  </div>
                </div>
              @endif
            </div>

            <div class="card-footer">
              <div class="d-flex flex-column-reverse flex-md-row-reverse bd-highlight">
                @can('pendaftaran_edit')
                  @if ($pendaftaran->status === 'pending')
                    <a href="{{ route('pendaftaran.edit', $pendaftaran) }}" class="btn btn-default ms-md-2 mt-2 mt-md-0">
                      <i class="ti ti-edit fs-2 me-1"></i>
                      Edit Pendaftaran
                    </a>
                  @endif
                @endcan
                <a href="{{ route('pendaftaran.index') }}" class="btn btn-default ms-md-2">
                  <i class="ti ti-arrow-back-up fs-2 me-1"></i>
                  Kembali
                </a>
              </div>
            </div>
          </div>

          {{-- INFORMASI SISTEM --}}
          <div class="card mt-4">
            <div class="card-body my-2">
              <h4 class="mb-3"><i class="ti ti-info-circle me-2 text-green"></i> Informasi Sistem</h4>
              <div class="row">
                <div class="col-md-6 mt-2">
                  <strong>ID Calon Mahasiswa:</strong><br>
                  <code>{{ $pendaftaran->id_calon_mahasiswa ?: '-' }}</code>
                </div>
                <div class="col-md-6 mt-2">
                  <strong>No. Transaksi:</strong><br>
                  <code>{{ $pendaftaran->no_transaksi ?: '-' }}</code>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 mt-2">
                  <strong>Tanggal Daftar:</strong><br>
                  {{ $pendaftaran->created_at->format('d/m/Y H:i') }}
                </div>
                <div class="col-md-6 mt-2">
                  <strong>Terakhir Update:</strong><br>
                  {{ $pendaftaran->updated_at->format('d/m/Y H:i') }}
                </div>
              </div>
              @if ($pendaftaran->synced_at)
                <div class="row">
                  <div class="col-md-6 mt-2">
                    <strong>Terakhir Sync:</strong><br>
                    {{ $pendaftaran->synced_at->format('d/m/Y H:i') }}
                  </div>
                </div>
              @endif
            </div>
          </div>

          {{-- DATA AGEN --}}
          @if ($pendaftaran->agen)
            <div class="card mt-4">
              <div class="card-body my-2">
                <h4 class="mb-3"><i class="ti ti-user-check me-2 text-orange"></i> Data Agen</h4>
                <div class="d-flex align-items-center">
                  <div class="avatar avatar-sm me-3 bg-orange-lt">
                    <span class="avatar-text">{{ substr($pendaftaran->agen->name, 0, 2) }}</span>
                  </div>
                  <div>
                    <div class="fw-bold">{{ $pendaftaran->agen->name }}</div>
                    <div class="text-muted small">{{ $pendaftaran->agen->email }}</div>
                  </div>
                </div>
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js_bawah')
  <script>
    function togglePassword() {
      const passwordField = document.getElementById('passwordField');
      const passwordIcon = document.getElementById('passwordIcon');

      if (passwordField.type === 'password') {
        passwordField.type = 'text';
        passwordIcon.className = 'ti ti-eye-off';
      } else {
        passwordField.type = 'password';
        passwordIcon.className = 'ti ti-eye';
      }
    }

    function copyToClipboard(text, type) {
      navigator.clipboard.writeText(text).then(function() {
        showToast(`${type} berhasil disalin!`, 'success');
      }).catch(function() {
        // Fallback untuk browser lama
        const textArea = document.createElement('textarea');
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        showToast(`${type} berhasil disalin!`, 'success');
      });
    }

    // Toast notification dengan iziToast - FUNGSI BARU
    function showToast(message, type = 'info') {
      const config = {
        message: message,
        position: 'topRight',
        timeout: 3000,
      };

      switch (type) {
        case 'success':
          iziToast.success({
            ...config,
            title: 'Sukses',
            backgroundColor: '#2ecc71',
            icon: 'ti ti-check'
          });
          break;
        case 'error':
          iziToast.error({
            ...config,
            title: 'Error',
            backgroundColor: '#e74c3c'
          });
          break;
        case 'warning':
          iziToast.warning({
            ...config,
            title: 'Peringatan',
            backgroundColor: '#f39c12'
          });
          break;
        default:
          iziToast.info({
            ...config,
            title: 'Info',
            backgroundColor: '#3498db'
          });
      }
    }
  </script>

  <style>
    .font-monospace {
      font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
    }

    .avatar-text {
      font-weight: 600;
      text-transform: uppercase;
    }
  </style>
@endsection
