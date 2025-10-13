@extends('components.theme.back')

@section('container')
  <div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <h2 class="page-title">Detail Pengguna - {{ $pengguna->name }}</h2>
          <div class="page-pretitle">Informasi lengkap pengguna</div>
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
              <div class="row mb-4">
                <div class="col-md-3 text-center">
                  <div class="avatar avatar-xl mb-3"
                    style="background-image: url({{ $pengguna->avatar ? env('URL_ASSET_SIAKAD') . '/' . $pengguna->avatar : asset('img/default.png') }})">
                  </div>

                  <h4>{{ $pengguna->name }}
                    <span>
                      @if ($pengguna->siakad_id)
                        <i class="ti ti-rosette-discount-check-filled fs-3 text-primary" data-bs-toggle="tooltip"
                          data-bs-placement="top" title="Akun Siakad"></i>
                      @endif
                    </span>
                  </h4>

                  <span class="">({{ $pengguna->getRoleNames()->first() }})</span>
                </div>
                <div class="col-md-9">
                  <div class="row">
                    <div class="col-md-6">
                      <strong>Asal Sekolah:</strong><br>
                      {{ $pengguna->asal_sekolah }}
                    </div>
                    <div class="col-md-6">
                      <strong>Status:</strong><br>
                      <span
                        class="badge {{ $pengguna->status == 'active' ? 'bg-success text-success-fg' : 'bg-danger text-danger-fg' }}">
                        {{ $pengguna->status == 'active' ? 'Aktif' : 'Nonaktif' }}
                      </span>
                    </div>
                  </div>
                  <div class="row mt-3">
                    <div class="col-md-6">
                      <strong>Email:</strong><br>
                      {{ $pengguna->email }}
                    </div>
                    <div class="col-md-6">
                      <strong>Username:</strong><br>
                      {{ $pengguna->username }}
                    </div>
                  </div>
                  <div class="row mt-3">
                    <div class="col-md-6">
                      <strong>Nomor HP:</strong><br>
                      {{ $pengguna->nomor_hp }}
                    </div>
                    
                  </div>
                  <div class="row mt-3">
                    <div class="col-md-6">
                      <strong>Terakhir Login:</strong><br>
                      {{ $pengguna->last_logged_in ? $pengguna->last_logged_in->format('d/m/Y H:i') : 'Belum pernah' }}
                    </div>
                    <div class="col-md-6">
                      <strong>Terakhir Sync:</strong><br>
                      {{ $pengguna->last_synced_at ? $pengguna->last_synced_at->format('d/m/Y H:i') : 'Belum sync' }}
                    </div>
                  </div>
                </div>
              </div>

              <div class="mt-4">
                @can('user_edit')
                  <a href="{{ route('pengguna.edit', $pengguna) }}" class="btn btn-warning me-1">
                    <i class="ti ti-edit fs-2 me-1"></i>
                    Edit Pengguna
                  </a>
                @endcan
                <a href="{{ route('pengguna.index') }}" class="btn btn-default">
                  <i class="ti ti-arrow-back-up fs-2 me-1"></i>
                  Kembali ke Daftar</a>
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
