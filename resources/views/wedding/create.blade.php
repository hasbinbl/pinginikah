<x-app-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-primary leading-tight">{{ __('Mulai Project Pernikahan') }}</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('wedding.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 space-y-6">

                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                                <span class="bg-light text-primary p-2 rounded-full">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </span>
                                Informasi Dasar
                            </h3>

                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <x-input-label for="title" :value="__('Judul Project Wedding')" />
                                    <x-text-input id="title" class="block mt-1 w-full" type="text" name="title"
                                        placeholder="Contoh: The Wedding of Hasbi & Zahra" :value="old('title')"
                                        autofocus />
                                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="date" :value="__('Tanggal Pernikahan')" />
                                    <x-text-input id="date" class="block mt-1 w-full" type="date" name="date"
                                        :value="old('date')" />
                                    <x-input-error :messages="$errors->get('date')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                                <span class="bg-light text-primary p-2 rounded-full">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                </span>
                                Peran Saya
                            </h3>

                            <div class="grid grid-cols-2 gap-4">
                                <label class="cursor-pointer relative group">
                                    <input type="radio" name="role" value="groom" class="peer sr-only"
                                        {{ old('role') == 'groom' ? 'checked' : '' }}>
                                    <div
                                        class="rounded-xl border-2 border-gray-100 bg-gray-50 p-4 text-center hover:bg-white hover:border-gray-300 peer-checked:border-primary peer-checked:bg-light peer-checked:ring-1 peer-checked:ring-primary transition-all">
                                        <div class="text-4xl mb-2">🤵‍♂️</div>
                                        <div class="font-bold text-gray-700">Groom</div>
                                        <div class="text-gray-500 text-xs italic">Calon Mempelai
                                            Pria</div>
                                    </div>
                                    <div class="absolute top-2 right-2 hidden peer-checked:block text-primary">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </label>

                                <label class="cursor-pointer relative group">
                                    <input type="radio" name="role" value="bride" class="peer sr-only"
                                        {{ old('role') == 'bride' ? 'checked' : '' }}>
                                    <div
                                        class="rounded-xl border-2 border-gray-100 bg-gray-50 p-4 text-center hover:bg-white hover:border-gray-300 peer-checked:border-pink-500 peer-checked:bg-pink-50 peer-checked:ring-1 peer-checked:ring-pink-500 transition-all">
                                        <div class="text-4xl mb-2">👰‍♀️</div>
                                        <div class="font-bold text-gray-700">Bride
                                        </div>
                                        <div class="text-gray-500 text-xs italic">Calon Mempelai
                                            Wanita</div>
                                    </div>
                                    <div class="absolute top-2 right-2 hidden peer-checked:block text-pink-500">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </label>
                            </div>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>

                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6" x-data="initSegments()">
                            <h3 class="text-lg font-bold text-gray-800 mb-2 flex items-center gap-2">
                                <span class="bg-light text-primary p-2 rounded-full">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                        </path>
                                    </svg>
                                </span>
                                Rencana Bagian Acara
                            </h3>
                            <p class="text-sm text-gray-500 mb-4 ml-11">Bagian acara yang ingin diatur budgetnya.</p>

                            <div class="space-y-3 pl-0 lg:pl-11">
                                <template x-for="(segment, index) in segments" :key="index">
                                    <div class="flex gap-2">
                                        <div class="relative w-full">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-400 text-sm" x-text="index + 1 + '.'"></span>
                                            </div>
                                            <input type="text" name="segments[]" x-model="segments[index]" required
                                                class="block w-full pl-8 rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm"
                                                placeholder="Nama Acara (Contoh: Lamaran)">
                                        </div>
                                        <button type="button" @click="remove(index)" x-show="segments.length > 1"
                                            class="text-gray-400 hover:text-red-500 p-2 transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </template>

                                <button type="button" @click="add()"
                                    class="mt-2 inline-flex items-center text-sm text-primary font-semibold hover:text-gray-900 transition">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Tambah Bagian Lain
                                </button>
                                <x-input-error :messages="$errors->get('segments')" class="mt-2" />
                            </div>
                        </div>

                    </div>

                    <div class="lg:col-span-1">
                        <div class="sticky top-6">
                            <div class="bg-white border border-gray-200 overflow-hidden shadow-sm sm:rounded-xl p-6"
                                x-data="initPartner()">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="bg-light text-primary p-2 rounded-full">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                            </path>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-800">Undang Pasangan</h3>
                                </div>

                                <p class="text-sm text-gray-500 mb-4 leading-relaxed">
                                    Cari email pasanganmu yang sudah terdaftar untuk mengelola budget bersama.
                                </p>

                                <input type="hidden" name="partner_email" x-model="selectedEmail">
                                <input type="hidden" name="_partner_name_label" x-model="selectedName">

                                <div class="relative" x-show="!selectedEmail">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <input type="text"
                                        class="block w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm"
                                        placeholder="Ketik email / nama pasangan..." x-model="query"
                                        @input.debounce.300ms="search()">

                                    <div x-show="results.length > 0"
                                        class="absolute z-20 w-full bg-white shadow-xl rounded-lg border border-gray-100 mt-2 max-h-60 overflow-y-auto"
                                        style="display: none;" x-transition.opacity.duration.200ms>
                                        <ul>
                                            <template x-for="user in results" :key="user.id">
                                                <li @click="selectUser(user)"
                                                    class="px-4 py-3 hover:bg-gray-50 cursor-pointer border-b border-gray-50 last:border-0 flex justify-between items-center group">
                                                    <div>
                                                        <p class="text-sm font-bold text-gray-800 group-hover:text-primary"
                                                            x-text="user.name"></p>
                                                        <p class="text-xs text-gray-500" x-text="user.email"></p>
                                                    </div>
                                                    <span
                                                        class="text-xs font-semibold text-primary bg-gray-100 px-2 py-1 rounded group-hover:bg-primary group-hover:text-white transition">Pilih</span>
                                                </li>
                                            </template>
                                        </ul>
                                    </div>
                                </div>

                                <div x-show="selectedEmail" style="display: none;" x-transition>
                                    <div
                                        class="bg-white border border-accent rounded-xl p-4 relative overflow-hidden shadow-sm">
                                        <div class="absolute top-0 right-0 p-2">
                                            <button type="button" @click="resetSelection()"
                                                class="text-gray-400 hover:text-red-500 transition rounded-full p-1 hover:bg-red-50">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </div>

                                        <div class="flex items-center gap-3">
                                            <div
                                                class="h-10 w-10 rounded-full bg-accent text-primary flex items-center justify-center font-bold text-lg">
                                                <span x-text="selectedName ? selectedName.charAt(0) : '?'"></span>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500 uppercase font-bold tracking-wide">
                                                    Terpilih</p>
                                                <p class="text-sm font-bold text-gray-900 truncate w-40"
                                                    x-text="selectedName"></p>
                                                <p class="text-xs text-gray-500 truncate w-40" x-text="selectedEmail">
                                                </p>
                                            </div>
                                        </div>
                                        <div class="mt-3 flex items-center gap-1 text-xs text-primary font-medium">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Siap diundang
                                        </div>
                                    </div>
                                </div>

                                <x-input-error :messages="$errors->get('partner_email')" class="mt-2" />

                                <div class="mt-8 pt-6 border-t border-gray-100">
                                    <button type="submit"
                                        class="w-full flex justify-center items-center gap-2 px-6 py-3 bg-primary text-white rounded-xl hover:bg-dark transition font-bold shadow-lg transform hover:-translate-y-0.5 text-sm uppercase">
                                        <span>Buat Project</span>
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                        </svg>
                                    </button>

                                    <a href="{{ route('dashboard') }}"
                                        class="block text-center mt-4 text-sm text-gray-500 hover:text-gray-800">
                                        Batal
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <script>
        // 1. DATA SEGMENT
        function initSegments() {
            // Ambil data old dari server dengan aman
            // Jika old('segments') null, pakai default ['Akad Nikah', 'Resepsi']
            let data = @json(old('segments', ['Akad Nikah', 'Resepsi']));

            return {
                segments: data,
                add() {
                    this.segments.push('');
                },
                remove(index) {
                    this.segments.splice(index, 1);
                }
            }
        }

        // 2. DATA PARTNER SEARCH
        function initPartner() {
            // Ambil data old email & name
            // Jika ada old email, set sebagai default value
            let oldEmail = @json(old('partner_email'));
            let oldName = @json(old('_partner_name_label'));

            return {
                query: '',
                results: [],
                selectedEmail: oldEmail || null,
                selectedName: oldName || (oldEmail ? "User (" + oldEmail + ")" : null), // Fallback name kalau label hilang

                search() {
                    if (this.query.length < 3) {
                        this.results = [];
                        return;
                    }
                    fetch(`/api/users/search?q=${this.query}`)
                        .then(res => res.json())
                        .then(data => {
                            this.results = data;
                        });
                },
                selectUser(user) {
                    this.selectedEmail = user.email;
                    this.selectedName = user.name;
                    this.results = [];
                    this.query = '';
                },
                resetSelection() {
                    this.selectedEmail = null;
                    this.selectedName = null;
                    this.query = '';
                }
            }
        }
    </script>
</x-app-layout>
