import Swal from 'sweetalert2';

// SweetAlert2 global configuration
window.Swal = Swal;

// Toast configuration
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 6000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
    }
});

window.Toast = Toast;

// SweetAlert2 helper functions
window.showAlert = function (config) {
    return Swal.fire(config);
};

window.showSuccess = function (message, title = 'Sukses') {
    return Swal.fire({
        icon: 'success',
        title: title,
        text: message,
        timer: 4000,
        showConfirmButton: false
    });
};

window.showError = function (message, title = 'Error') {
    return Swal.fire({
        icon: 'error',
        title: title,
        text: message,
        timer: 6000
    });
};

window.showWarning = function (message, title = 'Peringatan') {
    return Swal.fire({
        icon: 'warning',
        title: title,
        text: message,
        timer: 6000
    });
};

window.showInfo = function (message, title = 'Informasi') {
    return Swal.fire({
        icon: 'info',
        title: title,
        text: message,
        timer: 6000,
        showConfirmButton: true
    });
};

window.showConfirm = function (config) {
    const defaultConfig = {
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal'
    };

    return Swal.fire({ ...defaultConfig, ...config });
};

// Delete confirmation
window.showDeleteConfirmation = function (callback, itemName = 'data') {
    return Swal.fire({
        title: 'Apakah Anda yakin?',
        text: `Anda akan menghapus ${itemName}. Tindakan ini tidak dapat dibatalkan!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed && typeof callback === 'function') {
            callback();
        }
        return result;
    });
};