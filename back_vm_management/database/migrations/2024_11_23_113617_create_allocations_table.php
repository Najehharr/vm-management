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
        Schema::create('allocations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vm_id');
            $table->string('client_cin');
            $table->date('begin_date');
            $table->date('end_date');
            $table->decimal('amount', 8, 2);
            $table->timestamps();

            
            $table->foreign('vm_id')->references('id')->on('vms')->cascadeOnDelete();
            $table->foreign('client_cin')->references('cin')->on('clients')->cascadeOnDelete();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('allocations');
    }
};
