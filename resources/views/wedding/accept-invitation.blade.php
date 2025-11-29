<x-app-layout>
    <x-slot:title>Terima Undangan</x-slot:title>

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-md overflow-hidden sm:rounded-xl text-center">

            <div class="mb-6 flex justify-center">
                <div class="bg-pink-50 p-4 rounded-full">
                    <svg class="w-12 h-12 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                        </path>
                    </svg>
                </div>
            </div>

            <h2 class="text-2xl font-bold text-gray-900">Undangan Pernikahan</h2>
            <p class="text-gray-500 mt-2 text-sm">
                Anda diundang untuk bergabung mengelola project pernikahan:
            </p>

            <div class="my-8 bg-gray-50 p-5 rounded-xl border border-gray-100">
                <h3 class="font-bold text-xl text-primary">{{ $wedding->title }}</h3>
                <p class="text-sm text-gray-500 mt-1 mb-4">
                    📅 {{ \Carbon\Carbon::parse($wedding->wedding_date)->translatedFormat('d F Y') }}
                </p>

                <div class="pt-4 border-t border-gray-200">
                    <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Undangan ditujukan untuk:
                    </p>
                    <p class="text-sm font-bold text-gray-800 mt-1">{{ $wedding->partner_email }}</p>
                </div>
            </div>

            <form action="{{ route('wedding.accept-process', $token) }}" method="POST">
                @csrf
                <button type="submit"
                    class="w-full bg-primary text-light py-3 rounded-lg font-bold text-lg hover:bg-dark transition shadow-lg transform hover:-translate-y-0.5">
                    Terima & Bergabung ❤️
                </button>
            </form>

            <div class="mt-6">
                <a href="{{ route('dashboard') }}"
                    class="text-sm text-gray-400 hover:text-gray-600 underline decoration-gray-300 decoration-1 underline-offset-4">
                    Batal / Kembali ke Dashboard
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
