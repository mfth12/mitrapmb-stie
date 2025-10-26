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
        Schema::create('antrian_whatsapps', function (Blueprint $table) {
            /** Definisikan struktur tabel */
            $table->bigIncrements('antrian_id')->from(61231);
            // $table->integer('user_id')->unsigned();
            $table->bigInteger('user_id')->nullable();
            $table->string('sesi');
            $table->string('target');
            $table->string('tipe');
            $table->text('isi_pesan');
            $table->tinyInteger('status')->default(0)->unsigned();
            $table->unsignedTinyInteger('retry_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antrian_whatsapps');
    }
};
