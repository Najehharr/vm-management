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
                $table->unsignedBigInteger('allocation_id'); 
                $table->foreign('allocation_id')
                    ->references('id')
                    ->on('allocations')
                    ->onDelete('cascade');
            }
        });
    }

    /**
     *
     */
    public function down(): void
    {
        Schema::table('vms', function (Blueprint $table) {
            $table->dropForeign(['allocation_id']);
            $table->dropColumn('allocation_id');
        });
    }
};
