<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Struk Pembayaran</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md border">
            <div class="text-center mb-4">
                <h3 class="font-bold text-lg">TOKO SINAR SEJAHTERA</h3>
                <p class="text-xs text-gray-500">Struk Transaksi Penjualan</p>
                <hr class="my-2">
            </div>

            <div class="text-xs space-y-1 mb-4">
                <p><strong>ID Transaksi:</strong> #{{ $transaction->id }}</p>
                <p><strong>Tanggal:</strong> {{ $transaction->created_at->format('d-m-Y H:i') }}</p>
                <p><strong>Kasir:</strong> {{ $transaction->user->name ?? 'Kasir' }}</p>
            </div>

            <table class="w-full text-xs mb-4">
                <thead>
                    <tr class="border-b text-left">
                        <th class="pb-1">Produk</th>
                        <th class="pb-1 text-center">Qty</th>
                        <th class="pb-1 text-right">Harga</th>
                        <th class="pb-1 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaction->details as $detail)
                    <tr class="border-b">
                        <td class="py-1">{{ $detail->product->name }}</td>
                        <td class="py-1 text-center">{{ $detail->qty }}</td>
                        <td class="py-1 text-right">Rp{{ number_format($detail->price, 0, ',', '.') }}</td>
                        <td class="py-1 text-right">Rp{{ number_format($detail->price * $detail->qty, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-xs space-y-1 border-t pt-2">
                <div class="flex justify-between font-semibold">
                    <span>Total</span>
                    <span>Rp{{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Bayar</span>
                    <span>Rp{{ number_format($transaction->pay, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between font-bold text-indigo-600">
                    <span>Kembalian</span>
                    <span>Rp{{ number_format($transaction->change, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="mt-6 text-center">
                <a href="{{ route('pos.index') }}" class="inline-block bg-indigo-600 text-white px-4 py-2 rounded text-xs hover:bg-indigo-700">
                    Kembali ke Kasir
                </a>
            </div>
        </div>
    </div>
</x-app-layout>