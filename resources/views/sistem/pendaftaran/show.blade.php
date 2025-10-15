@extends('components.theme.back')

@section('container')
  <div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <h2 class="page-title">Detail Pendaftaran - {{ $pendaftaran->nama_lengkap }}</h2>
          <div class="page-pretitle">Informasi lengkap pendaftaran calon mahasiswa</div>
        </div>
      </div>
    </div>
  </div>

  <div class="page-body">
    <div class="container-xl">
      <div class="row justify-content-center">
        <div class="col-md-10">
          <div class="card">
            <div class="card-body my-2">
              <div class="row mb-4">
                <div class="col-md-8">
                  <div class="row">
                    <div class="col-md-6">
                      <strong>Status Pendaftaran:</strong><br>
                      {!! $pendaftaran->status_badge !!}
                    </div>
                    <div class="col-md-6">
                      <strong>Tanggal Daftar:</strong><br>
                      {{ $pendaftaran->created_at->format('d/m/Y H:i') }}
                    </div>
                  </div>

                  @if ($pendaftaran->id_calon_mahasiswa)
                    <div class="row mt-3">
                      <div class="col-md-6">
                        <strong>ID Calon Mahasiswa:</strong><br>
                        <code class="fs-5">{{ $pendaftaran->id_calon_mahasiswa }}</code>
                      </div>
                      <div class="col-md-6">
                        <strong>Username SIAKAD:</strong><br>
                        <code class="fs-5">{{ $pendaftaran->username_siakad }}</code>
                      </div>
                    </div>

                    <div class="row mt-3">
                      <div class="col-md-6">
                        <strong>No. Transaksi:</strong><br>
                        <code>{{ $pendaftaran->no_transaksi }}</code>
                      </div>
                      <div class="col-md-6">
                        <strong>Tanggal Sync:</strong><br>
                        {{ $pendaftaran->synced_at ? $pendaftaran->synced_at->format('d/m/Y H:i') : '-' }}
                      </div>
                    </div>
                  @endif
                </div>
              </div>

              <hr>

              <h5 class="mb-3">Data Calon Mahasiswa</h5>
              <div class="row">
                <div class="col-md-6">
                  <strong>Nama Lengkap:</strong><br>
                  {{ $pendaftaran->nama_lengkap }}
                </div>
                <div class="col-md-6">
                  <strong>Email:</strong><br>
                  {{ $pendaftaran->email }}
                </div>
              </div>

              <div class="row mt-3">
                <div class="col-md-6">
                  <strong>Username SIAKAD:</strong><br>
                  <code class="fs-5">{{ $pendaftaran->username_siakad }}</code>
                </div>
                <div class="col-md-6">
                  <strong>Password SIAKAD:</strong><br>
                  @if ($pendaftaran->password_text)
                    <div class="input-group">
                      <input type="password" class="form-control" id="passwordField"
                        value="{{ $pendaftaran->password_text }}" readonly style="font-family: monospace;">
                      <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">
                        <i class="ti ti-eye" id="passwordIcon"></i>
                      </button>
                      <button type="button" class="btn btn-outline-primary" onclick="copyPassword()">
                        <i class="ti ti-copy"></i>
                      </button>
                    </div>
                    <small class="text-muted">Berikan kredensial ini ke calon mahasiswa</small>
                  @else
                    <span class="text-muted">-</span>
                  @endif
                </div>
              </div>

              <hr>

              <h5 class="mb-3">Data Akademik</h5>
              <div class="row">
                <div class="col-md-6">
                  <strong>Program Studi:</strong><br>
                  {{ $pendaftaran->prodi_nama }}
                </div>
                <div class="col-md-6">
                  <strong>Kelas:</strong><br>
                  @switch($pendaftaran->kelas)
                    @case('0')
                      Pagi
                    @break

                    @case('1')
                      Sore
                    @break

                    @case('2')
                      Malam
                    @break

                    {{-- @case('3')
                      International
                    @break --}}
                    @case('5')
                      Kemitraan
                    @break

                    @default
                      {{ $pendaftaran->kelas }}
                  @endswitch
                </div>
              </div>

              <div class="row mt-3">
                <div class="col-md-6">
                  <strong>Tahun Akademik:</strong><br>
                  {{ $pendaftaran->tahun }}/{{ $pendaftaran->tahun + 1 }}
                </div>
                <div class="col-md-6">
                  <strong>Gelombang:</strong><br>
                  {{ $pendaftaran->gelombang }}
                </div>
              </div>

              <div class="row mt-3">
                <div class="col-md-6">
                  <strong>Biaya Pendaftaran:</strong><br>
                  <span class="fs-5">{{ $pendaftaran->biaya_formatted }}</span>
                </div>
              </div>

              @if ($pendaftaran->agen)
                <hr>
                <h5 class="mb-3">Data Agen</h5>
                <div class="row">
                  <div class="col-md-6">
                    <strong>Nama Agen:</strong><br>
                    {{ $pendaftaran->agen->name }}
                  </div>
                  <div class="col-md-6">
                    <strong>Email Agen:</strong><br>
                    {{ $pendaftaran->agen->email }}
                  </div>
                </div>
              @endif

              @if ($pendaftaran->keterangan)
                <hr>
                <h5 class="mb-3">Keterangan</h5>
                <div class="alert {{ $pendaftaran->status === 'failed' ? 'alert-danger' : 'alert-info' }}">
                  {{ $pendaftaran->keterangan }}
                </div>
              @endif

              @if ($pendaftaran->response_data && is_array($pendaftaran->response_data))
                <hr>
                <h5 class="mb-3">Response SIAKAD2</h5>
                <div class="bg-dark text-light p-3 rounded">
                  <pre class="mb-0"><code>{{ json_encode($pendaftaran->response_data, JSON_PRETTY_PRINT) }}</code></pre>
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

    function copyPassword() {
      const passwordField = document.getElementById('passwordField');
      passwordField.select();
      document.execCommand('copy');

      // Show notification
      showToast('Password berhasil disalin!', 'success');
    }

    function showToast(message, type = 'info') {
      // Simple toast implementation - adjust based on your UI framework
      const toast = document.createElement('div');
      toast.className = `alert alert-${type} alert-dismissible fade show`;
      toast.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
      document.body.appendChild(toast);

      setTimeout(() => {
        toast.remove();
      }, 3000);
    }
  </script>
@endsection
