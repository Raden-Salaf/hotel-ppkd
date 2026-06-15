<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grand Paijo's Nusantara Hotel</title>
    @vite(['resources/css/app.css'])
    <style>
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .fade-up {
            animation: fadeUp 0.8s ease forwards;
        }

        .fade-up-2 {
            animation: fadeUp 0.8s ease 0.2s forwards;
            opacity: 0;
        }

        .fade-up-3 {
            animation: fadeUp 0.8s ease 0.4s forwards;
            opacity: 0;
        }

        .float-anim {
            animation: float 4s ease-in-out infinite;
        }
    </style>
</head>

<body class="bg-[#0D0B1F] text-white">

    {{-- ── NAVBAR ── --}}
    <nav class="fixed top-0 inset-x-0 z-50 backdrop-blur-md border-b border-white/5"
        style="background: rgba(13,11,31,0.8)">
        <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg overflow-hidden bg-white/10 border border-white/20">
                    <img src="{{ asset('images/logo.png') }}" onerror="this.style.display='none'"
                        class="w-full h-full object-cover" alt="Logo">
                </div>
                <span class="text-sm font-semibold">Grand Paijo's Nusantara Hotel</span>
            </div>
            <div class="hidden md:flex items-center gap-6 text-sm text-white/60">
                <a href="#kamar" class="hover:text-white transition-colors">Kamar</a>
                <a href="#fasilitas" class="hover:text-white transition-colors">Fasilitas</a>
                <a href="#ulasan" class="hover:text-white transition-colors">Ulasan</a>
                <a href="{{ route('rooms') }}"
                    class="px-4 py-2 rounded-xl text-xs font-semibold text-white transition-all hover:opacity-90"
                    style="background: linear-gradient(135deg, #7C3AED, #4F46E5)">
                    Pesan Sekarang
                </a>
            </div>
        </div>
    </nav>

    {{-- ── HERO ── --}}
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden">
        {{-- Background --}}
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-gradient-to-br from-[#0D0B1F] via-[#1E1459] to-[#0D0B1F]"></div>
            <div class="absolute top-1/4 left-1/4 w-96 h-96 rounded-full opacity-20"
                style="background: radial-gradient(circle, #7C3AED, transparent)"></div>
            <div class="absolute bottom-1/4 right-1/4 w-80 h-80 rounded-full opacity-15"
                style="background: radial-gradient(circle, #4F46E5, transparent)"></div>
            {{-- Grid --}}
            <div class="absolute inset-0 opacity-[0.03]" style="background-image: linear-gradient(rgba(167,139,250,1) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(167,139,250,1) 1px, transparent 1px);
                    background-size: 60px 60px"></div>
        </div>

        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center">
            <div class="fade-up">
                <span class="inline-block px-4 py-1.5 rounded-full text-xs font-medium mb-6
                         bg-purple-500/20 text-purple-300 border border-purple-500/30">
                    ✦ {{ $availableCount }} kamar tersedia hari ini
                </span>
            </div>
            <h1 class="fade-up-2 text-5xl md:text-6xl font-bold leading-tight mb-6">
                Selamat Datang di<br>
                <span class="bg-clip-text text-shadow-transparent"
                    style="background: linear-gradient(100deg, #A78BFA, #818CF8, #C4B5FD)">
                    Grand Paijo's<br>Nusantara Hotel
                </span>
            </h1>
            <p class="fade-up-3 text-white/50 text-lg max-w-2xl mx-auto mb-10 leading-relaxed">
                Nikmati pengalaman menginap yang tak terlupakan dengan fasilitas premium
                dan pelayanan terbaik di jantung kota.
            </p>
            <div class="fade-up-3 flex items-center justify-center gap-4 flex-wrap">
                <a href="{{ route('rooms') }}"
                    class="px-8 py-3.5 rounded-2xl font-semibold text-white transition-all hover:opacity-90 active:scale-95 shadow-lg"
                    style="background: linear-gradient(135deg, #7C3AED, #4F46E5);
                      box-shadow: 0 0 30px rgba(124,58,237,0.4)">
                    Lihat & Pesan Kamar
                </a>
                <a href="#ulasan" class="px-8 py-3.5 rounded-2xl font-medium text-white/70 border border-white/10
                      hover:bg-white/5 hover:text-white transition-all">
                    Baca Ulasan Tamu
                </a>
            </div>
        </div>

        {{-- Scroll indicator --}}
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 float-anim">
            <div class="w-6 h-10 rounded-full border border-white/20 flex items-start justify-center pt-2">
                <div class="w-1 h-2 rounded-full bg-white/40"></div>
            </div>
        </div>
    </section>

    {{-- ── TIPE KAMAR ── --}}
    <section id="kamar" class="py-20 px-6">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <p class="text-purple-400 text-sm font-medium tracking-widest uppercase mb-3">Pilihan Kamar</p>
                <h2 class="text-3xl font-bold">Temukan Kamar Impianmu</h2>
                <p class="text-white/40 mt-3 text-sm">Tersedia berbagai tipe kamar sesuai kebutuhanmu</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($roomTypes as $type)
                    <div
                        class="group relative bg-white/4 border border-white/8 rounded-2xl overflow-hidden
                                                    hover:border-purple-500/30 hover:bg-white/6 transition-all duration-300">
                        {{-- Image placeholder --}}
                        <div class="h-48 relative overflow-hidden"
                            style="background: linear-gradient(135deg, rgba(124,58,237,0.2), rgba(79,70,229,0.2))">
                            @if($type->thumbnail)
                                <img src="{{ asset('storage/' . $type->thumbnail) }}" alt="{{ $type->name }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <span class="text-5xl opacity-30">🛏️</span>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                            <div class="absolute bottom-3 left-4">
                                <span class="text-xs px-2.5 py-1 rounded-full bg-purple-500/80 text-white font-medium">
                                    {{ $type->rooms_count }} kamar tersedia
                                </span>
                            </div>
                        </div>

                        <div class="p-5">
                            <h3 class="text-lg font-semibold mb-1">{{ $type->name }}</h3>
                            <p class="text-white/40 text-sm mb-4 leading-relaxed">{{ $type->description }}</p>

                            {{-- Fasilitas --}}
                            @if($type->facilities)
                                <div class="flex flex-wrap gap-2 mb-5">
                                    @foreach(array_slice($type->facilities, 0, 4) as $facility)
                                        <span class="text-xs px-2.5 py-1 rounded-lg bg-white/5 text-white/50 border border-white/8">
                                            {{ $facility }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif

                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-xl font-bold text-purple-400">
                                        Rp {{ number_format($type->price_per_night, 0, ',', '.') }}
                                    </span>
                                    <span class="text-xs text-white/30">/malam</span>
                                </div>
                                <a href="{{ route('rooms') }}"
                                    class="px-4 py-2 rounded-xl text-xs font-semibold text-white transition-all hover:opacity-90"
                                    style="background: linear-gradient(135deg, #7C3AED, #4F46E5)">
                                    Pesan
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── FASILITAS ── --}}
    <section id="fasilitas" class="py-20 px-6 border-t border-white/5">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <p class="text-purple-400 text-sm font-medium tracking-widest uppercase mb-3">Fasilitas</p>
                <h2 class="text-3xl font-bold">Semua yang Kamu Butuhkan</h2>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach([['🍽️', 'Restoran F&B', 'Tersedia 24 jam'], ['🏊', 'Kolam Renang', 'Outdoor & Indoor'], ['🅿️', 'Parkir Luas', 'Gratis untuk tamu'], ['📶', 'WiFi Cepat', '100 Mbps gratis'], ['🏋️', 'Gym', 'Peralatan lengkap'], ['🧖', 'Spa & Sauna', 'Relaksasi premium'], ['🎭', 'Ballroom', 'Kapasitas 500 orang'], ['🚗', 'Antar Jemput', 'Bandara & stasiun']] as [$icon, $name, $desc])
                    <div
                        class="bg-white/4 border border-white/8 rounded-2xl p-5 hover:border-purple-500/30 transition-all duration-200">
                        <div class="text-3xl mb-3">{{ $icon }}</div>
                        <div class="text-sm font-semibold mb-1">{{ $name }}</div>
                        <div class="text-xs text-white/40">{{ $desc }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── ULASAN ── --}}
    <section id="ulasan" class="py-20 px-6 border-t border-white/5">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <p class="text-purple-400 text-sm font-medium tracking-widest uppercase mb-3">Ulasan Tamu</p>
                <h2 class="text-3xl font-bold">Apa Kata Mereka?</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                @forelse($reviews as $review)
                    <div class="bg-white/4 border border-white/8 rounded-2xl p-6 hover:border-purple-500/20 transition-all">
                        <div class="flex items-center gap-1 mb-4">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-amber-400' : 'text-white/10' }}"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @endfor
                        </div>
                        <p class="text-white/60 text-sm leading-relaxed mb-5 italic">"{{ $review->comment }}"</p>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white"
                                style="background: linear-gradient(135deg, #7C3AED, #4F46E5)">
                                {{ strtoupper(substr($review->guest_name, 0, 2)) }}
                            </div>
                            <div>
                                <div class="text-sm font-medium">{{ $review->guest_name }}</div>
                                <div class="text-xs text-white/30">{{ $review->created_at->format('M Y') }}</div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center text-white/30 text-sm py-10">
                        Belum ada ulasan
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ── FOOTER ── --}}
    <footer class="border-t border-white/5 py-10 px-6">
        <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg overflow-hidden bg-white/10">
                    <img src="{{ asset('images/logo.png') }}" onerror="this.style.display='none'"
                        class="w-full h-full object-cover" alt="Logo">
                </div>
                <span class="text-sm font-medium text-white/60">Grand Paijo's Nusantara Hotel</span>
            </div>
            <p class="text-xs text-white/30">© 2026 Grand Paijo's Nusantara Hotel. All rights reserved.</p>
            <a href="{{ route('login') }}" class="text-xs text-white/20 hover:text-white/50 transition-colors">
                Staff Login →
            </a>
        </div>
    </footer>

</body>

</html>
