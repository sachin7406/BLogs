<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateBlogStatusToActiveInactive extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('blogs')) {
            return;
        }

        DB::table('blogs')->where('status', 'published')->update(['status' => 'active']);
        DB::table('blogs')->whereIn('status', ['draft', 'scheduled', 'inactive'])->update(['status' => 'inactive']);

        $driver = Schema::getConnection()->getDriverName();
        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE blogs MODIFY status ENUM('active','inactive') DEFAULT 'active'");
        }
    }

    public function down()
    {
        $driver = Schema::getConnection()->getDriverName();
        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE blogs MODIFY status ENUM('draft','published','inactive') DEFAULT 'draft'");
        }
    }
}
