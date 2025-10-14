@extends('components.theme.back')

@section('container')
  <div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <h2 class="page-title">Edit Pengguna - {{ $pengguna->name }}</h2>
          <div class="page-pretitle">Edit data pengguna</div>
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
              <form action="{{ route('pengguna.update', $pengguna) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                      <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                        value="{{ old('nama', $pengguna->name) }}" required>
                      @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label">Asal Sekolah <span class="text-danger">*</span></label>
                      <input type="text" name="asal_sekolah"
                        class="form-control @error('asal_sekolah') is-invalid @enderror"
                        value="{{ old('asal_sekolah', $pengguna->asal_sekolah) }}" required>
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
                        value="{{ old('username', $pengguna->username) }}" required>
                      @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label">Email <span class="text-danger">*</span></label>
                      <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $pengguna->email) }}" required>
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
                        value="{{ old('nomor_hp', $pengguna->nomor_hp) }}" required>
                      @error('nomor_hp')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label">Nomor Whatsapp</label>
                      <input type="text" name="nomor_hp2" class="form-control @error('nomor_hp2') is-invalid @enderror"
                        value="{{ old('nomor_hp2', $pengguna->nomor_hp2) }}">
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

                      {{-- Preview avatar --}}
                      @if ($pengguna->has_custom_avatar)
                        <div class="mb-2">
                          <img src="{{ $pengguna->avatar_thumb_url }}" alt="Avatar" class="rounded"
                            style="max-width: 100px;">
                          <div class="mt-1">
                            <a href="#" class="text-danger small delete-avatar-btn"
                              data-user-id="{{ $pengguna->user_id }}">
                              <i class="ti ti-trash"></i> Hapus foto
                            </a>
                          </div>
                        </div>
                      @endif

                      <input type="file" name="avatar" class="form-control @error('avatar') is-invalid @enderror"
                        accept="image/jpeg,image/png,image/jpg,image/webp">
                      <small class="form-hint">Format: JPEG, PNG, JPG, WebP. Maksimal 2MB. Kosongkan jika tidak ingin
                        mengubah.</small>
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
                      <select name="role" class="form-select @error('role') is-invalid @enderror" required
                        {{ $pengguna->hasRole('superadmin') ? 'disabled' : '' }}>
                        <option value="">Pilih Role</option>
                        @foreach ($roles as $role)
                          <option value="{{ $role->name }}"
                            {{ old('role', $pengguna->getRoleNames()->first()) == $role->name ? 'selected' : '' }}>
                            {{ ucfirst($role->name) }}
                          </option>
                        @endforeach
                      </select>
                      @if ($pengguna->hasRole('superadmin'))
                        <input type="hidden" name="role" value="superadmin">
                        <small class="text-muted">Role Superadmin tidak dapat diubah</small>
                      @endif
                      @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label">Status <span class="text-danger">*</span></label>
                      <select name="status" class="form-select">
                        <option value="active" {{ old('status', $pengguna->status) == 'active' ? 'selected' : '' }}>
                          Aktif
                        </option>
                        <option value="inactive" {{ old('status', $pengguna->status) == 'inactive' ? 'selected' : '' }}>
                          Nonaktif</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label">Password</label>
                      <input type="password" name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Kosongkan jika tidak ingin mengubah">
                      @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label">Konfirmasi Password</label>
                      <input type="password" name="password_confirmation" class="form-control"
                        placeholder="Kosongkan jika tidak ingin mengubah">
                    </div>
                  </div>
                </div>

                <div class="mt-4">
                  <button type="submit" class="btn btn-primary me-1"><i class="ti ti-device-floppy fs-2 me-1"></i>
                    Update
                  </button>
                  <a href="{{ route('pengguna.index') }}" class="btn btn-default me-1">
                    <i class="ti ti-arrow-back-up fs-2 me-1"></i>
                    Kembali
                  </a>

                  @can('user_edit')
                    @if (!$pengguna->hasRole('superadmin'))
                      <button type="button" class="btn btn-warning float-end"
                        onclick="document.getElementById('reset-password-form').submit()">
                        Reset Password
                      </button>
                    @endif
                  @endcan
                </div>
              </form>

              @can('user_edit')
                @if (!$pengguna->hasRole('superadmin'))
                  <form id="reset-password-form" action="{{ route('pengguna.reset-password', $pengguna) }}"
                    method="POST" class="d-none">
                    @csrf
                  </form>
                @endif
              @endcan
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

  <script>
    // Delete avatar confirmation
    document.querySelectorAll('.delete-avatar-btn').forEach(button => {
      button.addEventListener('click', function(e) {
        e.preventDefault();
        const userId = this.getAttribute('data-user-id');

        showConfirm({
          title: 'Hapus Foto Profil?',
          text: 'Foto profil akan dihapus permanen. Tindakan ini tidak dapat dibatalkan!',
          icon: 'warning',
          confirmButtonText: 'Ya, Hapus!',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            // Create form untuk delete avatar
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/pengguna/${userId}/avatar`;
            form.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;
            document.body.appendChild(form);
            form.submit();
          }
        });
      });
    });
  </script>
@endsection
