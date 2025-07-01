<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Siswa;
use App\Models\Industri;
use App\Models\Pembimbing;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dummy user untuk relasi siswa
        $user = User::create([
            'name' => 'Siswa Dummy',
            'email' => 'siswa@pkl.com',
            'password' => Hash::make('password'),
            'role' => 'siswa'
        ]);

        // Dummy Siswa
        \App\Models\Siswa::create([
            'user_id' => $user->id,
            'nama' => 'Budi Santoso',
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '2006-01-01',
            'nis' => '123456',
            'nisn' => '654321',
            'kelas' => 'XII RPL 1',
            'jurusan' => 'tb',
            'alamat' => 'Jl. Mawar No. 1',
            'status_pkl' => 'belum_mulai',
            'tanggal_mulai' => null,
            'tanggal_selesai' => null,
            'tahun_angkatan' => 2022,
        ]);

        // User Industri
        $industriUser = User::create([
            'name' => 'PT Maju Jaya',
            'email' => 'industri@pkl.com',
            'password' => Hash::make('password'),
            'role' => 'industri'
        ]);

        // Industri
        Industri::create([
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

        Pembimbing::create([
            'user_id' => $pembimbingUser->id,
            'nama_lengkap' => 'Siti Aminah',
            'niy' => '198765',
            'email' => 'pembimbing@example.com',
            'no_hp' => '081298765432',
            'jabatan' => 'Guru Pembimbing',
            'alamat' => 'Jl. Melati No. 3',
        ]);

        User::create([
            'name' => 'Admin Sekolah',
            'email' => 'admin@pkl.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);
        User::create([
            'name' => 'Kepala Sekolah',
            'email' => 'kepalasekolah@pkl.com',
            'password' => Hash::make('password'),
            'role' => 'kepala_sekolah'
        ]);
    }
}
