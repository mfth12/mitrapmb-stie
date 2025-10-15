@extends('components.theme.back')

@section('container')
  <div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <h2 class="page-title">Edit Pendaftaran - {{ $pendaftaran->nama_lengkap }}</h2>
          <div class="page-pretitle">Edit data pendaftaran calon mahasiswa</div>
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
              <div class="alert alert-info mb-4">
                <div class="d-flex align-items-center">
                  <i class="ti ti-info-circle fs-2 me-2"></i>
                  <div>
                    <strong>Status: {!! $pendaftaran->status_badge !!}</strong><br>
                    Hanya pendaftaran dengan status <strong>Pending</strong> yang dapat diedit.
                  </div>
                </div>
              </div>

              <form action="{{ route('pendaftaran.update', $pendaftaran) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label">Program Studi <span class="text-danger">*</span></label>
                      <select name="prodi_id" class="form-select @error('prodi_id') is-invalid @enderror" required>
                        <option value="">Pilih Program Studi</option>
                        @foreach ($prodi as $id => $nama)
                          <option value="{{ $id }}"
                            {{ old('prodi_id', $pendaftaran->prodi_id) == $id ? 'selected' : '' }}>
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
                        <option value="0" {{ old('kelas', $pendaftaran->kelas) == '0' ? 'selected' : '' }}>Reguler
                          Pagi</option>
                        <option value="1" {{ old('kelas', $pendaftaran->kelas) == '1' ? 'selected' : '' }}>Reguler
                          Sore</option>
                        <option value="2" {{ old('kelas', $pendaftaran->kelas) == '2' ? 'selected' : '' }}>Malam
                        </option>
                        {{-- <option value="3" {{ old('kelas', $pendaftaran->kelas) == '3' ? 'selected' : '' }}>
                          International</option> --}}
                        <option value="5" {{ old('kelas', $pendaftaran->kelas) == '5' ? 'selected' : '' }}>Kemitraan
                        </option>
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
                        value="{{ old('nama_lengkap', $pendaftaran->nama_lengkap) }}" required>
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
                        value="{{ old('email', $pendaftaran->email) }}" required>
                      @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label">Nomor HP <span class="text-danger">*</span></label>
                      <input type="text" name="nomor_hp" class="form-control @error('nomor_hp') is-invalid @enderror"
                        value="{{ old('nomor_hp', $pendaftaran->nomor_hp) }}" required>
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
                      <input type="text" name="nomor_hp2" class="form-control @error('nomor_hp2') is-invalid @enderror"
                        value="{{ old('nomor_hp2', $pendaftaran->nomor_hp2) }}">
                      @error('nomor_hp2')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label">Biaya Pendaftaran</label>
                      <input type="text" class="form-control" value="{{ $pendaftaran->biaya_formatted }}" readonly>
                    </div>
                  </div>
                </div>

                @if ($pendaftaran->id_calon_mahasiswa)
                  <div class="alert alert-warning mt-3">
                    <div class="d-flex">
                      <i class="ti ti-alert-triangle fs-2 me-2"></i>
                      <div>
                        <strong>Data sudah terkirim ke SIAKAD2:</strong><br>
                        ID Calon Mahasiswa: <code>{{ $pendaftaran->id_calon_mahasiswa }}</code><br>
                        Username: <code>{{ $pendaftaran->username_siakad }}</code><br>
                        No. Transaksi: <code>{{ $pendaftaran->no_transaksi }}</code>
                      </div>
                    </div>
                  </div>
                @endif
            </div>

            <div class="card-footer">
              <div class="d-flex flex-column-reverse flex-md-row-reverse bd-highlight">
                <button type="submit" class="btn btn-primary ms-md-2 mt-2 mt-md-0">
                  <i class="ti ti-device-floppy fs-2 me-1"></i>
                  Perbarui Data
                </button>
                <a href="{{ route('pendaftaran.index') }}" class="btn btn-default ms-md-2">
                  <i class="ti ti-arrow-back-up fs-2 me-1"></i>
                  Kembali
                </a>
              </div>
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
