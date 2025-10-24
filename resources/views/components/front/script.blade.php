{{-- SCRIPT UNTUK FRONT --}}
<div id="pwaforwp-add-to-home-click" style="background-color:#d2dfeb"
  class="pwaforwp-footer-prompt pwaforwp-bounceInUp pwaforwp-animated"><span id="pwaforwp-prompt-close"
    class="pwaforwp-prompt-close"></span>
  <p>Pasang <strong>{{ konfigs('NAMA_SISTEM') }}</strong> di perangkat Anda</p>
  <div class="btn btn-sm btn-primary">Pasang</div>
</div>

<script id="pwaforwp-download-js-js-extra">
  var pwaforwp_download_js_obj = {
    "force_rememberme": "0"
  };
</script>
{{-- TAMABAHAN JQUERY CDN --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
@vite(['resources/js/pwaforwp-video.js'])
@vite(['resources/js/pwaforwp-download.js'])
@vite(['resources/js/pwa-register-sw.js'])
