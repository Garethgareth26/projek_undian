onmessage = function(e) {
    const vouchers = e.data;

    // Contoh operasi berat: filter voucher dengan status tertentu
    const filteredVouchers = vouchers.filter(voucher => voucher.status === 0);

    // Kirim hasil kembali ke main thread
    postMessage(filteredVouchers);
}
