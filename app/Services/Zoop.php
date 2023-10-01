<?php

namespace App\Services;

use App\Models\Buyer;
use App\Models\UserCard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Zoop
{
    public $authZoop ;

    public $user ;

    public $card ;

    public $marplace_id = ""  ;
    public $seller = ""  ;

    public $buyer ;

    public function __construct($dev=false)
    {
        if(!$dev) {

            $this->authZoop = base64_encode(config('app.ZOOP_KEY').":") ;
            $this->marplace_id = config('app.ZOOP_MARKETPLACE') ;
            $this->seller = config('app.ZOOP_SELLER') ;
        } else {

            $this->authZoop = base64_encode(config('app.ZOOP_KEY_DEV').":") ;
            $this->marplace_id = config('app.ZOOP_MARKETPLACE_DEV') ;
            $this->seller = config('app.ZOOP_SELLER_DEV') ;
        }

    }

    public function setSeller($seller_id)
    {
        $this->seller = $seller_id ;
    }

    public function setBuyer($buyer_id)
    {
        $this->buyer = $buyer_id ;
    }

    public function createBuyer($buyer)
    {

        $this->buyer = Buyer::find($buyer->id) ;

        $util = new Utils() ;

        $data['first_name'] = $this->buyer->first_name ;
        $data['last_name'] = $this->buyer->last_name;
        $data['email'] = $this->buyer->email ;
        $data['phone_number'] = $util->removeCaracteres($this->buyer->phone_number);
        $data['taxpayer_id'] = $util->removeCaracteres($this->buyer->taxpayer_id);
        $data['address']['line1'] = $this->buyer->address.",".$this->buyer->address_n;
        $data['address']['line2'] = $this->buyer->address_complement;
        $data['address']['line3'] = $this->buyer->address_line_3;
        $data['address']['neighborhood'] = $this->buyer->address_neighborhood;
        $data['address']['city'] = $this->buyer->address_city;
        $data['address']['state'] = $this->buyer->address_state;
        $data['address']['postal_code'] = $this->buyer->address_zip_code;
        $data['address']['country_code'] = $this->buyer->address_coutry_code;
        $data['birthdate'] = $this->buyer->birthdate ;

        $url = 'https://api.zoop.ws/v1/marketplaces/'.$this->marplace_id.'/buyers' ;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Basic '.$this->authZoop
        ])->post($url, $data);

        $retorno = json_decode($response->body()) ;

        $this->buyer->external_id_payment = $retorno->id ;
        $this->buyer->service_payment = 'zoop' ;
        $this->buyer->save() ;

        return json_decode($response->body()) ;

    }

    public function cobrarPix($payment)
    {
        $url = 'https://api.zoop.ws/v1/marketplaces/'.$this->marplace_id.'/transactions' ;

        $data['payment_type'] = 'pix' ;
        $data['on_behalf_of'] = $payment['seller_id'] ;
        $data['description'] = $payment['description'] ;
        $data['currency'] = 'BRL' ;
        $data['amount'] = $payment['amount'] ;


        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Basic '.$this->authZoop
        ])->post($url, $data);


        $data = json_decode($response->body(), true) ;

        if($data['status']=="pending") {
            return $data ;
        } else {
            Log::error("Pagamento com Erro", $data);
            return false ;
        }

    }

    public function cobrarCartao($card_id, $amount)
    {
        $url = 'https://api.zoop.ws/v1/marketplaces/'.$this->marplace_id.'/transactions' ;

        $data['on_behalf_of'] = $this->seller ;
        $data['payment_type'] = 'credit' ;
        $data['statement_descriptor'] = 'CLICA' ;
        $data['source']['currency'] = 'BRL' ;
        $data['source']['usage'] = 'single_use' ;
        $data['source']['type'] = 'card' ;
        $data['source']['amount'] = $amount ;
        $data['source']['card']['id'] = $card_id ;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Basic '.$this->authZoop
        ])->post($url, $data);

        $data = json_decode($response->body(), true) ;

        if($data['status']=="succeeded") {
            return $data ;
        } else {
            Log::error("Pagamento com Erro", $data);
            return false ;
        }

    }

    public function createBoleto($amount)
    {
        $url = 'https://api.zoop.ws/v1/marketplaces/'.$this->marplace_id.'/transactions' ;

        $data['on_behalf_of'] = $this->seller ;
        $data['payment_type'] = 'boleto' ;
        $data['customer'] = 'boleto' ;
        $data['logo'] = 'https://clicapag.com.br/logo-w.png' ;
        $data['currency'] = 'BRL' ;
        $data['amount'] = $amount ;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Basic '.$this->authZoop
        ])->post($url, $data);

        $data = json_decode($response->body(), true) ;

        if($data['status']=="succeeded") {
            return $data ;
        } else {
            Log::error("Pagamento com Erro", $data);
            return false ;
        }

    }

    public function cobrar($customer_id, $amount)
    {
        $url = 'https://api.zoop.ws/v1/marketplaces/'.$this->marplace_id.'/transactions' ;

        $data['on_behalf_of'] = $this->seller ;
        $data['payment_type'] = 'credit' ;
        $data['statement_descriptor'] = 'CLICA' ;
        $data['customer'] = $customer_id ;
        $data['amount'] = $amount ;
        $data['currency'] = 'BRL' ;


        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Basic '.$this->authZoop
        ])->post($url, $data);

        $data = json_decode($response->body()) ;

        dd($data) ;

        if($data->status=="succeeded") {
            return $data ;
        } else {
            Log::error("Pagamento com Erro", $data);
            return false ;
        }

    }

    public function setCard($data)
    {


        if($this->buyer->external_payment_id) {

            $url = 'https://api.zoop.ws/v1/marketplaces/'.$this->marplace_id.'/cards/tokens' ;

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Basic '.$this->authZoop
            ])->post($url, $data);

            $data = json_decode($response->body()) ;

            $token_card = $data->id ;

            $card = new UserCard() ;
            $card->external_id = $data->card->id ;
            $card->last_digits = $data->card->first4_digits ;
            $card->first_digits = $data->card->first4_digits ;
            $card->brand = $data->card->card_brand ;
            $card->default_card = true ;
            $card->users_id = $this->buyer->id ;
            $card->save();
            // associar

            $url = 'https://api.zoop.ws/v1/marketplaces/'.$this->marplace_id.'/cards' ;

            $data = null ;

            $data['token'] = $token_card ;
            $data['customer'] = $this->buyer->external_payment_id ;

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Basic '.$this->authZoop
            ])->post($url, $data);

            $data = json_decode($response->body(), true) ;
            return true ;

        } else {

            try {
                $this->createBuyer() ;
                $this->setCard($data);
            } catch (\Exception $e) {
                Log::error("erro na criação do Buyer", $e);
            }

        }

    }

    public function getSellers()
    {
        $url = 'https://api.zoop.ws/v1/marketplaces/'.$this->marplace_id.'/sellers?limit=20&sort=time-descending&offset=0' ;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Basic '.$this->authZoop
        ])->get($url);

        return json_decode($response->body()) ;
    }

    public function getBuyers()
    {
        $url = 'https://api.zoop.ws/v1/marketplaces/'.$this->marplace_id.'/buyers' ;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Basic '.$this->authZoop
        ])->get($url);

        $data = json_decode($response->body()) ;

        return $data ;
    }

    public function getSellerByCpf($cnpj)
    {
        $url = 'https://api.zoop.ws/v1/marketplaces/'.$this->marplace_id.'/sellers/search?ein='.$cnpj ;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Basic '.$this->authZoop
        ])->get($url);

        $data = json_decode($response->body()) ;

        return $data ;
    }

    public function getBuyerByCpf($cpf)
    {
        $url = 'https://api.zoop.ws/v1/marketplaces/'.$this->marplace_id.'/buyers/search?taxpayer_id='.$cpf ;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Basic '.$this->authZoop
        ])->get($url);

        $data = json_decode($response->body()) ;

        return $data ;
    }

    public function getMCC($page=1)
    {
        $url = 'https://api.zoop.ws/v1/merchant_category_codes?page='.$page ;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Basic '.$this->authZoop
        ])->get($url);

        $data = json_decode($response->body()) ;

        return $data ;
    }

    public function getPlan()
    {
        $url = 'https://api.zoop.ws/v1/marketplaces/'.$this->marplace_id.'/plans' ;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Basic '.$this->authZoop
        ])->get($url);

        $data = json_decode($response->body()) ;

        return $data ;
    }

    public function getPlanById($id)
    {
        $url = 'https://api.zoop.ws/v1/marketplaces/'.$this->marplace_id.'/plans/'.$id ;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Basic '.$this->authZoop
        ])->get($url);

        $data = json_decode($response->body()) ;

        return $data ;
    }

}
