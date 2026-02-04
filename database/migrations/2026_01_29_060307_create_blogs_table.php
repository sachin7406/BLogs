<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();

            // Basic info
            $table->string('title');
            $table->string('slug')->unique();

            // Editor content (JSON from editor)
            $table->longText('content')->nullable();

            // Optional meta (keep from your old design)
            $table->text('description')->nullable();
            $table->string('reference_link')->nullable();
            $table->string('reference_image')->nullable();

            // Status (active / inactive)
            $table->enum('status', ['active', 'inactive'])
                  ->default('active');

            // Admin user
            $table->unsignedBigInteger('created_by');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogs');
    }
}
