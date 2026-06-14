@extends('layouts.admin')
@section('title', 'Order F&B')
@section('subtitle', 'Kelola order masuk Grand Paijo\'s Nusantara Hotel')

@section('content')

<div class="grid grid-cols-3 gap-5">
    @foreach(['queue' => ['label'=>'Antrian','color'=>'gray'], 'processing' => ['label'=>'Diproses','color'=>'amber'], 'done' => ['label'=>'Selesai','color'=>'green']] as $status => $info)
    <div class="bg-white dark:bg-white/4 border border-gray-100 dark:border-white/8 rounded-2xl overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-50 dark:border-white/5 flex items-center justify-between">
            <h3 class="text-sm font-semibold text-gray-800 dark:text-white">{{ $info['label'] }}</h3>
            <span class="text-xs px-2.5 py-1 rounded-full font-medium
                         {{ $info['color'] === 'gray'  ? 'bg-gray-100 dark:bg-white/8 text-gray-600 dark:text-white/40' : '' }}
                         {{ $info['color'] === 'amber' ? 'bg-amber-50 dark:bg-amber-500/15 text-amber-700 dark:text-amber-300' : '' }}
                         {{ $info['color'] === 'green' ? 'bg-green-50 dark:bg-green-500/15 text-green-700 dark:text-green-300' : '' }}">
                {{ $orders->where('status', $status)->count() }} order
            </span>
        </div>
        <div class="divide-y divide-gray-50 dark:divide-white/5">
            @foreach($orders->where('status', $status) as $order)
            <div class="p-4">
                <div class="flex items-start justify-between mb-2">
                    <span class="text-xs font-mono font-semibold text-purple-600 dark:text-purple-400">
                        {{ $order->order_code }}
                    </span>
                    <span class="text-xs text-gray-400 dark:text-white/30">
                        Kamar {{ $order->room_number ?? '-' }}
                    </span>
                </div>
                <div class="space-y-1 mb-3">
                    @foreach($order->items as $item)
                    <div class="flex justify-between text-xs text-gray-500 dark:text-white/40">
                        <span>{{ $item->menu->name }} x{{ $item->quantity }}</span>
                        <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm font-bold text-gray-800 dark:text-white">
                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                    </span>
                    @if($status !== 'done')
                    <form method="POST" action="{{ route('admin.fnb-orders.updateStatus', $order) }}">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="{{ $status === 'queue' ? 'processing' : 'done' }}">
                        <button type="submit"
                                class="text-xs px-3 py-1.5 rounded-lg font-medium text-white transition-all hover:opacity-90 active:scale-95"
                                style="background: linear-gradient(135deg, #7C3AED, #4F46E5)">
                            {{ $status === 'queue' ? 'Proses' : 'Selesaikan' }}
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach
</div>

@endsection