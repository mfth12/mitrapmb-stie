@extends('components.theme.back')

@section('container')
  <div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <h2 class="page-title">Tambah Pendaftaran Baru</h2>
          <div class="page-pretitle">Daftarkan calon mahasiswa baru ke SIAKAD2</div>
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
              @if (isset($error))
                <div class="alert alert-danger">
                  <i class="ti ti-alert-circle fs-2 me-2"></i>
                  {{ $error }}
                </div>
                <div class="text-center mt-4">
                  <a href="{{ route('pendaftaran.index') }}" class="btn btn-default">
                    <i class="ti ti-arrow-back-up fs-2 me-1"></i>
                    Kembali
                  </a>
                </div>
              @elseif(!$jadwal)
                <div class="alert alert-warning">
                  <i class="ti ti-alert-triangle fs-2 me-2"></i>
                  Jadwal pendaftaran tidak tersedia. Silakan coba lagi nanti.
                </div>
                <div class="text-center mt-4">
                  <a href="{{ route('pendaftaran.index') }}" class="btn btn-default">
                    <i class="ti ti-arrow-back-up fs-2 me-1"></i>
                    Kembali
                  </a>
                </div>
              @else
                <div class="alert alert-info mb-4">
                  <div class="d-flex align-items-center">
                    <i class="ti ti-info-circle fs-2 me-2"></i>
                    <div>
                      <strong>Jadwal Pendaftaran Aktif:</strong><br>
                      Gelombang {{ $jadwal['GELOMBANG'] }} Tahun Akademik
                      {{ $jadwal['TAHUN'] }}/{{ $jadwal['TAHUN'] + 1 }}<br>
                      Periode: {{ \Carbon\Carbon::parse($jadwal['TANGGALMULAI'])->format('d/m/Y') }} -
                      {{ \Carbon\Carbon::parse($jadwal['TANGGALSELESAI'])->format('d/m/Y') }}<br>
                      Biaya: Rp {{ number_format($jadwal['BIAYA'], 0, ',', '.') }}
                    </div>
                  </div>
                </div>

                <form action="{{ route('pendaftaran.store') }}" method="POST" id="formPendaftaran">
                  @csrf

                  <div class="row">
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label">Program Studi <span class="text-danger">*</span></label>
                        <select name="prodi_id" class="form-select @error('prodi_id') is-invalid @enderror" required>
                          <option value="">Pilih Program Studi</option>
                          @foreach ($prodi as $id => $nama)
                            <option value="{{ $id }}" {{ old('prodi_id') == $id ? 'selected' : '' }}>
                              {{ $nama }}
                            </option>
                          @endforeach
                        </select>
                        @error('prodi_id')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label">Kelas <span class="text-danger">*</span></label>
                        <select name="kelas" class="form-select @error('kelas') is-invalid @enderror" required>
                          <option value="">Pilih Kelas</option>
                          <option value="0" {{ old('kelas') == '0' ? 'selected' : '' }}>Pagi</option>
                          <option value="1" {{ old('kelas') == '1' ? 'selected' : '' }}>Sore</option>
                          <option value="2" {{ old('kelas') == '2' ? 'selected' : '' }}>Malam</option>
                          {{-- <option value="3" {{ old('kelas') == '3' ? 'selected' : '' }}>International</option> --}}
                          <option value="5" {{ old('kelas') == '5' ? 'selected' : '' }}>Kemitraan</option>
                        </select>
                        @error('kelas')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama_lengkap"
                          class="form-control @error('nama_lengkap') is-invalid @enderror"
                          value="{{ old('nama_lengkap') }}" required placeholder="Masukkan nama lengkap">
                        @error('nama_lengkap')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                          value="{{ old('email') }}" required placeholder="email@example.com">
                        @error('email')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label">Nomor HP <span class="text-danger">*</span></label>
                        <input type="text" name="nomor_hp" class="form-control @error('nomor_hp') is-invalid @enderror"
                          value="{{ old('nomor_hp') }}" required placeholder="081234567890">
                        @error('nomor_hp')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
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
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label">Password <span class="text-danger">*</span></label>
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
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" required
                          placeholder="Ulangi password">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label">Biaya Pendaftaran</label>
                        <input type="text" class="form-control"
                          value="Rp {{ number_format($jadwal['BIAYA'], 0, ',', '.') }}" readonly>
                        <small class="text-muted">Biaya akan dikirim ke SIAKAD2</small>
                      </div>
                    </div>
                  </div>

                  <div class="alert alert-warning mt-4">
                    <div class="d-flex">
                      <i class="ti ti-alert-triangle fs-2 me-2"></i>
                      <div>
                        <strong>Perhatian:</strong><br>
                        Data akan dikirim langsung ke sistem SIAKAD2. Pastikan semua data sudah benar sebelum menyimpan.
                      </div>
                    </div>
                  </div>
            </div>

            <div class="card-footer">
              <div class="d-flex flex-column-reverse flex-md-row-reverse bd-highlight">
                <button type="submit" class="btn btn-primary ms-md-2 mt-2 mt-md-0" id="btnSubmit">
                  <i class="ti ti-send fs-2 me-1"></i>
                  Daftarkan ke SIAKAD2
                </button>
                <a href="{{ route('pendaftaran.index') }}" class="btn btn-default ms-md-2">
                  <i class="ti ti-arrow-back-up fs-2 me-1"></i>
                  Batal
                </a>
              </div>
            </div>
            </form>
            @endif
          </div>
        </div>
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
          btnSubmit.innerHTML = '<i class="ti ti-loader-2 fs-2 me-1 spinner"></i> Mengirim ke SIAKAD2...';
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
  </style>
@endsection
