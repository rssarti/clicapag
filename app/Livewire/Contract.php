<?php

namespace App\Livewire;

use App\Models\Mcc;
use App\Services\SellerService;
use App\Services\Utils;
use App\Services\Zoop;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Contract extends Component
{
    use WithFileUploads;
    public $data = [
        'address_street' => '',
        'address_city' => '',
        'address_district' => '',
        'address_state' => '',
    ] ;

    #[Validate('image|max:2048')] // 2MB Max
    public $identify;

    #[Validate('image|max:2048')] // 2MB Max
    public $comprovante;

    #[Validate('image|max:2048')] // 2MB Max
    public $atividade;

    public $validate = false ;

    public $contract ;

    public $listMCC ;

    public function render()
    {
        $this->contract = \App\Models\Contract::where('user_id', Auth::user()->id)->first() ;
        $this->listMCC = Mcc::orderBy('category', 'ASC')->orderBy("description", "ASC")->get() ;
        return view('livewire.contract');
    }

    public function save()
    {
        $seller = new SellerService() ;
        $seller->setData($this->data);
        try {
            $seller->save();
        } catch (\Exception $e) {
            dd($e) ;
        }
    }

    public function saveStep2()
    {
        $seller = new SellerService() ;

        $documents = [
            'identify' => $this->identify->store('documents'),
            'comprovante' => $this->comprovante->store('documents'),
            'atividade' => $this->atividade->store('documents'),
        ] ;
        $seller->setData($this->data);
        $seller->setDocuments($this->contract, $documents);

    }

    public function cep()
    {

        if (isset($this->data['address_cep'])&&Str::length($this->data['address_cep']) == 9) {
           $data = Utils::consultaCep($this->data['address_cep']) ;

           $this->data['address_street'] = $data->logradouro ;
           $this->data['address_city'] = $data->localidade ;
           $this->data['address_district'] = $data->bairro ;
           $this->data['address_state'] = $data->uf  ;
        }
    }

    public function cnpj()
    {
        if(isset($this->data['ein']) && Str::length($this->data['ein']) == 18) {
            $this->validate = Utils::validarCNPJ($this->data['ein']) ;
        }
    }
}
