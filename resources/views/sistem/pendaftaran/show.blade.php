@extends('components.theme.back')

@section('container')
  <div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <h2 class="page-title">Detail Pendaftaran</h2>
          <div class="page-pretitle">Informasi lengkap pendaftaran calon mahasiswa</div>
        </div>
        <div class="col-auto">
          <a href="{{ route('pendaftaran.index') }}" class="btn btn-ghost-primary">
            <i class="ti ti-arrow-left me-1"></i>
            Kembali
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="page-body">
    <div class="container-xl">
      <div class="row">
        <div class="col-lg-8">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                <i class="ti ti-user me-2 text-blue"></i>
                {{ $pendaftaran->nama_lengkap }}
              </h3>
              <div class="card-actions">
                {!! $pendaftaran->status_badge !!}
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="mb-4">
                    <label class="form-label">Email</label>
                    <div class="form-control-plaintext">
                      <i class="ti ti-mail me-2 text-muted"></i>
                      {{ $pendaftaran->email }}
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-4">
                    <label class="form-label">Nomor HP</label>
                    <div class="form-control-plaintext">
                      <i class="ti ti-phone me-2 text-muted"></i>
                      {{ $pendaftaran->nomor_hp }}
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="mb-4">
                    <label class="form-label">Program Studi</label>
                    <div class="form-control-plaintext">
                      <i class="ti ti-school me-2 text-muted"></i>
                      {{ $pendaftaran->prodi_nama }}
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-4">
                    <label class="form-label">Kelas</label>
                    <div class="form-control-plaintext">
                      <i class="ti ti-users me-2 text-muted"></i>
                      {{ $pendaftaran->nama_kelas }}
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="mb-4">
                    <label class="form-label">Tahun Akademik</label>
                    <div class="form-control-plaintext">
                      <i class="ti ti-calendar me-2 text-muted"></i>
                      {{ $pendaftaran->tahun }}/{{ $pendaftaran->tahun + 1 }} - Gel. {{ $pendaftaran->gelombang }}
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-4">
                    <label class="form-label">Biaya Pendaftaran</label>
                    <div class="form-control-plaintext">
                      <i class="ti ti-currency-dollar me-2 text-muted"></i>
                      <span class="fw-bold text-success">{{ $pendaftaran->biaya_formatted }}</span>
                    </div>
                  </div>
                </div>
              </div>

              @if ($pendaftaran->id_calon_mahasiswa)
                <div class="row">
                  <div class="col-12">
                    <div class="alert alert-success">
                      <h4 class="alert-title">
                        <i class="ti ti-check me-2"></i>
                        Kredensial SIAKAD2
                      </h4>
                      <div class="row mt-3">
                        <div class="col-md-6">
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
                        <div class="col-md-6">
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
                  </div>
                </div>
              @endif

              @if ($pendaftaran->keterangan)
                <div class="alert {{ $pendaftaran->status === 'failed' ? 'alert-danger' : 'alert-info' }}">
                  <h4 class="alert-title">
                    <i class="ti ti-{{ $pendaftaran->status === 'failed' ? 'alert-triangle' : 'info-circle' }} me-2"></i>
                    Keterangan
                  </h4>
                  {{ $pendaftaran->keterangan }}
                </div>
              @endif
            </div>
          </div>

          @if ($pendaftaran->response_data && is_array($pendaftaran->response_data))
            <div class="card mt-4">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="ti ti-code me-2 text-purple"></i>
                  Response SIAKAD2
                </h3>
              </div>
              <div class="card-body">
                <pre class="bg-dark text-light p-3 rounded"><code>{{ json_encode($pendaftaran->response_data, JSON_PRETTY_PRINT) }}</code></pre>
              </div>
            </div>
          @endif
        </div>

        <div class="col-lg-4">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                <i class="ti ti-info-circle me-2 text-green"></i>
                Informasi Sistem
              </h3>
            </div>
            <div class="card-body">
              <div class="mb-3">
                <label class="form-label">ID Calon Mahasiswa</label>
                <div class="form-control-plaintext">
                  <code>{{ $pendaftaran->id_calon_mahasiswa ?: '-' }}</code>
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label">No. Transaksi</label>
                <div class="form-control-plaintext">
                  <code>{{ $pendaftaran->no_transaksi ?: '-' }}</code>
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label">Tanggal Daftar</label>
                <div class="form-control-plaintext">
                  <i class="ti ti-calendar me-1 text-muted"></i>
                  {{ $pendaftaran->created_at->format('d/m/Y H:i') }}
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label">Terakhir Update</label>
                <div class="form-control-plaintext">
                  <i class="ti ti-clock me-1 text-muted"></i>
                  {{ $pendaftaran->updated_at->format('d/m/Y H:i') }}
                </div>
              </div>
              @if ($pendaftaran->synced_at)
                <div class="mb-3">
                  <label class="form-label">Terakhir Sync</label>
                  <div class="form-control-plaintext">
                    <i class="ti ti-refresh me-1 text-muted"></i>
                    {{ $pendaftaran->synced_at->format('d/m/Y H:i') }}
                  </div>
                </div>
              @endif
            </div>
          </div>

          @if ($pendaftaran->agen)
            <div class="card mt-4">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="ti ti-user-check me-2 text-orange"></i>
                  Data Agen
                </h3>
              </div>
              <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                  <div class="avatar avatar-sm me-3 bg-orange-lt">
                    <span class="avatar-text">{{ substr($pendaftaran->agen->name, 0, 2) }}</span>
                  </div>
                  <div>
                    <div class="font-weight-medium">{{ $pendaftaran->agen->name }}</div>
                    <div class="text-muted small">{{ $pendaftaran->agen->email }}</div>
                  </div>
                </div>
              </div>
            </div>
          @endif

          <div class="card mt-4">
            <div class="card-body">
              <div class="d-grid gap-2">
                @can('pendaftaran_edit')
                  @if ($pendaftaran->status === 'pending')
                    <a href="{{ route('pendaftaran.edit', $pendaftaran) }}" class="btn btn-primary">
                      <i class="ti ti-edit me-1"></i>
                      Edit Pendaftaran
                    </a>
                  @endif
                @endcan
                <a href="{{ route('pendaftaran.index') }}" class="btn btn-ghost-primary">
                  <i class="ti ti-arrow-left me-1"></i>
                  Kembali ke Daftar
                </a>
              </div>
            </div>
          </div>
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

    function showToast(message, type = 'info') {
      const toast = document.createElement('div');
      toast.className = `toast show align-items-center text-bg-${type} border-0 position-fixed top-0 end-0 m-3`;
      toast.style.zIndex = '1060';
      toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">${message}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    `;
      document.body.appendChild(toast);

      setTimeout(() => {
        toast.remove();
      }, 3000);
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
