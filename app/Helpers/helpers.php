<?php

use Carbon\Carbon;

if (!function_exists('formatRupiah')) {
    /**
     * Format angka ke Rupiah
     * Contoh: 1000000 -> Rp 1.000.000
     */
    function formatRupiah($number)
    {
        $number = floatval($number);
        return 'Rp ' . number_format($number, 0, ',', '.');
    }
}

if (!function_exists('formatDate')) {
    /**
     * Mengubah tanggal jadi format Indo
     * Input: 2024-11-27
     * Output: 27 November 2024
     */
    function formatDate($date)
    {
        if (!$date) return '-';
        return Carbon::parse($date)->locale('id')->translatedFormat('d F Y');
    }
}

if (!function_exists('formatDateTime')) {
    /**
     * Mengubah tanggal & waktu
     * Input: 2024-11-27 14:30:00
     * Output: 27 November 2024, 14:30 WIB
     */
    function formatDateTime($date)
    {
        if (!$date) return '-';
        return Carbon::parse($date)->locale('id')->translatedFormat('d F Y, H:i') . ' WIB';
    }
}
