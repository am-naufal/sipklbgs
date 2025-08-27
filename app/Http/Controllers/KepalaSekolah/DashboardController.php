<?php

namespace App\Http\Controllers\KepalaSekolah;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Industri;
use App\Models\Pembimbing;
use App\Models\Penempatan;
use App\Models\Laporan;
use App\Models\LaporanHarian;
use App\Models\Penilaian;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik utama
        $totalSiswas = Siswa::count();
        $totalPembimbings = Pembimbing::count();
        $totalIndustris = Industri::count();
        $totalPenempatans = Penempatan::count();
        $totalLaporanHarian = LaporanHarian::count();
        $totalLaporanAkhir = Laporan::count();
        $totalPenilaian = Penilaian::count();

        // Statistik khusus kepala sekolah
        $siswaAktifPKL = Penempatan::where('status', 'active')->count();
        $siswaSelesaiPKL = Penempatan::where('status', 'completed')->count();

        // Calculate average nilai_akhir programmatically
        $rataRataNilai = 0;
        $penilaians = Penilaian::all();
        if ($penilaians->count() > 0) {
            $totalNilai = 0;
            $count = 0;
            foreach ($penilaians as $penilaian) {
                $nilaiAkhir = $penilaian->nilaiAkhir();
                if (!is_null($nilaiAkhir)) {
                    $totalNilai += $nilaiAkhir;
                    $count++;
                }
            }
            $rataRataNilai = $count > 0 ? $totalNilai / $count : 0;
        }

        // Statistik per industri
        $industriStats = Industri::withCount(['penempatans as total_siswa' => function ($query) {
            $query->where('status', 'active');
        }])->get();

        return view('kepala_sekolah.dashboard', compact(
            'totalSiswas',
            'totalPembimbings',
            'totalIndustris',
            'totalPenempatans',
            'totalLaporanHarian',
            'totalLaporanAkhir',
            'totalPenilaian',
            'siswaAktifPKL',
            'siswaSelesaiPKL',
            'rataRataNilai',
            'industriStats'
        ));
    }

    public function laporanStatistik()
    {
        // Statistik dasar
        $totalLaporanHarian = LaporanHarian::count();
        $totalLaporanAkhir = Laporan::count();
        $totalSiswas = Siswa::count();

        // Rasio laporan per siswa
        $rasioLaporanPerSiswa = $totalSiswas > 0 ? ($totalLaporanHarian + $totalLaporanAkhir) / $totalSiswas : 0;

        // Persentase kelengkapan (asumsi: setiap siswa harus punya minimal 1 laporan akhir dan beberapa laporan harian)
        $siswaDenganLaporan = Siswa::whereHas('laporan')->orWhereHas('laporanHarian')->count();
        $persentaseKelengkapan = $totalSiswas > 0 ? ($siswaDenganLaporan / $totalSiswas) * 100 : 0;

        // Status laporan harian
        $statusLaporanHarian = [
            'diterima' => LaporanHarian::where('status_validasi', 'diterima')->count(),
            'ditolak' => LaporanHarian::where('status_validasi', 'ditolak')->count(),
            'menunggu' => LaporanHarian::where('status_validasi', 'menunggu')->orWhereNull('status_validasi')->count()
        ];

        // Status laporan akhir
        $statusLaporanAkhir = [
            'diterima' => Laporan::where('status_validasi', 'diterima')->count(),
            'ditolak' => Laporan::where('status_validasi', 'ditolak')->count(),
            'menunggu' => Laporan::where('status_validasi', 'menunggu')->orWhereNull('status_validasi')->count()
        ];

        // Tren bulanan
        $trenBulanan = [];
        $months = range(1, 12);
        foreach ($months as $month) {
            $laporanHarianCount = LaporanHarian::whereMonth('created_at', $month)->count();
            $laporanAkhirCount = Laporan::whereMonth('created_at', $month)->count();

            $trenBulanan[] = [
                'bulan' => date('F', mktime(0, 0, 0, $month, 1)),
                'laporan_harian' => $laporanHarianCount,
                'laporan_akhir' => $laporanAkhirCount,
                'total' => $laporanHarianCount + $laporanAkhirCount,
                'trend' => 'stabil' // Simple trend calculation
            ];
        }

        // Top contributors
        $topContributors = Siswa::withCount(['laporanHarian', 'laporans'])
            ->orderByRaw('(laporan_harian_count + laporans_count) DESC')
            ->limit(10)
            ->get();

        return view('kepala_sekolah.laporan_statistik', compact(
            'totalLaporanHarian',
            'totalLaporanAkhir',
            'rasioLaporanPerSiswa',
            'persentaseKelengkapan',
            'statusLaporanHarian',
            'statusLaporanAkhir',
            'trenBulanan',
            'topContributors'
        ));
    }

    public function penilaianOverview()
    {
        // Overview penilaian untuk kepala sekolah
        // Calculate nilai rata-rata, tertinggi, dan terendah programmatically
        $nilaiRataRata = 0;
        $nilaiTertinggi = 0;
        $nilaiTerendah = null;
        $penilaians = Penilaian::all();

        if ($penilaians->count() > 0) {
            $totalNilai = 0;
            $count = 0;

            foreach ($penilaians as $penilaian) {
                $nilaiAkhir = $penilaian->nilaiAkhir();
                if (!is_null($nilaiAkhir)) {
                    $totalNilai += $nilaiAkhir;
                    $count++;
                    if (is_null($nilaiTerendah) || $nilaiAkhir < $nilaiTerendah) {
                        $nilaiTerendah = $nilaiAkhir;
                    }
                    if ($nilaiAkhir > $nilaiTertinggi) {
                        $nilaiTertinggi = $nilaiAkhir;
                    }
                }
            }
            $nilaiRataRata = $count > 0 ? $totalNilai / $count : 0;
        }

        // Calculate distribution of nilai_akhir programmatically
        $distribusiNilai = [];
        $penilaians = Penilaian::all();

        foreach ($penilaians as $penilaian) {
            $nilaiAkhir = $penilaian->nilaiAkhir();
            if (!is_null($nilaiAkhir)) {
                $rangeNilai = floor($nilaiAkhir / 10) * 10;
                if (!isset($distribusiNilai[$rangeNilai])) {
                    $distribusiNilai[$rangeNilai] = 0;
                }
                $distribusiNilai[$rangeNilai]++;
            }
        }

        // Convert to collection format similar to the original query
        $distribusiCollection = collect();
        foreach ($distribusiNilai as $range => $jumlah) {
            $distribusiCollection->push((object)[
                'range_nilai' => $range,
                'jumlah' => $jumlah
            ]);
        }
        $distribusiCollection = $distribusiCollection->sortBy('range_nilai');

        // Calculate additional statistics for the view
        $rataRataTeknis = Penilaian::avg('nilai_teknis') ?? 0;
        $totalTeknis = Penilaian::whereNotNull('nilai_teknis')->count();
        $totalPenilaian = Penilaian::count();

        // Calculate average non-technical score using the model method
        $totalNonTeknis = 0;
        $rataRataNonTeknis = 0;
        $penilaiansWithNonTeknis = Penilaian::where(function ($query) {
            $query->whereNotNull('disiplin')
                ->orWhereNotNull('kerjasama')
                ->orWhereNotNull('inisiatif')
                ->orWhereNotNull('tanggung_jawab')
                ->orWhereNotNull('kebersihan');
        })->get();

        if ($penilaiansWithNonTeknis->count() > 0) {
            $totalNonTeknis = $penilaiansWithNonTeknis->count();
            $sumNonTeknis = 0;
            foreach ($penilaiansWithNonTeknis as $penilaian) {
                $sumNonTeknis += $penilaian->rataRataNonTeknis() ?? 0;
            }
            $rataRataNonTeknis = $sumNonTeknis / $totalNonTeknis;
        }

        // Get top performers - get all and sort by calculated final score
        $allPenilaians = Penilaian::with(['siswa', 'penempatan.industri'])->get();
        $topPerformers = $allPenilaians->sortByDesc(function ($penilaian) {
            return $penilaian->nilaiAkhir() ?? 0;
        })->take(10);

        return view('kepala_sekolah.penilaian_overview', compact(
            'nilaiRataRata',
            'nilaiTertinggi',
            'nilaiTerendah',
            'distribusiNilai',
            'rataRataTeknis',
            'totalTeknis',
            'rataRataNonTeknis',
            'totalNonTeknis',
            'topPerformers',
            'totalPenilaian'
        ));
    }
}
