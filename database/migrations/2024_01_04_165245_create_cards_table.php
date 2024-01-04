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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('holder_name') ;
            $table->string('first_digit') ;
            $table->string('last_digit') ;
            $table->string('card_brand') ;
            $table->boolean('valid') ;
            $table->boolean('postal_code_check')->default(false) ;
            $table->boolean('security_code_check')->default(false) ;
            $table->string('external_id_card') ;

            $table->unsignedBigInteger('buyer_id') ;
            $table->foreign('buyer_id')->references('id')->on('buyers') ;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
