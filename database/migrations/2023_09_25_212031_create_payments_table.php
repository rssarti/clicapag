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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('hash') ;
            $table->enum('seller_receipt', ['direct', 'third'])->comment('pagamento é direto ou de terceiros') ;
            $table->string('third_seller_id')->nullable() ;
            $table->float('amount') ;
            $table->json('client')->nullable() ;
            $table->float('amount_min_installmes')->default(0) ;
            $table->integer('max_installments')->default(12) ;
            $table->integer('installments')->default(1) ;

            // A = ABERTO /PEN = PENDENTE / PG = PAGO / V = VENCIDO, D = DELETADO
            $table->string('type_payment', 2)->default('P') ;
            $table->enum('status', ['A', 'PEN', 'PG', 'V', 'D'])->default('PEN') ;
            $table->json('data_payment')->nullable() ;
            $table->json('sales_receipt')->nullable() ;

            $table->unsignedBigInteger('api_key_id')->nullable() ;
            $table->foreign('api_key_id')->references('id')->on('api_keys') ;

            $table->unsignedBigInteger('link_id')->nullable() ;
            $table->foreign('link_id')->references('id')->on('links') ;

            $table->unsignedBigInteger('user_id')->nullable() ;
            $table->foreign('user_id')->references('id')->on('users') ;

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
