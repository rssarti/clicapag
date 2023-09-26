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
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->uuid('uuid') ;
            $table->string('name') ;
            $table->string('photo')->nullable() ;
            $table->float('amount') ;
            $table->text('description')->nullable() ;
            $table->float('amount_min_installmes')->default(0) ;
            $table->integer('max_installments') ;
            $table->boolean('pass_tax')->default(false)->comment('passa a taxa ao cliente') ;
            $table->integer('views')->default(0) ;

            $table->unsignedBigInteger('user_id')->nullable() ;
            $table->foreign('user_id')->references('id')->on('users') ;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('links');
    }
};
