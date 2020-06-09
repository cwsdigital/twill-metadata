<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetadataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metadata', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('og_title')->nullable();
            $table->string('og_description')->nullable();
            $table->string('og_type')->nullable();
            $table->string('og_image')->nullable();
            $table->string('card_type')->nullable();
            $table->boolean('noindex')->default(false);
            $table->boolean('nofollow')->default(false);
            $table->string('canonical_url')->nullable();
            $table->unsignedBigInteger('meta_describable_id');
            $table->string('meta_describable_type');
            $table->timestamps();

            $table->index(['meta_describable_id','meta_describable_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('metadata');
    }
}
