<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Kartu Ringkasan Atas
        // Kolom 'total' diganti menjadi 'total_price'
        $omzetHariIni = Transaction::whereDate('created_at', today())->sum('total_price');
        $omzetKemarin = Transaction::whereDate('created_at', today()->subDay())->sum('total_price');
        $transaksiHariIni = Transaction::whereDate('created_at', today())->count();
        $produkMenipis = Product::where('stock', '<', 10)->count();

        // 2. Grafik Tren Penjualan 7 Hari Terakhir
        // SUM(total) diganti menjadi SUM(total_price)
        $tren = Transaction::selectRaw('DATE(created_at) as tanggal, SUM(total_price) as total')
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // Menyusun array tanggal 7 hari terakhir secara berurutan
        $labelTren = collect(range(6, 0))->map(fn($i) => now()->subDays($i)->format('Y-m-d'));

        // Memetakan total penjualan ke setiap tanggal (isi 0 jika tidak ada transaksi)
        $dataTren = $labelTren->map(function ($tanggal) use ($tren) {
            return optional($tren->firstWhere('tanggal', $tanggal))->total ?? 0;
        });

        // 3. Daftar Produk Terlaris
        $produkTerlaris = Product::select('products.name')
            ->selectRaw('SUM(transaction_details.qty) as total_qty')
            ->join('transaction_details', 'transaction_details.product_id', '=', 'products.id')
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        // Mengirimkan semua variabel ke file dashboard.blade.php
        return view('dashboard', compact(
            'omzetHariIni',
            'omzetKemarin',
            'transaksiHariIni',
            'produkMenipis',
            'labelTren',
            'dataTren',
            'produkTerlaris'
        ));
    }
}
