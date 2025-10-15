@extends('components.theme.back')

@section('container')
  <div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <h2 class="page-title">Manajemen Pendaftaran</h2>
          <div class="page-pretitle">Semua pendaftaran calon mahasiswa</div>
        </div>
        <div class="col-auto ms-auto d-print-none">
          @can('pendaftaran_create')
            <a href="{{ route('pendaftaran.create') }}" class="btn btn-primary">
              <i class="ti ti-plus fs-2 me-1"></i>
              Tambah Pendaftaran
            </a>
          @endcan
        </div>
      </div>
    </div>
  </div>

  <div class="page-body">
    <div class="container-xl">
      <div class="card">
        <div class="card-body my-2">
          {{-- Form filter --}}
          <form method="GET" class="row g-3 mb-4">
            <div class="col-md-6">
              <input type="text" name="cari" class="form-control"
                placeholder="Cari nama, email, ID calon mahasiswa..." value="{{ request('cari') }}">
            </div>
            <div class="col-md-4">
              <select name="status" class="form-select">
                <option value="">Semua Status</option>
                <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Berhasil</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Gagal</option>
              </select>
            </div>
            <div class="col-md-2">
              <button type="submit" class="btn btn-default w-100">
                <i class="ti ti-filter me-1"></i>
                Filter
              </button>
            </div>
          </form>

          {{-- Tabel pendaftaran --}}
          <div class="table-responsive">
            <table class="table table-vcenter table-bordered table-striped">
              <thead>
                <tr>
                  <th>ID Calon Mhs</th>
                  <th>Nama Lengkap</th>
                  <th>Program Studi</th>
                  <th>Tahun/Gelombang</th>
                  <th>Biaya</th>
                  <th>Status</th>
                  <th>Tanggal Daftar</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($pendaftaran as $daftar)
                  <tr>
                    <td>
                      <code>{{ $daftar->id_calon_mahasiswa ?: '-' }}</code>
                    </td>
                    <td>
                      <strong>{{ $daftar->nama_lengkap }}</strong>
                      <br>
                      <small class="text-muted">{{ $daftar->email }}</small>
                    </td>
                    <td>{{ $daftar->prodi_nama }}</td>
                    <td>
                      {{ $daftar->tahun }}/{{ $daftar->gelombang }}
                      <br>
                      <small class="text-muted">Kelas: {{ $daftar->kelas }}</small>
                    </td>
                    <td>{{ $daftar->biaya_formatted }}</td>
                    <td>{!! $daftar->status_badge !!}</td>
                    <td>{{ $daftar->created_at->format('d/m/Y H:i') }}</td>
                    <td class="text-center" style="width: 1%;">
                      <div class="btn-list justify-content-center flex-nowrap">
                        <a href="{{ route('pendaftaran.show', $daftar) }}" class="btn btn-sm btn-default" title="Detail">
                          Detail
                        </a>
                        @can('pendaftaran_edit')
                          @if ($daftar->status === 'pending')
                            <a href="{{ route('pendaftaran.edit', $daftar) }}" class="btn btn-sm btn-default"
                              title="Edit">
                              Edit
                            </a>
                          @endif
                        @endcan
                        @can('pendaftaran_delete')
                          <form action="{{ route('pendaftaran.destroy', $daftar) }}" method="POST"
                            class="d-inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-default text-danger delete-btn" title="Hapus"
                              data-name="{{ $daftar->nama_lengkap }}">
                              Hapus
                            </button>
                          </form>
                        @endcan
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="8" class="text-center text-muted">Tidak ada data pendaftaran</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          {{-- Pagination --}}
          @if ($pendaftaran->hasPages())
            <div class="mt-4">
              <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="text-muted">
                  Menampilkan
                  <strong>{{ $pendaftaran->firstItem() }}</strong> -
                  <strong>{{ $pendaftaran->lastItem() }}</strong>
                  dari
                  <strong>{{ $pendaftaran->total() }}</strong>
                  data
                </div>

                <div>
                  {{ $pendaftaran->links('vendor.pagination.tabler') }}
                </div>
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
      // Delete confirmation
      document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
          const form = this.closest('form');
          const userName = this.getAttribute('data-name');

          showDeleteConfirmation(() => {
            form.submit();
          }, `pendaftaran ${userName}`);
        });
      });
    });
  </script>
@endsection
