<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('forums', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            // Add any other columns or modifications you need
            // ...
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('forums', function (Blueprint $table) {
            $table->dropColumn('user_id');
            // Drop any other columns or modifications you added in the up method
            // ...
        });
    }
    
};
