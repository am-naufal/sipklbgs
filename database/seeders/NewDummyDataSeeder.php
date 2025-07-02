<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;
use App\Models\Industri;
use App\Models\Pembimbing;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class NewDummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create dummy users and related models only if they don't exist to avoid duplicates

        // Dummy Siswa Users and Data
        $siswaData = [
            [
                'name' => 'Budi Santoso',
                'email' => 'siswa1@pkl.com',
                'password' => 'password',
                'role' => 'siswa',
                'siswa' => [
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
                ],
            ],
            [
                'name' => 'Sari Wulandari',
                'email' => 'siswa2@pkl.com',
                'password' => 'password',
                'role' => 'siswa',
                'siswa' => [
                    'nama' => 'Sari Wulandari',
                    'tempat_lahir' => 'Jakarta',
                    'tanggal_lahir' => '2005-05-15',
                    'nis' => '123457',
                    'nisn' => '654322',
                    'kelas' => 'XII RPL 2',
                    'jurusan' => 'mm',
                    'alamat' => 'Jl. Melati No. 2',
                    'status_pkl' => 'sedang_berjalan',
                    'tanggal_mulai' => '2023-01-10',
                    'tanggal_selesai' => null,
                    'tahun_angkatan' => 2022,
                ],
            ],
        ];

        foreach ($siswaData as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make($data['password']),
                    'role' => $data['role'],
                ]
            );

            Siswa::firstOrCreate(
                ['user_id' => $user->id],
                $data['siswa']
            );
        }

        // Dummy Industri Users and Data
        $industriData = [
            [
                'name' => 'PT Maju Jaya',
                'email' => 'industri1@pkl.com',
                'password' => 'password',
                'role' => 'industri',
                'industri' => [
                    'nama' => 'PT Maju Jaya',
                    'alamat' => 'Jl. Industri No. 123',
                    'telepon' => '081234567890',
                    'nama_pj' => 'Budi',
                    'jabatan_pj' => 'Manager',
                    'telepon_pj' => '081234567891',
                    'email_industri' => 'majujaya@industri.com',
                    'bidang_usaha' => 'Manufaktur',
                    'deskripsi' => 'Perusahaan manufaktur alat berat',
                ],
            ],
            [
                'name' => 'CV Sukses Selalu',
                'email' => 'industri2@pkl.com',
                'password' => 'password',
                'role' => 'industri',
                'industri' => [
                    'nama' => 'CV Sukses Selalu',
                    'alamat' => 'Jl. Bisnis No. 45',
                    'telepon' => '081298765432',
                    'nama_pj' => 'Sari',
                    'jabatan_pj' => 'Direktur',
                    'telepon_pj' => '081298765433',
                    'email_industri' => 'suksesselalu@industri.com',
                    'bidang_usaha' => 'Jasa',
                    'deskripsi' => 'Perusahaan jasa konsultasi bisnis',
                ],
            ],
        ];

        foreach ($industriData as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make($data['password']),
                    'role' => $data['role'],
                ]
            );

            Industri::firstOrCreate(
                ['user_id' => $user->id],
                $data['industri']
            );
        }

        // Dummy Pembimbing Users and Data
        $pembimbingData = [
            [
                'name' => 'Pembimbing Satu',
                'email' => 'pembimbing1@pkl.com',
                'password' => 'password',
                'role' => 'pembimbing',
                'pembimbing' => [
                    'nama_lengkap' => 'Siti Aminah',
                    'niy' => '198765',
                    'email' => 'pembimbing1@pkl.com',
                    'no_hp' => '081298765432',
                    'jabatan' => 'Guru Pembimbing',
                    'alamat' => 'Jl. Melati No. 3',
                ],
            ],
            [
                'name' => 'Pembimbing Dua',
                'email' => 'pembimbing2@pkl.com',
                'password' => 'password',
                'role' => 'pembimbing',
                'pembimbing' => [
                    'nama_lengkap' => 'Ahmad Fauzi',
                    'niy' => '198766',
                    'email' => 'pembimbing2@pkl.com',
                    'no_hp' => '081298765433',
                    'jabatan' => 'Guru Pembimbing',
                    'alamat' => 'Jl. Kenanga No. 4',
                ],
            ],
        ];

        foreach ($pembimbingData as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make($data['password']),
                    'role' => $data['role'],
                ]
            );

            Pembimbing::firstOrCreate(
                ['user_id' => $user->id],
                $data['pembimbing']
            );
        }

        // Dummy Admin and Kepala Sekolah Users
        $adminData = [
            [
                'name' => 'Admin Sekolah',
                'email' => 'admin@pkl.com',
                'password' => 'password',
                'role' => 'admin',
            ],
            [
                'name' => 'Kepala Sekolah',
                'email' => 'kepalasekolah@pkl.com',
                'password' => 'password',
                'role' => 'kepala_sekolah',
            ],
        ];

        foreach ($adminData as $data) {
            User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make($data['password']),
                    'role' => $data['role'],
                ]
            );
        }
    }
}
