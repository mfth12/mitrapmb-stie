@extends('components.theme.back')

@section('container')
  <div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <h2 class="page-title">Tambah Baru</h2>
          <div class="page-pretitle">Tambah pengguna baru ke {{ konfigs('NAMA_SISTEM') }}</div>
        </div>
        <div class="col-auto">
          <a href="{{ route('pengguna.index') }}" class="btn btn-secondary">
            <i class="ti ti-arrow-back-up fs-2 me-1"></i>
            Kembali
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="page-body">
    <div class="container-xl">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card">
            <div class="card-body my-2">
              <form action="{{ route('pengguna.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                      <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                        value="{{ old('nama') }}" required>
                      @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label">Asal Sekolah <span class="text-danger">*</span></label>
                      <input type="text" name="asal_sekolah"
                        class="form-control @error('asal_sekolah') is-invalid @enderror" value="{{ old('asal_sekolah') }}"
                        required>
                      @error('asal_sekolah')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label">Username <span class="text-danger">*</span></label>
                      <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                        value="{{ old('username') }}" required>
                      @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label">Email <span class="text-danger">*</span></label>
                      <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" required>
                      @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label">Nomor HP <span class="text-danger">*</span></label>
                      <input type="text" name="nomor_hp" class="form-control @error('nomor_hp') is-invalid @enderror"
                        value="{{ old('nomor_hp') }}" required>
                      @error('nomor_hp')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label">Nomor Whatsapp</label>
                      <input type="text" name="nomor_hp2" class="form-control @error('nomor_hp2') is-invalid @enderror"
                        value="{{ old('nomor_hp2') }}">
                      @error('nomor_hp2')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                </div>

                {{-- Tambahkan di form setelah field nomor_hp2 --}}
                <div class="row">
                  <div class="col-md-12">
                    <div class="mb-3">
                      <label class="form-label">Foto Profil</label>
                      <input type="file" name="avatar" class="form-control @error('avatar') is-invalid @enderror"
                        accept="image/jpeg,image/png,image/jpg,image/webp">
                      <small class="form-hint">Format: JPEG, PNG, JPG, WebP. Maksimal 2MB. Opsional.</small>
                      @error('avatar')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label">Role <span class="text-danger">*</span></label>
                      <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                        <option value="">Pilih Role</option>
                        @foreach ($roles as $role)
                          <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                            {{ ucfirst($role->name) }}
                          </option>
                        @endforeach
                      </select>
                      @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label">Status</label>
                      <select name="status" class="form-select">
                        <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label">Password <span class="text-danger">*</span></label>
                      <input type="password" name="password"
                        class="form-control @error('password') is-invalid @enderror" required>
                      @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                      <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                  </div>
                </div>

                <div class="mt-4">
                  <button type="submit" class="btn btn-primary me-1"><i class="ti ti-device-floppy fs-2 me-1"></i>
                    Simpan
                  </button>
                  <a href="{{ route('pengguna.index') }}" class="btn btn-secondary">Batal</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('style')
  {{-- kosong --}}
@endsection

@section('modals')
  {{-- kosong --}}
@endsection

@section('js_atas')
  {{-- kosong --}}
@endsection

@section('js_bawah')
  {{-- DEPENDENSI UNTUK PAGE SPESIFIK --}}
  {{-- <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/libs/apexcharts/dist/apexcharts.min.js"></script> --}}
  {{-- <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/libs/jsvectormap/dist/jsvectormap.min.js"></script> --}}
  {{-- <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/libs/jsvectormap/dist/maps/world.js"></script> --}}
  {{-- <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/libs/jsvectormap/dist/maps/world-merc.js"></script> --}}
  {{-- TAMBAHAN JS UNTUK PAGE SPESIFIK --}}
  {{-- @vite(['resources/js/pages/dasbor.js']) --}}
  {{-- KOMPONEN INKLUD --}}
  @include('components.back.konfig-tampilan', ['floating' => false])
@endsection
