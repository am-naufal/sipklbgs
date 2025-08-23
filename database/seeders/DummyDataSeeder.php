<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Siswa;
use App\Models\Industri;
use App\Models\Pembimbing;
use App\Models\Penempatan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $industriUser = User::create([
            'name' => 'PT Maju Jaya',
            'email' => 'industri@pkl.com',
            'password' => Hash::make('password'),
            'role' => 'industri'
        ]);

        // Industri
        $industri = Industri::create([
            'user_id' => $industriUser->id,
            'nama' => 'PT Maju Jaya',
            'alamat' => 'Jl. Industri No. 123',
            'telepon' => '081234567890',
            'nama_pj' => 'Budi',
            'jabatan_pj' => 'Manager',
            'telepon_pj' => '081234567891',
            'email_industri' => 'majujaya@industri.com',
            'bidang_usaha' => 'Manufaktur',
            'deskripsi' => 'Perusahaan manufaktur alat berat',
        ]);

        // Dummy Pembimbing
        $pembimbingUser = User::create([
            'name' => 'Pembimbing Dummy',
            'email' => 'pembimbing@pkl.com',
            'password' => Hash::make('password'),
            'role' => 'pembimbing'
        ]);

        $pembimbing = Pembimbing::create([
            'user_id' => $pembimbingUser->id,
            'nama_lengkap' => 'Siti Aminah',
            'niy' => '198765',
            'email' => 'pembimbing@example.com',
            'no_hp' => '081298765432',
            'jabatan' => 'Guru Pembimbing',
            'alamat' => 'Jl. Melati No. 3',
        ]);

        // Admin Sekolah
        User::create([
            'name' => 'Admin Sekolah',
            'email' => 'admin@pkl.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        // Kepala Sekolah
        User::create([
            'name' => 'Kepala Sekolah',
            'email' => 'kepalasekolah@pkl.com',
            'password' => Hash::make('password'),
            'role' => 'kepala_sekolah'
        ]);

        // Dummy Siswa
        $siswaUser1 = User::create([
            'name' => 'Ahmad Siswa',
            'email' => 'ahmad.siswa@pkl.com',
            'password' => Hash::make('password'),
            'role' => 'siswa'
        ]);
        $siswaUser2 = User::create([
            'name' => 'Budi Siswa',
            'email' => 'budi.siswa@pkl.com',
            'password' => Hash::make('password'),
            'role' => 'siswa'
        ]);

        Siswa::create([
            'user_id' => $siswaUser1->id,
            'nama' => 'Ahmad Siswa',
            'nisn' => '99887766',
            'kelas' => 'XII RPL 1',
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '2007-01-01',
            'nis' => '123456',
            'jurusan' => 'mm',
            'alamat' => 'Jl. Kenanga No. 5',
        ]);
        Siswa::create([
            'user_id' => $siswaUser2->id,
            'nama' => 'Budi Siswa',
            'nisn' => '99887767',
            'kelas' => 'XII RPL 2',
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '2007-02-02',
            'nis' => '123457',
            'jurusan' => 'tb',
            'alamat' => 'Jl. Mawar No. 7',
        ]);
        // Dummy Laporan Harian
        $siswa1 = Siswa::where('user_id', $siswaUser1->id)->first();
        $siswa2 = Siswa::where('user_id', $siswaUser2->id)->first();


        Penempatan::create([
            'siswa_id' => $siswa1->id,
            'industri_id' => $industri->id,
            'pembimbing_id' => $pembimbing->id,
            'status' => 'disetujui',
            'tanggal_penempatan' => now(),
            'tanggal_selesai' => now()->addDays(30),
            'keterangan' => 'Penempatan aktif',
        ]);

        Penempatan::create([
            'siswa_id' => $siswa2->id,
            'industri_id' => $industri->id,
            'pembimbing_id' => $pembimbing->id,
            'status' => 'disetujui',
            'tanggal_penempatan' => now(),
            'tanggal_selesai' => now()->addDays(30),
            'keterangan' => 'Penempatan aktif',
        ]);
    }
}
