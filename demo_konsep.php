<?php
declare(strict_types=1);
require_once __DIR__ . '/Mahasiswa.php';
require_once __DIR__ . '/Buku.php';
require_once __DIR__ . '/Latihan.php';

define('DEMO_LIFECYCLE', true);
header('Content-Type: text/plain; charset=utf-8');

echo "1. Menjalankan Kontruktor\n";
$m = new Mahasiswa(nim: '123', nama: 'Alya', prodi: 'Informatika', asalSekolah: 'SMA 1',
                   semester: 3, hobi: 'Membaca', agama: 'Islam', fakultas: 'Teknik');
echo $m->ringkasan() . "\n";

echo "\n1b. Default parameter fakultas (Tugas 1)\n";
$m1 = new Mahasiswa(nim: '101', nama: 'Budi', prodi: 'Informatika', asalSekolah: 'SMA 2',
                    semester: 1, hobi: 'Gim', agama: 'Islam');                      // tanpa fakultas
$m2 = new Mahasiswa(nim: '102', nama: 'Citra', prodi: 'Sistem Informasi', asalSekolah: 'SMA 3',
                    semester: 2, hobi: 'Musik', agama: 'Kristen', fakultas: 'Teknik'); // dengan fakultas
foreach ([$m1, $m2] as $x) {
    echo $x->ringkasan() . ' | Fakultas: ' . $x->fakultas . "\n";
}
echo "Beda: objek 1 memakai default '" . $m1->fakultas . "', objek 2 memakai nilai yang dikirim '" . $m2->fakultas . "'.\n";

echo "\n2. Menjalankan OVERLOADING  Attribut\n";
$m->ukuranJaket = 'M';       // __set() karena property tidak dideklarasikan
echo $m->ukuranJaket . "\n"; // __get()
echo isset($m->ukuranJaket) ? "Ada\n" : "Tidak ada\n";
unset($m->ukuranJaket);     // __unset()

echo "\n3.Menjalankan  OVERLOADING METHOD\n";
echo $m->profilSingkat() . "\n"; // __call()

echo "\n4.Menjalankan  DESTRUCTOR\n";
echo "Lihat log error PHP setelah unset referensi terakhir.\n";
unset($m); // destructor menulis error_log, bukan menghapus record CRUD

echo "\n5. Class Buku, tiga objek (Tugas 2)\n";
$b1 = new Buku('Laskar Pelangi', 'Andrea Hirata', 2005);
$b2 = new Buku('Bumi Manusia', 'Pramoedya Ananta Toer', 1980);
$b3 = new Buku('Cantik Itu Luka', 'Eka Kurniawan', 2002);
foreach ([$b1, $b2, $b3] as $i => $b) {
    echo ($i + 1) . '. ' . $b->tampilInfo() . "\n";
}

echo "\n6. Destructor Buku: unset dengan & tanpa alias (Tugas 3)\n";
echo "a) Tanpa alias:\n";
$x = new Buku('Tanpa Alias', 'Penulis A', 2020);
echo "   unset(\$x)...\n";
unset($x);
echo "   -> destructor langsung jalan (tidak ada referensi lain)\n";

echo "b) Dengan alias:\n";
$y = new Buku('Dengan Alias', 'Penulis B', 2021);
$alias = $y;                       // object yang sama, refcount = 2
echo "   unset(\$y)...\n";
unset($y);
echo "   -> destructor BELUM jalan, alias masih memegang: " . $alias->judul . "\n";
echo "   unset(\$alias)...\n";
unset($alias);
echo "   -> destructor jalan sekarang (referensi terakhir hilang)\n";

echo "\n7. Atribut dinamis 'hobi' pada class Latihan (Tugas 4)\n";
$l = new Latihan();
$l->hobi = 'Membaca';                                   // __set
echo "   nilai: " . $l->hobi . "\n";                     // __get
echo "   isset(hobi)? " . (isset($l->hobi) ? 'Ya' : 'Tidak') . "\n";   // __isset
unset($l->hobi);                                        // __unset
echo "   isset(hobi) setelah unset? " . (isset($l->hobi) ? 'Ya' : 'Tidak') . "\n";

echo "\n8. __call() dengan satu method diizinkan (Tugas 5)\n";
$l->hobi = 'Memancing';
echo "   tampilHobi() -> " . $l->tampilHobi() . "\n";
try {
    $l->hapusSemua();   // method tidak diizinkan
} catch (BadMethodCallException $e) {
    echo "   Exception tertangkap: " . get_class($e) . ' | ' . $e->getMessage() . "\n";
}

echo "\nSelesai. Objek Buku b1-b3 dihancurkan otomatis di akhir script:\n";
