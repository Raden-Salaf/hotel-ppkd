<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Grand Paijo's Nusantara Hotel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33%       { transform: translateY(-20px) rotate(1deg); }
            66%       { transform: translateY(-10px) rotate(-1deg); }
        }
        @keyframes floatDelay {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33%       { transform: translateY(-15px) rotate(-1deg); }
            66%       { transform: translateY(-25px) rotate(1deg); }
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes shimmer {
            0%   { background-position: -200% center; }
            100% { background-position: 200% center; }
        }
        @keyframes pulse-ring {
            0%   { transform: scale(0.8); opacity: 0.8; }
            100% { transform: scale(1.6); opacity: 0; }
        }
        @keyframes rotate-slow {
            from { transform: rotate(0deg); }
            to   { transform: rotate(360deg); }
        }
        .float-1 { animation: float 7s ease-in-out infinite; }
        .float-2 { animation: floatDelay 9s ease-in-out infinite; }
        .float-3 { animation: float 11s ease-in-out infinite reverse; }
        .fade-up-1 { animation: fadeUp 0.6s ease forwards; }
        .fade-up-2 { animation: fadeUp 0.6s ease 0.1s forwards; opacity: 0; }
        .fade-up-3 { animation: fadeUp 0.6s ease 0.2s forwards; opacity: 0; }
        .fade-up-4 { animation: fadeUp 0.6s ease 0.3s forwards; opacity: 0; }
        .shimmer-text {
            background: linear-gradient(90deg, #fff 0%, #C4B5FD 40%, #fff 60%, #A78BFA 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: shimmer 4s linear infinite;
        }
        .pulse-ring::before {
            content: '';
            position: absolute;
            inset: -8px;
            border-radius: 50%;
            border: 2px solid rgba(167,139,250,0.5);
            animation: pulse-ring 2s ease-out infinite;
        }
        .rotate-slow { animation: rotate-slow 20s linear infinite; }
        .input-group input:focus ~ label,
        .input-group input:not(:placeholder-shown) ~ label {
            transform: translateY(-22px) scale(0.78);
            color: #A78BFA;
        }
        .input-group label {
            transition: all 0.2s ease;
            transform-origin: left;
        }
    </style>
</head>
<body class="h-full bg-[#0D0B1F] overflow-hidden">

{{-- ── Background ── --}}
<div class="absolute inset-0">
    {{-- Gradient base --}}
    <div class="absolute inset-0 bg-gradient-to-br from-[#0D0B1F] via-[#1E1459] to-[#0D0B1F]"></div>

    {{-- Glow orbs --}}
    <div class="absolute top-[-10%] left-[-5%] w-[500px] h-[500px] rounded-full float-1"
         style="background: radial-gradient(circle, rgba(109,40,217,0.35) 0%, transparent 70%)"></div>
    <div class="absolute bottom-[-10%] right-[-5%] w-[600px] h-[600px] rounded-full float-2"
         style="background: radial-gradient(circle, rgba(124,58,237,0.3) 0%, transparent 70%)"></div>
    <div class="absolute top-[40%] right-[25%] w-[300px] h-[300px] rounded-full float-3"
         style="background: radial-gradient(circle, rgba(139,92,246,0.2) 0%, transparent 70%)"></div>

    {{-- Grid pattern --}}
    <div class="absolute inset-0 opacity-[0.04]"
         style="background-image: linear-gradient(rgba(167,139,250,1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(167,139,250,1) 1px, transparent 1px);
                background-size: 60px 60px"></div>

    {{-- Floating geometric shapes --}}
    <div class="absolute top-[15%] left-[10%] float-1 opacity-20">
        <div class="w-16 h-16 border border-purple-400 rounded-xl rotate-12"></div>
    </div>
    <div class="absolute top-[60%] left-[6%] float-2 opacity-15">
        <div class="w-10 h-10 border border-violet-300 rounded-full"></div>
    </div>
    <div class="absolute top-[30%] right-[8%] float-3 opacity-20">
        <div class="w-20 h-20 border border-purple-300 rounded-2xl rotate-45"></div>
    </div>
    <div class="absolute bottom-[20%] right-[12%] float-1 opacity-15">
        <div class="w-8 h-8 bg-violet-500 rounded-lg rotate-12"></div>
    </div>
    <div class="absolute bottom-[35%] left-[15%] float-2 opacity-10">
        <div class="w-24 h-24 border-2 border-purple-400 rounded-full rotate-slow"></div>
    </div>
</div>

{{-- ── Main Content ── --}}
<div class="relative z-10 min-h-screen flex">

    {{-- Left — Branding --}}
    <div class="hidden lg:flex flex-col justify-between w-[55%] p-14">
        <div class="fade-up-1">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-purple-600/30 border border-purple-500/40
                            flex items-center justify-center">
                    <img src="{{ asset('images/logo.png') }}"
                         onerror="this.style.display='none';this.nextElementSibling.style.display='flex'"
                         class="w-6 h-6 object-contain" alt="Logo">
                    <span class="text-purple-300 text-lg hidden">✦</span>
                </div>
                <span class="text-white/80 text-sm font-medium tracking-widest uppercase">
                    Grand Paijo's Nusantara Hotel
                </span>
            </div>
        </div>

        <div>
            <div class="fade-up-2">
                <p class="text-purple-300 text-sm font-medium tracking-widest uppercase mb-4">
                    Management System
                </p>
                <h1 class="text-5xl font-bold leading-tight mb-6">
                    <span class="shimmer-text">Kelola Hotel</span>
                    <br>
                    <span class="text-white">dengan Mudah</span>
                    <br>
                    <span class="text-white/40">&amp; Efisien</span>
                </h1>
            </div>
            <div class="fade-up-3">
                <p class="text-white/40 text-base leading-relaxed max-w-md">
                    Platform administrasi terintegrasi untuk mengelola kamar,
                    reservasi, F&B, dan laporan dalam satu dashboard modern.
                </p>
            </div>
            <div class="fade-up-4 flex items-center gap-6 mt-10">
                <div class="text-center">
                    <div class="text-2xl font-bold text-white">48+</div>
                    <div class="text-xs text-white/40 mt-1">Kamar</div>
                </div>
                <div class="w-px h-10 bg-white/10"></div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-white">3</div>
                    <div class="text-xs text-white/40 mt-1">Tipe Kamar</div>
                </div>
                <div class="w-px h-10 bg-white/10"></div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-white">24/7</div>
                    <div class="text-xs text-white/40 mt-1">Operasional</div>
                </div>
            </div>
        </div>

        <div class="fade-up-4">
            <p class="text-white/20 text-xs">
                © 2026 Grand Nusantara Hotel. All rights reserved.
            </p>
        </div>
    </div>

    {{-- Right — Login Form --}}
    <div class="flex-1 flex items-center justify-center p-6 lg:p-14">
        <div class="w-full max-w-[420px] fade-up-2">

            {{-- Card --}}
            <div class="relative">
                {{-- Card glow --}}
                <div class="absolute -inset-1 rounded-3xl opacity-30 blur-xl"
                     style="background: linear-gradient(135deg, #7C3AED, #4F46E5)"></div>

                <div class="relative bg-white/5 backdrop-blur-2xl border border-white/10
                            rounded-3xl p-8 shadow-2xl">

                    {{-- Logo mobile --}}
                    <div class="flex lg:hidden items-center gap-2 mb-8">
                        <div class="w-8 h-8 rounded-lg bg-purple-600/40 border border-purple-500/40
                                    flex items-center justify-center">
                            <img src="{{ asset('images/logo.png') }}"
                                 onerror="this.style.display='none'"
                                 class="w-5 h-5 object-contain" alt="Logo">
                        </div>
                        <span class="text-white/70 text-sm font-medium">Grand Nusantara Hotel</span>
                    </div>

                    {{-- Header --}}
                    <div class="mb-8">
                        <div class="relative inline-block mb-5 pulse-ring">
                            <div class="w-14 h-14 rounded-2xl flex items-center justify-center"
                                 style="background: linear-gradient(135deg, #7C3AED 0%, #4F46E5 100%)">
                                <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        </div>
                        <h2 class="text-2xl font-bold text-white mt-4">Selamat Datang</h2>
                        <p class="text-white/40 text-sm mt-1">Masuk ke panel administrasi hotel</p>
                    </div>

                    {{-- Error Alert --}}
                    @if ($errors->any())
                    <div class="mb-6 px-4 py-3 rounded-xl bg-red-500/10 border border-red-500/20
                                flex items-start gap-3">
                        <svg class="w-4 h-4 text-red-400 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                        </svg>
                        <p class="text-red-400 text-sm">{{ $errors->first() }}</p>
                    </div>
                    @endif

                    {{-- Form --}}
                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        {{-- Email --}}
                        <div>
                            <label class="block text-xs font-medium text-white/50 mb-2 uppercase tracking-wider">
                                Email
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <input type="email" name="email" value="{{ old('email') }}"
                                       placeholder="admin@hotel.com"
                                       class="w-full pl-11 pr-4 py-3 rounded-xl text-sm text-white
                                              bg-white/5 border border-white/10
                                              placeholder:text-white/20
                                              focus:outline-none focus:border-purple-500/60
                                              focus:bg-white/8 focus:ring-1 focus:ring-purple-500/30
                                              transition-all duration-200">
                            </div>
                        </div>

                        {{-- Password --}}
                        <div>
                            <label class="block text-xs font-medium text-white/50 mb-2 uppercase tracking-wider">
                                Password
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <input type="password" name="password" id="password"
                                       placeholder="••••••••"
                                       class="w-full pl-11 pr-12 py-3 rounded-xl text-sm text-white
                                              bg-white/5 border border-white/10
                                              placeholder:text-white/20
                                              focus:outline-none focus:border-purple-500/60
                                              focus:bg-white/8 focus:ring-1 focus:ring-purple-500/30
                                              transition-all duration-200">
                                <button type="button" onclick="togglePassword()"
                                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-white/30 hover:text-white/60 transition-colors">
                                    <svg id="eye-icon" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Remember --}}
                        <div class="flex items-center justify-between">
                            <label class="flex items-center gap-2.5 cursor-pointer group">
                                <div class="relative">
                                    <input type="checkbox" name="remember" class="sr-only peer">
                                    <div class="w-4 h-4 rounded border border-white/20 bg-white/5
                                                peer-checked:bg-purple-600 peer-checked:border-purple-600
                                                transition-all duration-200 flex items-center justify-center">
                                        <svg class="w-2.5 h-2.5 text-white opacity-0 peer-checked:opacity-100"
                                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                </div>
                                <span class="text-xs text-white/40 group-hover:text-white/60 transition-colors">
                                    Ingat saya
                                </span>
                            </label>
                        </div>

                        {{-- Submit --}}
                        <button type="submit"
                                class="w-full py-3 rounded-xl text-sm font-semibold text-white
                                       relative overflow-hidden group transition-all duration-300
                                       focus:outline-none focus:ring-2 focus:ring-purple-500/50">
                            <div class="absolute inset-0 transition-all duration-300"
                                 style="background: linear-gradient(135deg, #7C3AED 0%, #6D28D9 50%, #4F46E5 100%)"></div>
                            <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                                 style="background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 50%, #6366F1 100%)"></div>
                            <div class="absolute inset-0 opacity-0 group-active:opacity-30 transition-opacity duration-100 bg-white"></div>
                            <span class="relative flex items-center justify-center gap-2">
                                <span>Masuk ke Dashboard</span>
                                <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform duration-200"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </span>
                        </button>
                    </form>

                    {{-- Footer --}}
                    <div class="mt-8 pt-6 border-t border-white/5 text-center">
                        <p class="text-white/20 text-xs">
                            Grand Paijo's Nusantara Hotel Management System v1.0
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const input = document.getElementById('password');
    input.type = input.type === 'password' ? 'text' : 'password';
}
</script>
</body>
</html>