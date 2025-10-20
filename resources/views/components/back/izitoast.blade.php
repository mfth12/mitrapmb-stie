  {{-- from controller -> blade flash hijau --}}
  @if (session()->has('success'))
    <script>
      iziToast.success({
        title: 'Berhasil.',
        message: '{{ Session('success') }}',
        position: 'topCenter',
        timeout: 3000,
      });
    </script>
  @endif

  {{-- from controller -> blade flash kuning --}}
  @if (session()->has('warning'))
    <script>
      iziToast.warning({
        title: 'Ok.',
        message: '{{ Session('warning') }}',
        position: 'topCenter',
        timeout: 3000,
      });
    </script>
  @endif

  {{-- from controller -> blade flash merah --}}
  @if (session()->has('error'))
    <script>
      iziToast.error({
        title: 'Eror.',
        message: '{{ Session('error') }}',
        position: 'topCenter',
        timeout: 3000,
      });
    </script>
  @endif

  {{-- from controller -> blade flash merah --}}
  @if ($errors->has('errordetail'))
    <script>
      iziToast.error({
        title: 'Eror.',
        message: '{{ $errors->first('errordetail') }}',
        position: 'topCenter',
        timeout: 3000,
      });
    </script>
  @endif

  {{-- from controller -> blade flash info --}}
  @if (session()->has('info'))
    <script>
      iziToast.info({
        title: 'Info.',
        message: '{{ Session('info') }}',
        position: 'topCenter',
        timeout: 3000,
      });
    </script>
  @endif

  <script>
    @foreach (session('toasts', collect())->toArray() as $toast)
      var options = {
        title: `{{ $toast['title'] }}`,
        message: `{{ $toast['message'] }}`,
        messageColor: `{{ $toast['messageColor'] }}`,
        messageSize: `{{ $toast['messageSize'] }}`,
        titleLineHeight: `{{ $toast['titleLineHeight'] }}`,
        messageLineHeight: `{{ $toast['messageLineHeight'] }}`,
        position: `{{ $toast['position'] }}`,
        titleSize: `{{ $toast['titleSize'] }}`,
        titleColor: `{{ $toast['titleColor'] }}`,
        closeOnClick: `{{ $toast['closeOnClick'] }}`,
      };

      var type = `{{ $toast['type'] }}`;

      show(type, options);
    @endforeach

    function show(type, options) {
      if (type === 'info') {
        iziToast.info(options);
      } else if (type === 'success') {
        iziToast.success(options);
      } else if (type === 'warning') {
        iziToast.warning(options);
      } else if (type === 'error') {
        iziToast.error(options);
      } else {
        iziToast.show(options);
      }
    }
  </script>


  {{-- Toast notification dengan iziToast - Pemanggilan via js per page --}}
  <script>
    function showToast(message, type = 'info') {
      const config = {
        message: message,
        position: 'topCenter',
        timeout: 3000,
      };

      switch (type) {
        case 'success':
          iziToast.success({
            ...config,
            title: 'Sukses',
            icon: 'ti ti-check'
          });
          break;
        case 'error':
          iziToast.error({
            ...config,
            title: 'Error',
          });
          break;
        case 'warning':
          iziToast.warning({
            ...config,
            title: 'Peringatan',
          });
          break;
        default:
          iziToast.info({
            ...config,
            title: 'Info',
          });
      }
    }
  </script>

  <script>
    function showToast(message, type = 'info') {
      const toast = document.createElement('div');
      toast.className = `toast show align-items-center text-bg-info border-0 position-fixed custom-toast`;
      toast.innerHTML = `
      <div class="d-flex">
        <div class="toast-body">${message}</div>
        <button type="button" class="btn-close btn-close-white me-3 m-auto" data-bs-dismiss="toast"></button>
      </div>
    `;

      document.body.appendChild(toast);

      // Efek animasi muncul
      setTimeout(() => toast.classList.add('showing'), 50);

      // Hapus setelah 3 detik (menghilang ke bawah)
      setTimeout(() => {
        toast.classList.remove('showing');
        toast.classList.add('hiding');
        setTimeout(() => toast.remove(), 500);
      }, 3000);
    }
  </script>

  {{ session()->forget('toasts') }}
