<?php

namespace App\Livewire\Products;

use Livewire\Component;

class Link extends Component
{

    public $items = [] ;

    public function mount()
    {

    }
    public function render()
    {
        $this->items = \App\Models\Link::all() ;
        return view('livewire.products.link');
    }
}
