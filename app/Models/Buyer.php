<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'taxpayer_id',
        'address',
        'birthdate',
        'hash',
        'address_n',
        'address_complement',
        'address_neighborhood',
        'address_city',
        'address_state',
        'address_zip_code',
        'contract_id'
    ] ;

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
}
