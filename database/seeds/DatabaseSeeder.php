<?php

use App\Aktifitas;
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
        $this->call(RoleSeeder::class);
        $this->call(AktifitasSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(FakultasSeeder::class);
        $this->call(JurusanSeeder::class);
        $this->call(PertemuanSeeder::class);
        $this->call(StatusSeeder::class);
    }
}
