document.addEventListener('DOMContentLoaded', (event) => {
    const toastEl = document.getElementById('error');
    if (toastEl) {
        const toast = new bootstrap.Toast(toastEl);
        toast.show();
    }
});