@extends('layouts.admin')
@section('title', 'Tambah Kamar')
@section('subtitle', 'Grand Paijo\'s Nusantara Hotel')

@section('content')
<div class="max-w-xl">
    <div class="bg-white dark:bg-white/4 border border-gray-100 dark:border-white/8 rounded-2xl p-6">
        <form method="POST" action="{{ route('admin.rooms.store') }}" class="space-y-5">
            @csrf
            @include('admin.rooms._form')
            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="px-6 py-2.5 rounded-xl text-sm font-semibold text-white transition-all duration-200 hover:opacity-90 active:scale-95"
                        style="background: linear-gradient(135deg, #7C3AED, #4F46E5)">
                    Simpan Kamar
                </button>
                <a href="{{ route('admin.rooms.index') }}"
                   class="px-6 py-2.5 rounded-xl text-sm font-medium text-gray-600 dark:text-white/60
                          border border-gray-200 dark:border-white/10 hover:bg-gray-50 dark:hover:bg-white/5
                          transition-colors duration-150">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection