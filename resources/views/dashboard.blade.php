<x-app-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-primary leading-tight">
                Dashboard
            </h2>
            @if ($wedding)
                <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                    Our Wedding Project ❤️
                </span>
            @endif
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if ($wedding)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-green-500">
                        <div class="p-6">
                            <p class="text-sm font-medium text-gray-500">Total Tabungan (Wallets)</p>
                            <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ formatRupiah($totalBalance) }}</h3>
                            <p class="text-xs text-green-600 mt-2 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Dana Tersedia
                            </p>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-primary">
                        <div class="p-6">
                            <p class="text-sm font-medium text-gray-500">Estimasi Total Biaya</p>
                            {{-- TODO: Nanti ambil real dari $wedding->segments->sum(...) --}}
                            <h3 class="text-2xl font-bold text-gray-800 mt-1">Rp 120.000.000</h3>
                            <p class="text-xs text-primary mt-2">Target Budget</p>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-secondary">
                        <div class="p-6">
                            <p class="text-sm font-medium text-gray-500">Sudah Dibayar (Completed)</p>
                            {{-- TODO: Nanti ambil real dari database --}}
                            <h3 class="text-2xl font-bold text-gray-800 mt-1">Rp 15.500.000</h3>
                            <p class="text-xs text-secondary mt-2">12% Terbayar</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-light border border-secondary rounded-lg p-6 text-center">
                    <h3 class="text-2xl font-bold text-primary">Selamat Datang di 💍pinginikah. Wedding
                        Planner!👰‍♀️🤵‍♂️</h3>
                    <p class="text-primary mt-1 mb-4">Mulai perjalanan persiapan pernikahanmu dengan membuat project
                        baru.</p>
                    <a href="{{ route('wedding.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-light uppercase tracking-widest hover:bg-dark active:bg-dark focus:outline-none focus:border-primary focus:ring ring-primary disabled:opacity-25 transition ease-in-out duration-150">
                        + Buat Project Wedding
                    </a>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-yellow-400">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Harga Emas (Per Gram)</p>
                                <h3 class="text-2xl font-bold text-gray-800 mt-1">
                                    @if ($goldPrice)
                                        Rp {{ number_format($goldPrice->price_per_gram, 0, ',', '.') }}
                                    @else
                                        <span class="text-gray-400 text-lg">Belum ada data</span>
                                    @endif
                                </h3>
                                <p class="text-xs text-gray-400 mt-1">Ref: MetalPriceAPI</p>
                            </div>
                            <div class="p-3 bg-yellow-100 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>

                        <div class="border-t pt-4">
                            @if ($isRefreshedToday)
                                <button disabled
                                    class="w-full bg-gray-300 text-gray-500 font-semibold py-2 px-4 rounded cursor-not-allowed flex justify-center items-center gap-2">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Terupdate
                                </button>
                                <p class="text-xs text-center text-gray-400 mt-2">
                                    Terakhir diupdate : {{ formatDateTime($goldPrice->updated_at) }}
                                </p>
                            @else
                                <form action="{{ route('dashboard.refreshGold') }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full bg-primary hover:bg-dark text-light font-semibold py-2 px-4 rounded transition duration-150 flex justify-center items-center gap-2">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        Update Harga
                                    </button>
                                </form>

                                <div class="text-center mt-2">
                                    <p class="text-xs text-gray-500 mt-1 italic">
                                        @if ($goldPrice && $goldPrice->updated_at)
                                            Terakhir diupdate: {{ formatDateTime($goldPrice->updated_at) }}
                                        @else
                                            Klik untuk update harga emas hari ini
                                        @endif
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                @if ($wedding)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-bold text-gray-800">Wallet & Tabungan</h3>
                                <a href="{{ route('wallets.index') }}"
                                    class="bg-primary rounded py-1 px-3 text-sm text-light hover:bg-dark font-medium">
                                    + Kelola Wallet
                                </a>
                            </div>

                            <div class="space-y-4">
                                @forelse($wallets as $wallet)
                                    <div
                                        class="flex justify-between items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                        <div class="flex items-center gap-3">
                                            @php
                                                $isGoldWallet = stripos($wallet->name, 'emas') !== false;
                                                $iconColor = $isGoldWallet
                                                    ? 'text-yellow-600 bg-yellow-100'
                                                    : 'text-blue-600 bg-blue-100';
                                            @endphp

                                            <div class="{{ $iconColor }} p-2 rounded">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-700">{{ $wallet->name }}</p>
                                                <p class="text-xs text-gray-500">Updated:
                                                    {{ formatDate($wallet->updated_at) }}</p>
                                            </div>
                                        </div>
                                        <span
                                            class="font-bold text-gray-800">{{ formatRupiah($wallet->balance) }}</span>
                                    </div>
                                @empty
                                    <div class="flex items-center justify-center py-4 text-gray-500">
                                        <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded">
                                            Belum ada Wallet terhubung
                                        </span>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                @else
                    <div
                        class="bg-white border border-dashed border-secondary rounded-lg p-6 flex flex-col justify-center items-center text-center">
                        <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        <h4 class="text-gray-500 font-semibold text-xl">Dompet Bersama</h4>
                        <p class="text-sm text-gray-400 mt-1">Buat project wedding dulu untuk menghubungkan dompet
                            pasangan.
                        </p>
                    </div>
                @endif
            </div>

            @if ($wedding)
                <h3 class="text-lg font-bold text-gray-800 mt-6 px-1">Rincian Progress Wedding</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h4 class="font-bold text-gray-800">Akad Nikah</h4>
                                    <p class="text-xs text-gray-500 mt-1">Mahar, Penghulu, Cincin</p>
                                </div>
                                <span class="bg-accent text-primary text-xs font-bold px-2 py-1 rounded">On
                                    Progress</span>
                            </div>

                            <div class="mb-4">
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-gray-600">Terbayar</span>
                                    <span class="font-bold text-gray-800">Rp 5.500.000</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-secondary h-2.5 rounded-full" style="width: 25%"></div>
                                </div>
                                <p class="text-xs text-right text-gray-400 mt-1">dari Rp 22.000.000</p>
                            </div>

                            <button
                                class="w-full text-sm text-primary border border-primary rounded py-1 hover:bg-primary hover:text-light transition">Detail
                                Checklist</button>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h4 class="font-bold text-gray-800">Resepsi</h4>
                                    <p class="text-xs text-gray-500 mt-1">Catering, Venue, Dekor</p>
                                </div>
                                <span
                                    class="bg-gray-100 text-gray-600 text-xs font-bold px-2 py-1 rounded">Pending</span>
                            </div>

                            <div class="mb-4">
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-gray-600">Terbayar</span>
                                    <span class="font-bold text-gray-800">Rp 0</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-indigo-600 h-2.5 rounded-full" style="width: 0%"></div>
                                </div>
                                <p class="text-xs text-right text-gray-400 mt-1">dari Rp 80.000.000</p>
                            </div>

                            <button
                                class="w-full text-sm text-primary border border-primary rounded py-1 hover:bg-primary hover:text-light transition">Detail
                                Checklist</button>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h4 class="font-bold text-gray-800">Seserahan</h4>
                                    <p class="text-xs text-gray-500 mt-1">Baju, Sepatu, Makeup</p>
                                </div>
                                <span class="bg-green-100 text-green-700 text-xs font-bold px-2 py-1 rounded">Done
                                    50%</span>
                            </div>

                            <div class="mb-4">
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-gray-600">Terbayar</span>
                                    <span class="font-bold text-gray-800">Rp 10.000.000</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-secondary h-2.5 rounded-full" style="width: 50%"></div>
                                </div>
                                <p class="text-xs text-right text-gray-400 mt-1">dari Rp 20.000.000</p>
                            </div>

                            <button
                                class="w-full text-sm text-primary border border-primary rounded py-1 hover:bg-primary hover:text-light transition">Detail
                                Checklist</button>
                        </div>
                    </div>
                    {{-- Copy untuk Resepsi dan Seserahan di sini ... --}}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
