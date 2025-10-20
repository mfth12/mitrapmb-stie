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
  