<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Rule;
use Livewire\Form;

class FormPayment extends Form
{
    #[Rule('required|min:2')]
    public string $first_name = '';

    #[Rule('required|min:2')]
    public string $last_name = '';

    #[Rule('required|min:2')]
    public string $type_payment = 'p';

    #[Rule('required')]
    public string $email = '';

    #[Rule('required|min:15')]
    public string $phone_number = '';

    #[Rule('required')]
    public string $taxpayer_id = '';

    #[Rule('required')]
    public string $address_zip_code = '';

    #[Rule('required')]
    public string $address = '';

    #[Rule('required')]
    public string $address_n = '';

    #[Rule('required')]
    public string $address_neighborhood = '';

    #[Rule('required')]
    public string $address_complement = '';

    #[Rule('required')]
    public string $address_city = '';

    #[Rule('required')]
    public string $address_state = '';
    #[Rule('required')]
    public string $address_coutry_code = 'BR';

}
