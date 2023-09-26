<?php

namespace App\Livewire\Components;

use Livewire\Component;

class ItemLink extends Component
{
    public $link ;

    public function mount($link)
    {
        $this->link = $link ;
    }
    public function render()
    {
        return view('livewire.components.item-link');
    }
}
