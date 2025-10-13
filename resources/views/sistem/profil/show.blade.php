@extends('components.theme.back')

@section('container')
  <div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <h2 class="page-title">Profil Saya</h2>
          <div class="page-pretitle">Informasi akun dan profil Anda</div>
        </div>
        <div class="col-auto">
          <a href="{{ route('profil.edit') }}" class="btn btn-primary">
            <i class="ti ti-edit fs-2 me-1"></i>
            Edit Profil
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
              <div class="row mb-4">
                <div class="col-md-4 text-center">
                  <div class="avatar avatar-xl mb-3" style="background-image: url({{ $user->avatar_url }})"></div>
                  <h4>{{ $user->name }}</h4>
                  <span class="badge bg-primary text-primary-fg">{{ $user->getRoleNames()->first() }}</span>

                  @if ($user->siakad_id)
                    <div class="mt-2">
                      <i class="ti ti-rosette-discount-check-filled text-primary fs-3"></i>
                      <small class="text-muted">Terhubung Siakad</small>
                    </div>
                  @endif
                </div>
                <div class="col-md-8">
                  <div class="row mb-3">
                    <div class="col-md-6">
                      <strong>Asal Sekolah:</strong><br>
                      {{ $user->asal_sekolah }}
                    </div>
                    <div class="col-md-6">
                      <strong>Status:</strong><br>
                      <span
                        class="badge {{ $user->status == 'active' ? 'bg-success text-success-fg' : 'bg-danger text-danger-fg' }}">
                        {{ $user->status == 'active' ? 'Aktif' : 'Nonaktif' }}
                      </span>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-md-6">
                      <strong>Email:</strong><br>
                      {{ $user->email }}
                    </div>
                    <div class="col-md-6">
                      <strong>Username:</strong><br>
                      {{ $user->username }}
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-md-6">
                      <strong>Nomor HP:</strong><br>
                      {{ $user->nomor_hp }}
                    </div>
                    <div class="col-md-6">
                      <strong>Nomor Whatsapp:</strong><br>
                      {{ $user->nomor_hp2 ?? '-' }}
                    </div>
                  </div>

                  @if ($user->about)
                    <div class="row mb-3">
                      <div class="col-12">
                        <strong>Tentang:</strong><br>
                        {{ $user->about }}
                      </div>
                    </div>
                  @endif

                  <div class="row">
                    <div class="col-md-6">
                      <strong>Terakhir Login:</strong><br>
                      {{ $user->last_logged_in ? $user->last_logged_in->format('d/m/Y H:i') : 'Belum pernah' }}
                    </div>
                    <div class="col-md-6">
                      <strong>Bergabung Sejak:</strong><br>
                      {{ $user->created_at->format('d/m/Y') }}
                    </div>
                  </div>
                </div>
              </div>

              <div class="mt-4">
                <a href="{{ route('profil.edit') }}" class="btn btn-primary me-2">
                  <i class="ti ti-edit me-1"></i> Edit Profil
                </a>
                <a href="{{ route('dashboard.index') }}" class="btn btn-secondary">
                  <i class="ti ti-arrow-back-up me-1"></i> Kembali ke Dashboard
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
