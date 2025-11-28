<x-app-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-primary leading-tight">
            {{ __('Kelola Wallet & Tabungan') }}
        </h2>
    </x-slot>

    <div class="py-6" x-data="{ showEditModal: false, showTopupModal: false, selectedWallet: null }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Buat Wallet Baru</h3>
                    <form action="{{ route('wallet.store') }}" method="POST"
                        class="flex flex-col md:flex-row gap-4 items-end">
                        @csrf

                        <div class="w-full">
                            <x-input-label for="account_name" :value="__('Atas Nama')" />
                            <x-text-input id="account_name" class="block mt-1 w-full" type="text" name="account_name"
                                placeholder="e.g. John Doe" :value="old('account_name')" />
                        </div>

                        <div class="w-full">
                            <x-input-label for="bank_name" :value="__('Nama Bank atau Wallet')" />
                            <x-text-input id="bank_name" class="block mt-1 w-full" type="text" name="bank_name"
                                placeholder="e.g. BCA, Dana, ShopeePay" :value="old('bank_name')" />
                        </div>

                        <div class="w-full">
                            <x-input-label for="balance" :value="__('Saldo Awal')" />
                            <x-text-input id="balance" class="block mt-1 w-full" type="number" name="balance"
                                :value="old('balance', 0)" />
                        </div>

                        <button type="submit"
                            class="bg-primary text-light px-4 py-2 rounded-md hover:bg-dark transition">Simpan</button>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Daftar Wallet</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Atas Nama</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama Wallet</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Saldo</th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($wallets as $wallet)
                                    @php $isMine = $wallet->user_id === auth()->id(); @endphp
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm font-semibold rounded-full text-primary">
                                                {{ $wallet->account_name ?? 'Pasangan' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $wallet->bank_name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 font-bold">
                                            {{ formatRupiah($wallet->balance) }}
                                        </td>

                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex justify-end items-center gap-2">

                                            <button
                                                @click='showTopupModal = true; selectedWallet = @json($wallet)'
                                                class="text-primary hover:text-dark bg-light border border-primary px-2 py-1 rounded">
                                                + Topup / Adjust
                                            </button>

                                            @if ($isMine)
                                                <div class="flex justify-between items-center gap-2">
                                                    <button
                                                        @click='showEditModal = true; selectedWallet = @json($wallet)'
                                                        class="ml-2 text-indigo-600 hover:text-indigo-900">
                                                        Edit
                                                    </button>

                                                    <form action="{{ route('wallet.destroy', $wallet) }}" method="POST"
                                                        onsubmit="return confirm('Hapus Wallet ini? Transaksi lama akan tetap ada tapi tanpa nama Wallet.');">
                                                        @csrf @method('DELETE')

                                                        <button type="submit"
                                                            class="text-red-600 hover:text-red-900 ml-2 block">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                                    </path>
                                                </svg>
                                                <h3 class="text-lg font-medium text-gray-900">Belum ada Wallet</h3>
                                                <p class="text-sm text-gray-500">Silakan tambahkan dompet atau
                                                    rekening baru pada form di atas.
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @include('wallet.partials.__add-balance')
            @include('wallet.partials.__edit')
        </div>
    </div>
</x-app-layout>
