<?php

namespace Database\Seeders;

use App\Models\Student;
use Database\Seeders\Traits\TruncateTable;
use Database\Seeders\Traits\DisableForeignKeys;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
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
        $this->truncate('students');        
      
        Student::factory()
            ->count(10)
            ->create();        
      
        $this->enableForeignKeys();
    }
}
