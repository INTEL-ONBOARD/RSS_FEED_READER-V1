<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rss_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('date');
            $table->string('link');
            $table->string('author')->nullable();
            $table->text('description');
            $table->string('category')->nullable();
            $table->string('guid');
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
        Schema::dropIfExists('rss_jobs');
    }
};
