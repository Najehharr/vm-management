<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
      Schema::create('vms', function (Blueprint $table) {
        $table->id();
        $table->decimal('price', 8, 2);
        $table->string('ram');
        $table->string('disk');
        $table->string('os');
        $table->unsignedBigInteger('server_id');
        $table->foreign('server_id')->references('id')->on('servers')->onDelete('cascade');
        $table->string('client_cin');
        $table->foreign('client_cin')->references('cin')->on('clients')->onDelete('cascade');

        $table->timestamps();
        });
    }



    public function down(): void
    {
        Schema::dropIfExists('vms');
    }
};
