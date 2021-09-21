<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMetaDataForTranslation extends Migration
{
    public function up() {
        Schema::table('metadata', function(Blueprint $table) {
            $table->softDeletes();
        });

        Schema::create('metadata_translations', function (Blueprint $table) {
            createDefaultTranslationsTableFields($table, 'metadata');

            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('og_title')->nullable();
            $table->string('og_description')->nullable();
            $table->string('canonical_url')->nullable();
        });
    }



}