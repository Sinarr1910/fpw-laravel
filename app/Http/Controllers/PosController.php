<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Http\Requests\StorePosRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Exception;

class PosController extends Controller
{
    public function index()
    {
        $products = Product::where('stock', '>', 0)
            ->orderBy('name')
            ->get(['id', 'code', 'name', 'price', 'stock', 'unit']);

        return view('pos.index', compact('products'));
    }

    public function store(StorePosRequest $request)
    {
        try {
            // Gunakan DB Transaction agar jika gagal di tengah jalan, data di-rollback (tidak kacau)
            $transaction = DB::transaction(function () use ($request) {
                $total = 0;

                // 1. Buat data transaksi utama terlebih dahulu
                $trx = Transaction::create([
                    'invoice_number' => 'INV-' . date('YmdHis'), // INI BARIS YANG DITAMBAHKAN
                    'user_id' => Auth::id(),
                    'total_price' => 0, // Akan dihitung nanti
                    'pay' => $request->pay,
                    'change' => 0, // Akan dihitung nanti
                ]);

                // 2. Looping setiap barang yang ada di keranjang
                foreach ($request->items as $item) {
                    // Kunci baris data produk ini sementara (lockForUpdate) untuk mencegah Race Condition
                    $product = Product::where('id', $item['product_id'])->lockForUpdate()->first();

                    if ($product->stock < $item['qty']) {
                        throw new Exception('Stok ' . $product->name . ' tidak mencukupi.');
                    }

                    // Simbol kali (*) sudah dikembalikan
                    $subtotal = $product->price * $item['qty'];
                    $total += $subtotal;

                    // Simpan ke tabel detail transaksi
                    TransactionDetail::create([
                        'transaction_id' => $trx->id,
                        'product_id' => $product->id,
                        'qty' => $item['qty'],
                        'price' => $product->price,
                        'subtotal' => $subtotal,
                    ]);

                    // Kurangi stok produk
                    $product->decrement('stock', $item['qty']);
                }

                // 3. Cek apakah uang bayar cukup
                if ($request->pay < $total) {
                    throw new Exception('Uang pembayaran kurang.');
                }

                // 4. Perbarui total harga dan kembalian di transaksi utama
                $trx->update([
                    'total_price' => $total,
                    // Simbol kurang (-) sudah dikembalikan
                    'change' => $request->pay - $total,
                ]);

                return $trx;
            });

            // Jika berhasil, arahkan ke halaman struk
            return redirect()->route('pos.struk', $transaction->id);
        } catch (Exception $e) {
            // Jika ada gagal (stok kurang/uang kurang), kembali ke kasir dan bawa pesan error
            return back()->with('error', $e->getMessage());
        }
    }

    public function struk(Transaction $transaction)
    {
        // Load relasi ke detail transaksi, data produk, dan kasir yang melayani
        $transaction->load(['details.product', 'user']);

        return view('pos.struk', compact('transaction'));
    }
}
