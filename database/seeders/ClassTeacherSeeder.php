<?php

namespace Database\Seeders;

use App\Models\ClassTeacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\Traits\DisableForeignKeys;
use Database\Seeders\Traits\TruncateTable;

class ClassTeacherSeeder extends Seeder
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
        $class_teachers=ClassTeacher::factory(10)->create();
        $this->enableForeignKeys();
    }
}
