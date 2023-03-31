<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\Traits\DisableForeignKeys;
use Database\Seeders\Traits\TruncateTable;
use \App\Models\Subject;

class SubjectSeeder extends Seeder
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
        $this->truncate('subjects');
        $subjects=Subject::factory(3)->create();
        $this->enableForeignKeys();
    }
}
