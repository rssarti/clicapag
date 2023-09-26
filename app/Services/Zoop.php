<?php

namespace App\Services;

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



    public function __construct()
    {
        $this->user = Auth::user() ;
        $this->authZoop = base64_encode(config('app.ZOOP_KEY').":") ;
    }

    public function createBuyer()
    {
        if($this->user->external_payment_id) {
            return false ;
        }

        $util = new Utils() ;

        $name = explode(" ", $this->user->name) ;
        $cont_last_name = count($name) ;
        $cont_last_name = $cont_last_name - 1 ;

        $data['first_name'] = (isset($name[0])) ? $name[0] : null ;
        $data['last_name'] = (isset($name[$cont_last_name])&&$cont_last_name>0) ? $name[$cont_last_name] : null;
        $data['email'] = $this->user->email ;
        $data['phone_number'] = $util->removeCaracteres($this->user->celular);
        $data['taxpayer_id'] = $util->removeCaracteres($this->user->cpf);
        $data['address']['line1'] = $this->user->endereco;
        $data['address']['line2'] = $this->user->complemento;
        $data['address']['line3'] = '';
        $data['address']['neighborhood'] = $this->user->bairro;
        $data['address']['city'] = $this->user->cidade;
        $data['address']['state'] = $this->user->uf;
        $data['address']['postal_code'] = $this->user->cep;
        $data['address']['country_code'] = 'BR';
        $data['birthdate'] = $this->user->dt_nascimento ;

        $url = 'https://api.zoop.ws/v1/marketplaces/'.config('app.ZOOP_MARKETPLACE').'/buyers' ;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Basic '.$this->authZoop
        ])->post($url, $data);

        $data = json_decode($response->body()) ;

        $this->user->external_payment_id = $data->id ;
        $this->user->external_payment_service = 'zoop' ;
        $this->user->save() ;
        return json_decode($response->body()) ;

    }

    public function cobrarCartao($card_id, $amount)
    {
        $url = 'https://api.zoop.ws/v1/marketplaces/'.config('app.ZOOP_MARKETPLACE').'/transactions' ;

        $data['on_behalf_of'] = config('app.ZOOP_SELLER') ;
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

    public function cobrar($customer_id, $amount)
    {
        $url = 'https://api.zoop.ws/v1/marketplaces/'.config('app.ZOOP_MARKETPLACE').'/transactions' ;

        $data['on_behalf_of'] = config('app.ZOOP_SELLER') ;
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


        if($this->user->external_payment_id) {

            $url = 'https://api.zoop.ws/v1/marketplaces/'.config('app.ZOOP_MARKETPLACE').'/cards/tokens' ;

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
            $card->users_id = $this->user->id ;
            $card->save();
            // associar

            $url = 'https://api.zoop.ws/v1/marketplaces/'.config('app.ZOOP_MARKETPLACE').'/cards' ;

            $data = null ;

            $data['token'] = $token_card ;
            $data['customer'] = $this->user->external_payment_id ;

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
        $url = 'https://api.zoop.ws/v1/marketplaces/'.config('app.ZOOP_MARKETPLACE').'/sellers?limit=20&sort=time-descending&offset=0' ;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Basic '.$this->authZoop
        ])->get($url);

        return json_decode($response->body()) ;
    }

    public function getBuyers()
    {
        $url = 'https://api.zoop.ws/v1/marketplaces/'.config('app.ZOOP_MARKETPLACE').'/buyers' ;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Basic '.$this->authZoop
        ])->get($url);

        $data = json_decode($response->body()) ;

        return $data ;
    }

    public function getSellerByCpf($cnpj)
    {
        $url = 'https://api.zoop.ws/v1/marketplaces/'.config('app.ZOOP_MARKETPLACE').'/sellers/search?ein='.$cnpj ;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Basic '.$this->authZoop
        ])->get($url);

        $data = json_decode($response->body()) ;

        return $data ;
    }

    public function getBuyerByCpf($cpf)
    {
        $url = 'https://api.zoop.ws/v1/marketplaces/'.config('app.ZOOP_MARKETPLACE').'/buyers/search?taxpayer_id='.$cpf ;

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
        $url = 'https://api.zoop.ws/v1/marketplaces/'.config('app.ZOOP_MARKETPLACE').'/plans' ;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Basic '.$this->authZoop
        ])->get($url);

        $data = json_decode($response->body()) ;

        return $data ;
    }

    public function getPlanById($id)
    {
        $url = 'https://api.zoop.ws/v1/marketplaces/'.config('app.ZOOP_MARKETPLACE').'/plans/'.$id ;

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Basic '.$this->authZoop
        ])->get($url);

        $data = json_decode($response->body()) ;

        return $data ;
    }

}
