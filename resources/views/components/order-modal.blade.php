<!-- Order Modal -->
<div id="orderModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white p-6 rounded-xl shadow-lg w-96">
        <h2 class="text-xl font-bold mb-4 text-gray-800">Place Order</h2>
        
        <form id="orderForm" action="{{ route('orders.store') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" id="orderProductId">

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Product</label>
                <input type="text" id="orderProductName" class="w-full border-gray-300 rounded-lg p-2" disabled>
            </div>

            <div class="mb-4">
                <label for="quantity" class="block text-gray-700 font-semibold">Quantity</label>
                <input type="number" name="quantity" id="orderQuantity" value="1" min="1" 
                       class="w-full border-gray-300 rounded-lg p-2" required>
            </div>

            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeOrderModal()" 
                        class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                    Confirm Order
                </button>
            </div>
        </form>
    </div>
</div>

<script>
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
</script>
