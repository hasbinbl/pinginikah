<x-app-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-primary leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (!$wedding)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-8 text-center">
                        <div
                            class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-light mb-4 border border-accent">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                                stroke="currentColor" class="h-8 w-8 text-primary">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-2xl text-primary">Belum ada Project</h3>
                        <p class="text-gray-500 mb-6 italic">Ayo segera mulai rencanakan pernikahan impianmu bersama
                            pasangan sekarang.</p>

                        <a href="{{ route('wedding.create') }}"
                            class="text-xs inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md text-white uppercase tracking-widest hover:bg-dark transition">
                            + Buat Project Wedding
                        </a>
                    </div>
                </div>
            @elseif($wedding->status === 'pending')
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-primary">
                    <div class="p-8 text-center">
                        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-light mb-4">
                            <svg class="h-8 w-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>

                        <h3 class="text-2xl font-bold text-primary">Menunggu Respon Pasangan ⏳</h3>
                        <p class="text-gray-500 mt-1">
                            Undangan telah dikirim ke notifikasi aplikasi milik
                            <strong>{{ $wedding->partner_email }}</strong>.
                        </p>
                    </div>
                </div>
            @else
                <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6 flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">{{ $wedding->title }}</h1>
                        <p class="text-gray-500 text-sm mt-1">
                            📅 {{ \Carbon\Carbon::parse($wedding->wedding_date)->translatedFormat('d F Y') }}
                        </p>
                    </div>
                    <div class="text-right">
                        <span class="bg-indigo-100 text-primary text-xs font-bold px-3 py-1 rounded-full">
                            Active Project
                        </span>
                    </div>
                </div>

                <div x-data="{
                    activeTab: '{{ $wedding->segments->first()->id ?? 0 }}',
                    showAddSegmentModal: false
                }">

                    <div class="flex items-center justify-between mb-4 overflow-x-auto">
                        <div class="flex space-x-2 bg-gray-100 p-1 rounded-lg">
                            @foreach ($wedding->segments as $segment)
                                <button @click="activeTab = '{{ $segment->id }}'"
                                    :class="activeTab == '{{ $segment->id }}' ? 'bg-white text-primary shadow' :
                                        'text-gray-500 hover:text-gray-700'"
                                    class="px-4 py-2 rounded-md text-sm font-medium transition-all duration-200 whitespace-nowrap">
                                    {{ $segment->name }}
                                </button>
                            @endforeach
                        </div>

                        <button @click="showAddSegmentModal = true"
                            class="ml-2 bg-primary text-light px-3 py-2 rounded-md text-sm hover:bg-dark flex items-center gap-1 whitespace-nowrap">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Bagian
                        </button>
                    </div>

                    <div class="bg-white shadow-sm sm:rounded-lg min-h-[300px]">
                        @forelse($wedding->segments as $segment)
                            <div x-show="activeTab == '{{ $segment->id }}'" class="p-6" style="display: none;">

                                <div class="flex justify-between items-center border-b pb-4 mb-4">
                                    <h3 class="text-lg font-bold text-gray-800">Rincian: {{ $segment->name }}</h3>

                                    <form action="{{ route('wedding-segment.destroy', $segment) }}" method="POST"
                                        onsubmit="return confirm('Yakin hapus bagian {{ $segment->name }}? Semua item didalamnya akan terhapus!');">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="text-red-500 text-xs hover:text-red-700 underline">
                                            Hapus Bagian Ini
                                        </button>
                                    </form>
                                </div>

                                <div class="text-center py-10 border-2 border-dashed border-gray-200 rounded-lg">
                                    <p class="text-gray-400 mb-2">Belum ada item di bagian {{ $segment->name }}</p>
                                    <button class="text-primary font-semibold hover:underline">+ Tambah Item
                                        Belanja</button>
                                </div>

                            </div>
                        @empty
                            <div class="p-10 text-center text-gray-500">
                                Belum ada bagian acara. Silakan tambah bagian baru.
                            </div>
                        @endforelse
                    </div>

                    <div x-show="showAddSegmentModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                        <div class="flex items-center justify-center min-h-screen px-4 text-center">
                            <div class="fixed inset-0 transition-opacity" aria-hidden="true"
                                @click="showAddSegmentModal = false">
                                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                            </div>
                            <div
                                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full p-6">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Tambah Bagian Acara Baru
                                </h3>
                                <form action="{{ route('wedding-segment.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="wedding_id" value="{{ $wedding->id }}">
                                    <div class="mb-4">
                                        <x-input-label for="new_segment_name" :value="__('Nama Bagian (Contoh: Pengajian, Honeymoon)')" />
                                        <x-text-input id="new_segment_name" class="block mt-1 w-full" type="text"
                                            name="name" required />
                                    </div>
                                    <div class="flex justify-end gap-2">
                                        <button type="button" @click="showAddSegmentModal = false"
                                            class="bg-gray-200 px-4 py-2 rounded text-gray-700 hover:bg-gray-300">Batal</button>
                                        <button type="submit"
                                            class="bg-primary text-light px-4 py-2 rounded-md hover:bg-dark">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            @endif

        </div>
    </div>
</x-app-layout>
