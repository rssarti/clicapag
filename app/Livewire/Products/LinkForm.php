<?php

namespace App\Livewire\Products;

use App\Services\LinkService;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class LinkForm extends Component
{
    use WithFileUploads;

    #[Rule('image|max:1024')] // 1MB Max
    public $photo;

    public $data = [
        'name' => '',
        'photo' => '',
        'amount' => null,
        'description' => '',
        'max_installments' => 0,
        'pass_tax' => 1,

    ] ;

    public function mount()
    {
        if(isset($_GET['uuid'])) {
            $this->data = \App\Models\Link::where('uuid', $_GET['uuid'])->first() ;
            $this->data = $this->data->toArray() ;
        }
    }

    public function save()
    {
        $link = new LinkService() ;
        $link->setData($this->data);
        if(isset($this->data['id'])) {
            $link->save($this->data['id']) ;
        } else {
            $link->save() ;
        }
    }

    public function render()
    {
        return view('livewire.products.link-form');
    }
}
