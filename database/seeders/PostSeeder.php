<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\Traits\DisableForeignKeys;
use Database\Seeders\Traits\TruncateTable;
use \App\Models\Post;
use Database\Factories\Helpers\FactoryHelper;
use App\Models\User;
class PostSeeder extends Seeder
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
        $this->truncate('posts');
        $posts=Post::factory(3)->create();
        $this->enableForeignKeys();

    }
}
