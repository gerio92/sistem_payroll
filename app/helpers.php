<?php
function terbilang($angka) {
    $angka = (float)$angka;
    $bilangan = [
        '', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh',
        'sebelas', 'dua belas', 'tiga belas', 'empat belas', 'lima belas', 'enam belas', 'tujuh belas', 'delapan belas', 'sembilan belas'
    ];

    if ($angka < 20) {
        return $bilangan[(int)$angka];
    } elseif ($angka < 100) {
        return $bilangan[(int)($angka / 10)] . ' puluh ' . $bilangan[$angka % 10];
    } elseif ($angka < 200) {
        return 'seratus ' . terbilang($angka - 100);
    } elseif ($angka < 1000) {
        return $bilangan[(int)($angka / 100)] . ' ratus ' . terbilang($angka % 100);
    } elseif ($angka < 2000) {
        return 'seribu ' . terbilang($angka - 1000);
    } elseif ($angka < 1000000) {
        return terbilang((int)($angka / 1000)) . ' ribu ' . terbilang($angka % 1000);
    } elseif ($angka < 1000000000) {
        return terbilang((int)($angka / 1000000)) . ' juta ' . terbilang($angka % 1000000);
    } else {
        return 'Angka terlalu besar';
    }
}
