<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Data Produk</h2>
            <a href="{{ route('products.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm">
                + Tambah Produk
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if (session('success'))
            <div class="p-3 bg-green-100 text-green-700 rounded-md text-sm">
                {{ session('success') }}
            </div>
            @endif

            <x-card>
                <table class="w-full text-sm text-left">
                    <thead class="text-gray-500 border-b">
                        <tr>
                            <th class="py-2">Kode</th>
                            <th class="py-2">Nama</th>
                            <th class="py-2">Kategori</th>
                            <th class="py-2">Satuan</th>
                            <th class="py-2">Harga</th>
                            <th class="py-2">Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                        <tr class="border-b">
                            <td class="py-2">{{ $product->code ?? '-' }}</td>
                            <td class="py-2">{{ $product->name }}</td>
                            <td class="py-2">{{ $product->category->name }}</td>
                            <td class="py-2">{{ $product->unit }}</td>
                            <td class="py-2">{{ $product->formatted_price }}</td>
                            <td class="py-2">
                                {{ $product->stock }}
                                <x-badge :stock="$product->stock" class="ml-2" />
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-4 text-center text-gray-500">Belum ada data produk.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>