@extends('layouts.admin')
@section('title', 'Menu F&B')
@section('subtitle', 'Kelola menu makanan & minuman Grand Paijo\'s Nusantara Hotel')

@section('topbar-actions')
<button onclick="document.getElementById('modal-tambah').classList.remove('hidden')"
        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold text-white transition-all duration-200 hover:opacity-90 active:scale-95"
        style="background: linear-gradient(135deg, #7C3AED, #4F46E5)">
    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
    </svg>
    Tambah Menu
</button>
@endsection

@section('content')

{{-- Filter --}}
<div class="flex items-center gap-3 mb-5">
    <form method="GET" class="flex items-center gap-2">
        <select name="category" onchange="this.form.submit()"
                class="text-sm px-3 py-2 rounded-xl border border-gray-200 dark:border-white/10
                       bg-white dark:bg-white/5 text-gray-700 dark:text-white/70
                       focus:outline-none focus:ring-2 focus:ring-purple-500/30">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
            </option>
            @endforeach
        </select>
        <select name="status" onchange="this.form.submit()"
                class="text-sm px-3 py-2 rounded-xl border border-gray-200 dark:border-white/10
                       bg-white dark:bg-white/5 text-gray-700 dark:text-white/70
                       focus:outline-none focus:ring-2 focus:ring-purple-500/30">
            <option value="" class="text-purple-500">Semua Status</option>
            <option value="available"   {{ request('status') == 'available'   ? 'selected' : '' }}>Tersedia</option>
            <option value="unavailable" {{ request('status') == 'unavailable' ? 'selected' : '' }}>Habis</option>
        </select>
    </form>
</div>

{{-- Menu Grid --}}
<div class="grid grid-cols-3 gap-4 mb-6">
    @forelse($menus as $menu)
    <div class="bg-white dark:bg-white/4 border border-gray-100 dark:border-white/8 rounded-2xl overflow-hidden hover:shadow-md transition-shadow duration-200 group">
        {{-- Image --}}
        <div class="h-36 bg-gradient-to-br from-purple-50 to-violet-50 dark:from-purple-900/20 dark:to-violet-900/20 relative overflow-hidden">
            @if($menu->image)
            <img src="{{ asset('storage/'.$menu->image) }}" alt="{{ $menu->name }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
            @else
            <div class="w-full h-full flex items-center justify-center">
                <span class="text-4xl opacity-40">🍽️</span>
            </div>
            @endif
            <span class="absolute top-3 right-3 text-xs px-2.5 py-1 rounded-full font-medium
                         {{ $menu->status === 'available'
                            ? 'bg-green-500 text-white'
                            : 'bg-red-500 text-white' }}">
                {{ $menu->status === 'available' ? 'Tersedia' : 'Habis' }}
            </span>
        </div>
        {{-- Content --}}
        <div class="p-4">
            <div class="flex items-start justify-between gap-2 mb-1">
                <h3 class="text-sm font-semibold text-gray-800 dark:text-white leading-tight">{{ $menu->name }}</h3>
            </div>
            <p class="text-xs text-gray-400 dark:text-white/30 mb-3">{{ $menu->category->name }}</p>
            <div class="flex items-center justify-between">
                <span class="text-sm font-bold text-purple-600 dark:text-purple-400">
                    Rp {{ number_format($menu->price, 0, ',', '.') }}
                </span>
                <div class="flex items-center gap-1">
                    <button onclick="openEditMenu({{ $menu->id }}, '{{ addslashes($menu->name) }}', {{ $menu->fnb_category_id }}, {{ $menu->price }}, '{{ $menu->status }}')"
                            class="p-1.5 rounded-lg text-gray-400 hover:text-purple-500 hover:bg-purple-50 dark:hover:bg-purple-500/10 transition-colors duration-150">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </button>
                    <form method="POST" action="{{ route('admin.fnb-menus.destroy', $menu) }}"
                          onsubmit="return confirm('Hapus menu ini?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="p-1.5 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 transition-colors duration-150">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-3 py-16 text-center text-gray-400 dark:text-white/25 text-sm">
        Belum ada menu. Tambah menu pertama!
    </div>
    @endforelse
</div>

{{ $menus->links() }}

{{-- Modal Tambah --}}
<div id="modal-tambah" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="document.getElementById('modal-tambah').classList.add('hidden')"></div>
    <div class="relative bg-white dark:bg-[#1A1535] border border-gray-100 dark:border-white/10 rounded-2xl p-6 w-full max-w-md shadow-2xl">
        <h3 class="text-sm font-semibold text-gray-800 dark:text-white mb-5">Tambah Menu Baru</h3>
        <form method="POST" action="{{ route('admin.fnb-menus.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @include('admin.fnb.menus._form')
            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="flex-1 py-2.5 rounded-xl text-sm font-semibold text-white hover:opacity-90 transition-opacity"
                        style="background: linear-gradient(135deg, #7C3AED, #4F46E5)">
                    Simpan
                </button>
                <button type="button" onclick="document.getElementById('modal-tambah').classList.add('hidden')"
                        class="flex-1 py-2.5 rounded-xl text-sm font-medium text-gray-600 dark:text-white/60
                               border border-gray-200 dark:border-white/10 hover:bg-gray-50 dark:hover:bg-white/5">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openEditMenu(id, name, categoryId, price, status) {
    // Implementasi edit modal — bisa dikembangkan nanti
    alert('Edit menu ID: ' + id);
}
</script>
@endpush