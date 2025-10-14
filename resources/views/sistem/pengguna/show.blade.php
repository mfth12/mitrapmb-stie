@extends('components.theme.back')

@section('container')
  <div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <h2 class="page-title">Detail Pengguna - {{ Str::of($pengguna->name)->explode(' ')->first() }}</h2>
          <div class="page-pretitle">Informasi lengkap pengguna</div>
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
                <div class="col-md-3 text-center">
                  <div class="avatar avatar-xl mb-3" style="background-image: url({{ $pengguna->avatar_url }})">
                  </div>

                  <h4>{{ $pengguna->name }}
                    <span>
                      @if ($pengguna->siakad_id)
                        <i class="ti ti-rosette-discount-check-filled fs-3 text-primary" data-bs-toggle="tooltip"
                          data-bs-placement="top" title="Akun Siakad"></i>
                      @endif
                    </span>
                  </h4>

                  <span class="badge bg-primary text-primary-fg text-uppercase">
                    {{ $pengguna->getRoleNames()->first() }}
                  </span>
                </div>
                <div class="col-md-9">
                  <div class="row">
                    <div class="col-md-6 mt-3">
                      <strong>Asal Sekolah:</strong><br>
                      {{ $pengguna->asal_sekolah }}
                    </div>
                    <div class="col-md-6 mt-3">
                      <strong>Status:</strong><br>
                      <span
                        class="badge badge-pill {{ $pengguna->status == 'active' ? 'bg-success text-success-fg' : 'bg-secondary text-secondary-fg' }}">
                        {{ $pengguna->status == 'active' ? 'Aktif' : 'Nonaktif' }}
                      </span>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 mt-3">
                      <strong>Email:</strong><br>
                      {{ $pengguna->email }}
                    </div>
                    <div class="col-md-6 mt-3">
                      <strong>Username:</strong><br>
                      {{ $pengguna->username }}
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 mt-3">
                      <strong>Nomor HP:</strong><br>
                      {{ $pengguna->nomor_hp }}
                    </div>
                    <div class="col-md-6 mt-3">
                      <strong>Nomor Whatsapp:</strong><br>
                      {{ $pengguna->nomor_hp2 }}
                    </div>

                  </div>
                  <div class="row">
                    <div class="col-md-6 mt-3">
                      <strong>Terakhir Login:</strong><br>
                      {{ $pengguna->last_logged_in ? $pengguna->last_logged_in->format('d/m/Y H:i') : 'Belum pernah' }}
                    </div>
                    <div class="col-md-6 mt-3">
                      <strong>Terakhir Sync:</strong><br>
                      {{ $pengguna->last_synced_at ? $pengguna->last_synced_at->format('d/m/Y H:i') : 'Belum sync' }}
                    </div>
                  </div>
                </div>
              </div>

              <div class="d-flex flex-column-reverse flex-md-row-reverse bd-highlight mt-4">
                @can('user_edit')
                  <a href="{{ route('pengguna.edit', $pengguna) }}" class="btn btn-warning ms-md-2 mt-2">
                    <i class="ti ti-edit fs-2 me-1"></i>
                    Edit Pengguna
                  </a>
                @endcan
                <a href="{{ route('pengguna.index') }}" class="btn btn-default ms-md-2 mt-2">
                  <i class="ti ti-arrow-back-up fs-2 me-1"></i>
                  Kembali
                </a>
              </div>
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
