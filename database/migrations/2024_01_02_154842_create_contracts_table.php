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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->enum('status', ['A', 'D', 'P', 'V'])->default('P') ; // ATIVADO / DESATIVADO / PENDENTE / VALIDAÇÃO
            $table->string('marketplace_id')->nullable() ;
            $table->string('seller_id')->nullable() ;
            $table->string('hash')->unique() ;
            $table->json('owner') ;

            $table->string('description')->nullable() ;
            $table->string('business_name') ;
            $table->string('business_email') ;
            $table->string('business_website')->nullable() ;
            $table->string('business_description')->nullable() ;
            $table->string('business_facebook')->nullable() ;
            $table->string('business_twitter')->nullable() ;
            $table->string('ein')->comment('CNPJ da empresa') ;

            $table->string('statement_descriptor')->nullable() ;
            $table->json('business_address') ;

            $table->date('business_opening_date')->nullable() ;
            $table->json('owner_address')->nullable() ;

            $table->string('mcc')->nullable() ;

            $table->unsignedBigInteger('user_id')->nullable() ;
            $table->foreign('user_id')->references('id')->on('users') ;

            $table->json('documents_upload')->nullable() ;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
