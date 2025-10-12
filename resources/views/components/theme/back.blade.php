<!DOCTYPE html>
<html lang="id">

<head>
  <x-back.header :title="$title" />
  <x-back.favicon />
  @yield('style')
  @yield('js_atas')
</head>

<body>
  <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/js/tabler-theme.min.js" async defer></script>

  <div class="page">
    <x-back.navbar />
    <x-back.menu />

    <div class="page-wrapper">
      @yield('container')
      <x-back.footer />
    </div>
  </div>

  <x-modal.umum />
  @yield('modals')

  <x-back.script />
  <x-back.sweetalert />
  @yield('js_bawah')
</body>

</html>
