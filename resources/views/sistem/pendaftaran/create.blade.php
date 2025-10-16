@extends('components.theme.back')

@section('container')
  <div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <h2 class="page-title">Tambah Pendaftaran Baru</h2>
          <div class="page-pretitle">Daftarkan calon mahasiswa baru ke SIAKAD2</div>
        </div>
        <div class="col-auto">
          <a href="{{ route('pendaftaran.index') }}" class="btn btn-default">
            <i class="ti ti-arrow-left me-1"></i>
            Kembali
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="page-body">
    <div class="container-xl">
      <div class="row justify-content-center">
        <div class="col-lg-10">
          @if (isset($error))
            <div class="alert alert-danger">
              <div class="d-flex">
                <div>
                  <i class="ti ti-alert-circle fs-2 me-2"></i>
                </div>
                <div>
                  <h4 class="alert-title">Koneksi Gagal</h4>
                  <div class="text-muted">{{ $error }}</div>
                </div>
              </div>
            </div>
            <div class="text-center mt-4">
              <a href="{{ route('pendaftaran.index') }}" class="btn btn-primary">
                <i class="ti ti-arrow-left me-1"></i>
                Kembali ke Daftar
              </a>
            </div>
          @elseif(!$jadwal)
            <div class="alert alert-warning">
              <div class="d-flex">
                <div>
                  <i class="ti ti-alert-triangle fs-2 me-2"></i>
                </div>
                <div>
                  <h4 class="alert-title">Jadwal Tidak Tersedia</h4>
                  <div class="text-muted">Jadwal pendaftaran tidak tersedia. Silakan coba lagi nanti.</div>
                </div>
              </div>
            </div>
            <div class="text-center mt-4">
              <a href="{{ route('pendaftaran.index') }}" class="btn btn-primary">
                <i class="ti ti-arrow-left me-1"></i>
                Kembali ke Daftar
              </a>
            </div>
          @else
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="ti ti-user-plus me-2 text-blue"></i>
                  Form Pendaftaran Calon Mahasiswa
                </h3>
              </div>
              <div class="card-body">
                {{-- Info Jadwal --}}
                <div class="alert alert-info">
                  <div class="d-flex">
                    <div>
                      <i class="ti ti-info-circle me-2"></i>
                    </div>
                    <div>
                      <h4 class="alert-title">Jadwal Pendaftaran Aktif</h4>
                      <div class="text-muted">
                        <strong>Gelombang {{ $jadwal['GELOMBANG'] }}</strong> -
                        Tahun Akademik {{ $jadwal['TAHUN'] }}/{{ $jadwal['TAHUN'] + 1 }} |
                        Periode: {{ \Carbon\Carbon::parse($jadwal['TANGGALMULAI'])->format('d/m/Y') }} -
                        {{ \Carbon\Carbon::parse($jadwal['TANGGALSELESAI'])->format('d/m/Y') }} |
                        Biaya: <strong>Rp {{ number_format($jadwal['BIAYA'], 0, ',', '.') }}</strong>
                      </div>
                    </div>
                  </div>
                </div>

                <form action="{{ route('pendaftaran.store') }}" method="POST" id="formPendaftaran">
                  @csrf

                  <div class="row">
                    <div class="col-lg-6">
                      <div class="mb-3">
                        <label class="form-label required">Program Studi</label>
                        <select name="prodi_id" class="form-select @error('prodi_id') is-invalid @enderror" required>
                          <option value="">Pilih Program Studi</option>
                          @foreach ($prodi as $id => $nama)
                            @if ($id != 1002)
                              <option value="{{ $id }}" {{ old('prodi_id') == $id ? 'selected' : '' }}>
                                {{ $nama }}
                              </option>
                            @endif
                          @endforeach
                        </select>
                        @error('prodi_id')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="mb-3">
                        <label class="form-label required">Kelas</label>
                        <select name="kelas" class="form-select @error('kelas') is-invalid @enderror" required>
                          <option value="">Pilih Kelas</option>
                          <option value="0" {{ old('kelas') == '0' ? 'selected' : '' }}>Pagi</option>
                          <option value="1" {{ old('kelas') == '1' ? 'selected' : '' }}>Sore</option>
                          <option value="2" {{ old('kelas') == '2' ? 'selected' : '' }}>Malam</option>
                          <option value="5" {{ old('kelas') == '5' ? 'selected' : '' }}>Kemitraan</option>
                        </select>
                        @error('kelas')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-12">
                      <div class="mb-3">
                        <label class="form-label required">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap"
                          class="form-control @error('nama_lengkap') is-invalid @enderror"
                          value="{{ old('nama_lengkap') }}" required placeholder="Masukkan nama lengkap calon mahasiswa">
                        @error('nama_lengkap')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-6">
                      <div class="mb-3">
                        <label class="form-label required">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                          value="{{ old('email') }}" required placeholder="email@example.com">
                        @error('email')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="mb-3">
                        <label class="form-label required">Nomor HP</label>
                        <input type="text" name="nomor_hp" class="form-control @error('nomor_hp') is-invalid @enderror"
                          value="{{ old('nomor_hp') }}" required placeholder="081234567890">
                        @error('nomor_hp')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-6">
                      <div class="mb-3">
                        <label class="form-label">Nomor HP (WhatsApp)</label>
                        <input type="text" name="nomor_hp2"
                          class="form-control @error('nomor_hp2') is-invalid @enderror" value="{{ old('nomor_hp2') }}"
                          placeholder="081234567891">
                        @error('nomor_hp2')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="mb-3">
                        <label class="form-label required">Password</label>
                        <input type="password" name="password"
                          class="form-control @error('password') is-invalid @enderror" required
                          placeholder="Minimal 8 karakter">
                        @error('password')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-6">
                      <div class="mb-3">
                        <label class="form-label required">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required
                          placeholder="Ulangi password">
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="mb-3">
                        <label class="form-label">Biaya Pendaftaran</label>
                        <div class="form-control-plaintext">
                          <span class="text-success fw-bold mt-0">Rp
                            {{ number_format($jadwal['BIAYA'], 0, ',', '.') }}</span>
                          <small class="text-muted d-block">Biaya akan dikirim ke SIAKAD2</small>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="alert alert-warning mt-4">
                    <div class="d-flex">
                      <div>
                        <i class="ti ti-alert-triangle me-2"></i>
                      </div>
                      <div>
                        <h4 class="alert-title">Perhatian</h4>
                        <div class="text-muted">
                          Data akan dikirim langsung ke sistem SIAKAD2.
                          Pastikan semua data sudah benar sebelum memulai proses daftar.
                        </div>
                      </div>
                    </div>
                  </div>
              </div>

              <div class="card-footer">
                <div class="d-flex justify-content-between">
                  <a href="{{ route('pendaftaran.index') }}" class="btn btn-default">
                    <i class="ti ti-arrow-left me-1"></i>
                    Kembali
                  </a>
                  <button type="submit" class="btn btn-primary" id="btnSubmit">
                    <i class="ti ti-send me-1"></i>
                    Daftarkan ke SIAKAD2
                  </button>
                </div>
              </div>
              </form>
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
    document.addEventListener('DOMContentLoaded', function() {
      const form = document.getElementById('formPendaftaran');
      const btnSubmit = document.getElementById('btnSubmit');

      if (form) {
        form.addEventListener('submit', function(e) {
          btnSubmit.disabled = true;
          btnSubmit.innerHTML = '<i class="ti ti-loader-2 spinner me-1"></i> Mengirim ke SIAKAD2...';
        });
      }
    });
  </script>

  <style>
    .spinner {
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      from {
        transform: rotate(0deg);
      }

      to {
        transform: rotate(360deg);
      }
    }

    .form-label.required::after {
      content: " *";
      color: #d63939;
    }
  </style>
@endsection
