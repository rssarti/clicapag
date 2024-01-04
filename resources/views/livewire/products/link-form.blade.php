<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Criando Link de Pagamento') }}
        </h2>

    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <form wire:submit.prevent="save" class="bg-white dark:bg-gray-800 shadow-md rounded px-8 pt-6 pb-8 mb-4">
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                    <label class="block dark:text-white text-gray-700 text-sm font-bold mb-2" for="username">
                                        Título do Link
                                    </label>
                                    <input wire:model.live="data.name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" type="text" placeholder="Ex: Ingresso para Workshop">
                                </div>
                                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                    <label class="block dark:text-white text-gray-700 text-sm font-bold mb-2" for="password">
                                        Valor
                                    </label>
                                    <input wire:model.live="data.amount" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="number" placeholder="Ex: 199,00">
                                    {{--                            <p class="dark:text-[#ff6600] text-red-500 text-sm italic">Please choose a password.</p>--}}
                                </div>
                                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                    <label  class="block dark:text-white text-gray-700 text-sm font-bold mb-2" for="password">
                                        Número Max. de Parcelas
                                    </label>
                                    <input wire:model.live="data.max_installments" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" min="1" max="12" type="number" placeholder="Ex: 199,00">
                                    <p class="dark:text-[#ff6600] text-red-500 text-sm italic">Nùmero de Parcelas entre 1x e 12x</p>
                                </div>
                                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                    <label class="block dark:text-white text-gray-700 text-sm font-bold mb-2" for="password">
                                        Imagem
                                    </label>
                                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" type="file" wire:model="data.photo">
                                    <p class="dark:text-[#ff6600] text-red-500 text-sm italic">Nùmero de Parcelas entre 1x e 12x</p>
                                    @error('data.photo') <span class="error">{{ $message }}</span> @enderror
                                </div>
                                <div class="w-full px-3 mb-6 md:mb-0">
                                    <label class="block dark:text-white text-gray-700 text-sm font-bold mb-2" for="password">
                                        Juros Aplicado
                                    </label>
                                    <select wire:model.live="data.pass_tax" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password">
                                        <option value="1">Aplicado para o cliente final</option>
                                        <option value="0">Eu assumirei o custo do juros do parcelamento</option>
                                    </select>

                                </div>
                                <div class="w-full px-3 mb-6 md:mb-0 mt-6">
                                    <label class="block dark:text-white text-gray-700 text-sm font-bold mb-2" for="description">
                                        Descrição
                                    </label>
                                    <textarea wire:model.live="data.description" rows="10" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"></textarea>

                                </div>

                                <div class="w-full px-3 mb-6 md:mb-0 mt-6">
                                    <button type="submit" class="w-full bg-[#ff6600] hover:bg-gray-900 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                                        Salvar
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 dark:bg-gray-900 bg-gray-200 rounded-lg p-8">
                            @if ($data['photo'])
                                <img class="object-cover h-48 w-full rounded-lg mb-6" src="{{ ($data['photo']) ? "/storage/".$data['photo'] : $this->data['photo']->temporaryUrl() }}">
                            @endif
                            <h3 class="px-3 text-[#ff6600] text-2xl mb-2">{{ $data['name'] }}</h3>
                            @if($data['amount']>0)
                            <h3 class="px-3 text-white text-2xl mb-2">R$ {{ number_format($data['amount'], 2, ",", ".") }}</h3>
                            @endif

                                @if($data['amount']>0&&$data['max_installments']>0)
                                    @if($data['pass_tax'])
                                        <p class="px-3 text-white text-sm mb-2">{{ $data['max_installments'] }}x de R$ {{ number_format(((float)$data['amount'] / (float)$data['max_installments']) / 0.8449, 2, ",", ".") }}</p>
                                    @else
                                        <p class="px-3 text-white text-sm mb-2">{{ $data['max_installments'] }}x de R$ {{ number_format(((float)$data['amount'] / (float)$data['max_installments']), 2, ",", ".") }}</p>
                                    @endif
                                @endif
                            @if($data['description']!="")
                            <div class="w-full bg-gray-800 text-white p-3 rounded-lg">{{ $data['description'] }}</div>
                            @endif

                            @if(isset($data['id']))
                                    <div class="w-full">
                                        <a class="dark:text-white bg-[#ff6600] p-2 mt-6 rounded-lg" href="{{ route('pay.link', ['uuid' => $data['uuid']]) }}">Abrir Link</a>
                                    </div>

                            @endif

                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
