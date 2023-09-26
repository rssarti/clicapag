<div>
    <div class="dark:text-white ">
        @if ($data['photo'])
            <img class="object-cover h-48 w-full rounded-lg mb-6" src="{{ ($data['photo']) ? "/storage/".$data['photo'] : $this->data['photo']->temporaryUrl() }}">
        @endif
        <h3 class="text-[#ff6600] text-2xl mb-2">{{ $data['name'] }}</h3>
        @if($data['amount']>0)
            <h3 class="dark:text-white text-2xl mb-2">R$ {{ number_format($data['amount'], 2, ",", ".") }}</h3>
        @endif

        @if($data['amount']>0&&$data['max_installments']>0)
            @if($data['pass_tax'])
                <p class="dark:text-white text-sm mb-2">em até {{ $data['max_installments'] }}x de R$ {{ number_format(((float)$data['amount'] / (float)$data['max_installments']) / 0.8449, 2, ",", ".") }}</p>
            @else
                <p class="dark:text-white text-sm mb-2">em até {{ $data['max_installments'] }}x de R$ {{ number_format(((float)$data['amount'] / (float)$data['max_installments']), 2, ",", ".") }}</p>
            @endif
        @endif
        @if($data['description']!="")
            <div class="w-full bg-gray-500 mt-6 text-white p-4 rounded-lg">{{ $data['description'] }}</div>
        @endif

        <button wire:click="checkout" class="w-full text-white bg-[#ff6600] hover:bg-[#ff4800] p-2 mt-6 rounded-lg">Continuar</button>
    </div>


    <br/>

</div>
