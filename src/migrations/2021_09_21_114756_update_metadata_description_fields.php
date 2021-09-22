<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMetadataDescriptionFields extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('metadata', function(Blueprint $table) {
            $table->text('description')->change();
            $table->text('og_description')->change();
        });

        Schema::table('metadata_translations', function (Blueprint $table) {
            $table->text('description')->change();
            $table->text('og_description')->change();
        });
    }

    public function down()
    {
        Schema::table('metadata', function(Blueprint $table) {
            $table->string('description')->change();
            $table->string('og_description')->change();
        });

        Schema::table('metadata_translations', function (Blueprint $table) {
            $table->string('description')->change();
            $table->string('og_description')->change();
        });
    }

}
