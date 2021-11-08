<?php

namespace Database\Seeders;

use App\Models\Matakuliah;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(KelasSeeder::class);
        $this->call(MahasiswaSeeder::class);
        $this->call(UpdateMahasiswaSeeder::class);
        $this->call(MataKuliahSeeder::class);
    }
}
