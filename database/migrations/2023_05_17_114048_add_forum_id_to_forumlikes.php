<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('forumlikes', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('forum_id')->after('id');
            $table->foreign('forum_id')->references('id')->on('forums')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('forumlikes', function (Blueprint $table) {
            //
        });
    }
};
