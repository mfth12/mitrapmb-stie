@php
  use Illuminate\Support\Str;
  $namaUser = Auth()->user()->nama;
  $namaPendek = Str::limit($namaUser, 22, '..');
@endphp
<div class="user-panel mt-2 pb-1 mb-1 d-flex">
  <div class="image">
    <img src="/storage/{{ Auth()->user()->detail->foto }}" class="img-circle elevation-2">
  </div>
  <div class="info">
    <a href="{{ route('profil') }}" class="d-block">{{ $namaPendek }}</a>
    <p class="text-sm d-block text-white-50 mb-0">
      <i class="fas fa-star-of-life fa-xs"></i>
      {{-- {{ 'Role: ' . Auth()->user()->level->nama_role }} --}}
      {{ 'Akses ' . ucwords(Auth()->user()->level->nama_role) }}
    </p>
  </div>
</div>
