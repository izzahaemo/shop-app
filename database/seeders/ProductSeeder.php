<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $query = "
        INSERT INTO `products` (`id`, `name`, `price`, `img`, `desc`, `category_id`, `created_at`, `updated_at`) VALUES
        (22, 'SAMSUNG Smart LED TV 32 Inch T4500', 2060000, '1689572264_SAMSUNG Smart LED TV 32 Inch T4500.jpg', 'LED SAMSUNG 32T4500 NEW SMART TV 2020\r\nSmart TV HD 32 inch', 1, '2023-07-16 22:37:44', '2023-07-16 22:37:44'),
        (23, 'Kipas Angin Dinding NAGOYA (Wall Fan) Baling Besi 18', 239000, '1689572288.jpg', 'Warna baling kipas sesuai dengan foto yg terpajang (warna Silver). Pada saat pengiriman baling dilapisi plastic berwarna biru (bisa dikupas setelah dipasang)', 1, '2023-07-16 22:38:08', '2023-07-16 22:38:08'),
        (24, 'Sanken Supercom Rice Cooker 1L', 511000, '1689572354_Sanken Supercom Rice Cooker 1L.jpg', 'Sanken Supercom SJ-200 Rice Cooker Penanak Nasi merupakan penanak nasi serbaguna yang menggunakan material stainless untuk body dan panci. Penampilan SuperCom SANKEN terlihat elegan dan mewah. Panci stainlessnya juga terlihat elegan. Teknologi terkini SANKEN menghasilkan panci stainless yang berkualitas tinggi. Lapisan stainless tidak mengelupas, menjadikan makanan yang diolah lebih higienis dan sehat. Panci stainless anti gores, anti karat, awet, dan tidak berubah bentuk dalam jangka waktu lama.', 1, '2023-07-16 22:39:14', '2023-07-16 22:39:14'),
        (25, 'Philips Dry Iron  GC16027', 320000, '1689572393_Philips Dry Iron  GC16027.jpg', 'Affinia adalah setrika kering baru dari Philips dengan alas setrika DynaGlide, yang meluncur dengan mudah di atas kain. Alas setrika dengan ujung ramping, pegangan yang nyaman dengan tekstur dan kontrol suhu yang bisa dinaikkan, menjadikan setrika ini mudah digunakan.', 1, '2023-07-16 22:39:53', '2023-07-16 22:39:53'),
        (26, 'Ace - Soleil Kursi Lipat Grey', 219900, '1689572612_Ace - Soleil Kursi Lipat Grey.jpg', 'Desain minimalis, dapat dilipat.', 3, '2023-07-16 22:43:32', '2023-07-16 22:43:32'),
        (27, 'Bantal Aku Si Hemat', 119900, '1689572646_Bantal Aku Si Hemat.jpg', 'Pillow Si Hemat dari PillowPeople merupakan salah satu bantal kualitas terbaik yang dirancang agar Anda mendapatkan kualitas tidur sehari-hari yang lebih baik.', 3, '2023-07-16 22:44:06', '2023-07-16 22:44:06'),
        (28, 'Olymplast Classic Drawer Cabinet Laci', 1070000, '1689572691_Olymplast Classic Drawer Cabinet Laci.jpg', 'Produk Olymplast ini 100% asli buatan anak bangsa, produk Indonesia.', 3, '2023-07-16 22:44:51', '2023-07-16 22:44:51'),
        (29, 'Goland Gantungan Baju Modern Bentuk U Rak Sepatu Elegan Besi', 549000, '1689572728_Goland Gantungan Baju Modern Bentuk U Rak Sepatu Elegan Besi.jpg', 'Nama produk Goland Gantungan Baju Modern Bentuk U Rak Sepatu Elegan Bes', 3, '2023-07-16 22:45:28', '2023-07-16 22:45:28');
        ";
        DB::statement($query);
    }
}
