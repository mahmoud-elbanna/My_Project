function openOrderModal(productId, productName) {
    document.getElementById('orderProductId').value = productId;
    document.getElementById('orderProductName').value = productName;
    document.getElementById('orderQuantity').value = 1;

    const modal = document.getElementById('orderModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeOrderModal() {
    const modal = document.getElementById('orderModal');
    modal.classList.remove('flex');
    modal.classList.add('hidden');
}
