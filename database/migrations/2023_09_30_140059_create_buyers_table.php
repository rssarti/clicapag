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

        /*
        * first_name
        * last_name
        * email
        * phone_number
        * taxpayer_id
        * address_line_1
        * address_line_2
        * address_line_3
        * neighborhood
        * city
        * state
        * postal_code
        * country_code
        * birthdate
        */

        Schema::create('buyers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('first_name') ;
            $table->string('last_name') ;
            $table->string('email') ;
            $table->string('phone_number') ;
            $table->string('taxpayer_id') ;
            $table->string('address')->nullable() ;
            $table->string('address_n')->nullable() ;
            $table->string('address_complement')->nullable() ;
            $table->string('address_line_1')->nullable() ;
            $table->string('address_line_2')->nullable() ;
            $table->string('address_line_3')->nullable() ;
            $table->string('address_neighborhood') ;
            $table->string('address_city') ;
            $table->string('address_state') ;
            $table->string('address_zip_code') ;
            $table->string('address_country_code')->default('BR') ;
            $table->string('birthdate')->nullable() ;
            $table->string('external_id_payment')->nullable() ;
            $table->string('service_payment', 20)->default('zoop') ;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buyers');
    }
};
