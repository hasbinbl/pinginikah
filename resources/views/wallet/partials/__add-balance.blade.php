<div x-show="showTopupModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
    <div class="flex items-center justify-center min-h-screen px-4 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="showTopupModal = false">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <div
            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form x-bind:action="'/wallet/' + selectedWallet?.id + '/add-balance'" method="POST" class="p-6">
                @csrf

                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                    Update Saldo: <span x-text="selectedWallet?.bank_name"></span>
                </h3>

                <div class="mb-4">
                    <x-input-label for="substract" :value="__('Aksi')" />
                    <select name="type"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="add">Tambah Saldo (+)</option>
                        <option value="subtract">Kurangi Saldo (-)</option>
                    </select>
                    <x-input-error :messages="$errors->get('substract')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="amount" :value="__('Nominal (IDR)')" />
                    <x-text-input id="amount" class="block mt-1 w-full" type="number" name="amount"
                        :value="old('amount', 0)" />
                    <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" @click="showTopupModal = false"
                        class="bg-gray-200 px-4 py-2 rounded text-gray-700 hover:bg-gray-300 transition">Batal</button>
                    <button type="submit"
                        class="bg-primary text-light px-4 py-2 rounded-md hover:bg-dark transition">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
