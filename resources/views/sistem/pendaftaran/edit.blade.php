@extends('components.theme.back')

@section('container')
  <div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <h2 class="page-title">Edit Pendaftaran</h2>
          <div class="page-pretitle">Edit data pendaftaran calon mahasiswa</div>
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
      <div class="row justify-content-center">
        <div class="col-lg-10">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                <i class="ti ti-user-edit me-2 text-orange"></i>
                Edit Data - {{ $pendaftaran->nama_lengkap }}
              </h3>
            </div>
            <div class="card-body">
              <div class="alert alert-info">
                <div class="d-flex">
                  <div>
                    <i class="ti ti-info-circle me-2"></i>
                  </div>
                  <div>
                    <h4 class="alert-title">Status: {!! $pendaftaran->status_badge !!}</h4>
                    <div class="text-muted">
                      Hanya pendaftaran dengan status <strong>Pending</strong> yang dapat diedit.
                    </div>
                  </div>
                </div>
              </div>

              @if ($pendaftaran->id_calon_mahasiswa)
                <div class="alert alert-success">
                  <div class="d-flex">
                    <div>
                      <i class="ti ti-check me-2"></i>
                    </div>
                    <div>
                      <h4 class="alert-title">Data Terkirim ke SIAKAD2</h4>
                      <div class="text-muted">
                        ID Calon Mahasiswa: <code>{{ $pendaftaran->id_calon_mahasiswa }}</code> |
                        Username: <code>{{ $pendaftaran->username_siakad }}</code> |
                        No. Transaksi: <code>{{ $pendaftaran->no_transaksi }}</code>
                      </div>
                    </div>
                  </div>
                </div>
              @endif

              <form action="{{ route('pendaftaran.update', $pendaftaran) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label required">Program Studi</label>
                      <select name="prodi_id" class="form-select @error('prodi_id') is-invalid @enderror" required>
                        <option value="">Pilih Program Studi</option>
                        @foreach ($prodi as $id => $nama)
                          @if ($id != 1002)
                            <option value="{{ $id }}"
                              {{ old('prodi_id', $pendaftaran->prodi_id) == $id ? 'selected' : '' }}>
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
                        <option value="0" {{ old('kelas', $pendaftaran->kelas) == '0' ? 'selected' : '' }}>Pagi
                        </option>
                        <option value="1" {{ old('kelas', $pendaftaran->kelas) == '1' ? 'selected' : '' }}>Sore
                        </option>
                        <option value="2" {{ old('kelas', $pendaftaran->kelas) == '2' ? 'selected' : '' }}>Malam
                        </option>
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
                  <div class="col-12">
                    <div class="mb-3">
                      <label class="form-label required">Nama Lengkap</label>
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
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label required">Email</label>
                      <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $pendaftaran->email) }}" required>
                      @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label required">Nomor HP</label>
                      <input type="text" name="nomor_hp" class="form-control @error('nomor_hp') is-invalid @enderror"
                        value="{{ old('nomor_hp', $pendaftaran->nomor_hp) }}" required>
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
                      <input type="text" name="nomor_hp2" class="form-control @error('nomor_hp2') is-invalid @enderror"
                        value="{{ old('nomor_hp2', $pendaftaran->nomor_hp2) }}">
                      @error('nomor_hp2')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Biaya Pendaftaran</label>
                      <div class="form-control-plaintext">
                        <span class="text-success fw-bold">{{ $pendaftaran->biaya_formatted }}</span>
                      </div>
                    </div>
                  </div>
                </div>
            </div>

            <div class="card-footer">
              <div class="d-flex justify-content-between">
                <a href="{{ route('pendaftaran.show', $pendaftaran) }}" class="btn btn-ghost-primary">
                  <i class="ti ti-arrow-left me-1"></i>
                  Kembali ke Detail
                </a>
                <button type="submit" class="btn btn-primary">
                  <i class="ti ti-device-floppy me-1"></i>
                  Perbarui Data
                </button>
              </div>
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
@endsection
