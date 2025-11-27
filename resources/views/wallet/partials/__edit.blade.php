<div x-show="showEditModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
    <div class="flex items-center justify-center min-h-screen px-4 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="showEditModal = false">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <div
            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">

            <form x-bind:action="'/wallet/' + selectedWallet?.id" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                    Edit Wallet
                </h3>

                <div class="mb-4">
                    <label for="edit_account_name" class="block text-sm font-medium text-gray-700">Atas Nama</label>
                    <input type="text" name="account_name" id="edit_account_name"
                        x-bind:value="selectedWallet?.account_name" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>

                <div class="mb-4">
                    <label for="edit_bank_name" class="block text-sm font-medium text-gray-700">Nama Wallet</label>
                    <input type="text" name="bank_name" id="edit_bank_name" x-bind:value="selectedWallet?.bank_name"
                        required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" @click="showEditModal = false"
                        class="bg-gray-200 px-4 py-2 rounded text-gray-700 hover:bg-gray-300 transition">Batal</button>
                    <button type="submit"
                        class="bg-primary text-light px-4 py-2 rounded-md hover:bg-dark transition">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
