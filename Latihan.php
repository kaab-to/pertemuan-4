<?php
declare(strict_types=1);

// TUGAS 4 + 5: 'hobi' SENGAJA tidak dideklarasikan sebagai property,
// sehingga akses ke $obj->hobi ditangani magic method.
class Latihan {
    private array $atribut = [];

    private function jejak(string $teks): void {
        if (defined('DEMO_LIFECYCLE') && DEMO_LIFECYCLE) echo "   [$teks]\n";
    }

    public function __set(string $nama, mixed $nilai): void {
        $this->jejak("__set('$nama')");
        $this->atribut[$nama] = $nilai;
    }
    public function __get(string $nama): mixed {
        $this->jejak("__get('$nama')");
        return $this->atribut[$nama] ?? null;
    }
    public function __isset(string $nama): bool {
        $this->jejak("__isset('$nama')");
        return isset($this->atribut[$nama]);
    }
    public function __unset(string $nama): void {
        $this->jejak("__unset('$nama')");
        unset($this->atribut[$nama]);
    }

    // TUGAS 5: hanya satu nama method yang diizinkan: tampilHobi
    public function __call(string $nama, array $argumen): mixed {
        if ($nama === 'tampilHobi' && count($argumen) === 0) {
            return 'Hobi: ' . ($this->atribut['hobi'] ?? '(belum diisi)');
        }
        throw new BadMethodCallException('Method tidak tersedia: ' . $nama);
    }
}
