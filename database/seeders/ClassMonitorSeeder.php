<?php

namespace Database\Seeders;

use App\Models\ClassMonitor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\Traits\DisableForeignKeys;
use Database\Seeders\Traits\TruncateTable;

class ClassMonitorSeeder extends Seeder
{
    use TruncateTable,DisableForeignKeys;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();
        $this->truncate('class_teachers');
        $class_monitors=ClassMonitor::factory(10)->create();
        $this->enableForeignKeys();
    }
}
