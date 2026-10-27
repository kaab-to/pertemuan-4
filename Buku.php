<?php
declare(strict_types=1);

// TUGAS 2 + 3
class Buku {
    public function __construct(
        public string $judul,
        public string $penulis,
        public int $tahun
    ) {}

    public function tampilInfo(): string {
        return "\"{$this->judul}\" karya {$this->penulis} ({$this->tahun})";
    }

    // TUGAS 3: destructor demonstrasi (hanya bersuara saat mode demo).
    public function __destruct() {
        if (defined('DEMO_LIFECYCLE') && DEMO_LIFECYCLE) {
            echo "   [destructor] Buku \"{$this->judul}\" dihancurkan\n";
        }
    }
}
