<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();

            // polymorphic parent
            $table->string('parent_type');
            // 'menu' OR 'menu_item'

            $table->unsignedBigInteger('parent_id');

            $table->string('title');
            $table->text('description')->nullable();
            $table->string('icon')->nullable();

            // routing
            $table->string('route_name')->nullable();
            $table->string('url')->nullable();

            $table->integer('sort_order')->default(0);

            $table->enum('status', ['active', 'inactive'])
                ->default('active');

            // audit
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

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
        Schema::dropIfExists('menu_items');
    }
}
