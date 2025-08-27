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
        // Statistik laporan untuk kepala sekolah
        $laporanPerBulan = Laporan::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->groupBy('bulan')
            ->get();

        $laporanHarianPerBulan = LaporanHarian::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->groupBy('bulan')
            ->get();

        return view('kepala_sekolah.laporan-statistik', compact(
            'laporanPerBulan',
            'laporanHarianPerBulan'
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

        return view('kepala_sekolah.penilaian-overview', compact(
            'nilaiRataRata',
            'nilaiTertinggi',
            'nilaiTerendah',
            'distribusiCollection'
        ));
    }
}
