<?php

namespace App\Services;

use App\Models\Buyer;

class BuyerService
{
    public function store($data)
    {
        $buyer = new Buyer() ;
        return $buyer->create($data) ;
    }
}
