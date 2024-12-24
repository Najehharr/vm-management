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
        Schema::table('vms', function (Blueprint $table) {
            if (!Schema::hasColumn('vms', 'allocation_id')) {
                $table->unsignedBigInteger('allocation_id')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vms', function (Blueprint $table) {
            $table->dropColumn('allocation_id');
        });
    }
};
