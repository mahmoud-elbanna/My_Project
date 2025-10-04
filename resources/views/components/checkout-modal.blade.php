<div id="checkoutModal" 
     class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 justify-center items-center z-50">
    <div class="bg-white w-full max-w-lg rounded-lg shadow-lg p-6 relative">
        {{-- Title --}}
        <h2 class="text-2xl font-bold mb-4 text-gray-800">إتمام عملية الشراء</h2>

        {{-- Close Button --}}
        <button onclick="closeCheckoutModal()" 
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl">
            &times;
        </button>

        {{-- Checkout Form --}}
        <form action="{{ route('orders.complete.details') }}" method="POST" class="space-y-4">
            @csrf

            {{-- hidden order_id --}}
            <input type="hidden" id="checkoutOrderId" name="order_id">

            {{-- Full Name --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1">الاسم الكامل</label>
                <input type="text" name="full_name" required 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300">
            </div>

            {{-- Phone --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1">رقم الهاتف</label>
                <input type="text" name="phone" required 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300">
            </div>

            {{-- Address --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1">العنوان</label>
                <textarea name="address" required 
                          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300"></textarea>
            </div>

            {{-- Payment Method --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1">طريقة الدفع</label>
                <select name="payment_method" required 
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300">
                    <option value="cash">كاش</option>
                    <option value="credit_card">بطاقة ائتمان</option>
                    <option value="paypal">PayPal</option>
                </select>
            </div>

            {{-- Buttons --}}
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeCheckoutModal()" 
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg shadow">
                    إلغاء
                </button>
                <button type="submit" 
                        class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg shadow">
                    تأكيد الطلب
                </button>
            </div>
        </form>
    </div>
</div>
