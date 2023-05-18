<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAnnouncementIdToLikesTable extends Migration
{
    public function up()
    {
        Schema::table('likes', function (Blueprint $table) {
            $table->foreignId('announcement_id')->constrained();
        });
    }

    public function down()
    {
        Schema::table('likes', function (Blueprint $table) {
            $table->dropForeign(['announcement_id']);
            $table->dropColumn('announcement_id');
        });
    }
}
