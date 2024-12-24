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
        Schema::create('clients', function (Blueprint $table) {
            
            $table->string('cin')->primary();
            $table->string('name');
            $table->string('forname');
            $table->string('address');
            $table->timestamps();
        });
    }

    /**

     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
