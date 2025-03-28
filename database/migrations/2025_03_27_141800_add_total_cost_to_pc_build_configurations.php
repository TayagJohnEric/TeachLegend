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
        Schema::table('pc_build_configurations', function (Blueprint $table) {
            $table->decimal('total_cost', 10, 2)->after('budget');
        });
    }
    
    public function down()
    {
        Schema::table('pc_build_configurations', function (Blueprint $table) {
            $table->dropColumn('total_cost');
        });
    }
};
