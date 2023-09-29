<div class="min-h-screen pt-10 dark:text-white pb-20">
    <div class="mb-10 flex flex-col sm:justify-center items-center bg-gray-100 dark:bg-gray-900">
        <div>
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </div>
    </div>
    <div class="grid sm:px-10 lg:grid-cols-2 lg:px-20 xl:px-32">
        <div class="px-4 pt-8">
            <p class="text-xl font-medium">Informações da sua compra</p>
            <p class="text-gray-400">Veja os detalhes abaixo</p>
            <div class="mt-8 space-y-3 rounded-lg border bg-white text-black px-2 py-4 sm:px-6">
                  <div class="flex w-full">
                       @if ($data['photo'])
                           <img class="object-cover h-32 w-full rounded-lg mb-2 object-cover object-center" src="{{ ($data['photo']) ? "/storage/".$data['photo'] : $this->data['photo']->temporaryUrl() }}">
                       @endif
                   </div>

                    <div class="flex w-full flex-col ">
                        <span class="font-semibold">{{ $data['name']  }}</span>
                        <span class="float-right text-gray-400">em até {{ $data['max_installments'] }}x de R$ {{ number_format(((float)$data['amount'] / (float)$data['max_installments']) / 0.8449, 2, ",", ".") }}</span>
                        <p class="text-lg font-bold">R$ {{ number_format((float)$data['amount'], 2, ",", ".") }}</p>
                        <br/>
                        {{ $data['description'] }}
                    </div>
            </div>

            <p class="mt-8 text-lg font-medium mb-2">Vendedor:</p>
            <div class="relative">
                <div class="rounded-lg border border-gray-600 p-4">
                    <p>Rafael Sarti</p>
                    <p>rs.sarti@gmail.com</p>
                </div>
            </div>
            <p class="mt-8 text-lg font-medium">Método de Pagamento</p>
            <form wire:submit.prevent="save()" class="mt-5 grid gap-6">
                @if($methodError)
                    <div class="relative">
                        <span class="bg-red-500 w-full p-2 rounded-lg animate-pulse"> O método de pagamento deve ser selecionado</span>
                    </div>
                @endif
                <div class="relative">
                    <input wire:model.live="form.type_payment" value="b" class="peer hidden" id="radio_1" type="radio" name="radio">
                    <span class="peer-checked:border-gray-700 absolute right-4 top-1/2 box-content block h-3 w-3 -translate-y-1/2 rounded-full border-8 border-gray-300 bg-white"></span>
                    <label class="peer-checked:border-2 peer-checked:border-gray-700 peer-checked:bg-gray-50 peer-checked:text-black flex cursor-pointer select-none rounded-lg border border-gray-300 p-4" for="radio_1">
                        <div class="ml-5">
                            <span class="mt-2 font-semibold">Boleto Bancário</span>
                            <p class="text-slate-500 text-sm leading-6">Até 3 dias úteis</p>
                        </div>
                    </label>
                </div>
                <div class="relative">
                    <input wire:model.live="form.type_payment" value="c" class="peer hidden" id="radio_2" type="radio" name="radio">
                    <span class="peer-checked:border-gray-700 absolute right-4 top-1/2 box-content block h-3 w-3 -translate-y-1/2 rounded-full border-8 border-gray-300 bg-white"></span>
                    <label class="peer-checked:border-2 peer-checked:border-gray-700 peer-checked:bg-gray-50 peer-checked:text-black flex cursor-pointer select-none rounded-lg border border-gray-300 p-4" for="radio_2">
                        <div class="ml-5">
                            <span class="mt-2 font-semibold">Cartão de Crédito</span>
                            <p class="text-slate-500 text-sm leading-6">Imediato em até {{ $data['max_installments'] }}x</p>
                        </div>
                    </label>
                </div>
                <div class="relative">
                    <input wire:model.live="form.type_payment" value="p" class="peer hidden" id="radio_3" type="radio" name="radio">
                    <span class="peer-checked:border-gray-700 absolute right-4 top-1/2 box-content block h-3 w-3 -translate-y-1/2 rounded-full border-8 border-gray-300 bg-white"></span>
                    <label class="peer-checked:border-2 peer-checked:border-gray-700 peer-checked:bg-gray-50 peer-checked:text-black flex cursor-pointer select-none rounded-lg border border-gray-300 p-4" for="radio_3">
                        <div class="ml-5">
                            <span class="mt-2 font-semibold">PIX</span>
                            <p class="text-slate-500 text-sm leading-6">Imediato</p>
                        </div>
                    </label>
                </div>

        </div>
        <div class="mt-10 bg-gray-50 px-4 pt-8 lg:mt-0 rounded-lg text-black">
            <p class="text-xl font-medium dark:text-gray-800">Detalhes de Pagamento</p>
            <p class="text-gray-400">Complete seus dados de compra</p>
            <div class="">
                <label for="email" class="mt-4 mb-2 block text-sm font-medium">Nome</label>
                <div class="relative">
                    <input wire:model="form.name" type="text" id="text" name="email" class="w-full rounded-md border border-gray-200 px-4 py-3 text-sm shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500" required>
                </div>
                <label for="email" class="mt-4 mb-2 block text-sm font-medium">E-mail</label>
                <div class="relative">
                    <input wire:model="form.email" type="text" id="text" name="email" class="w-full rounded-md border border-gray-200 px-4 py-3 text-sm shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500" required>
                </div>
                <p class="text-xl font-medium dark:text-gray-800 mt-6">Endereço</p>
                <p class="text-gray-400 mb-3">Confirme o seu endereço</p>
                <div class="flex flex-col sm:flex-row mb-3">
                    <div class="w-1/2 mr-3">
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900">CEP</label>
                        <input wire:model.live="form.address_zip_code" wire:keyup.prevent="updateCep" type="text" placeholder="00000-000" id="text" class="cep w-full rounded-md border border-gray-200 px-4 py-3 text-sm shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500" required>
                    </div>
                    <div class="w-3/4 mr-3">
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Endereço</label>
                        <input wire:model.live="form.address" value="{{ $form['address'] }}"  wire:loading.attr="disabled" type="text" placeholder="Ex: Av. Paulista" class="w-full rounded-md border border-gray-200 px-4 py-3 text-sm shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500" required>
                    </div>
                    <div class="w-full lg:w-1/4 mb-2 mr-3">
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Nº</label>
                        <input wire:model="form.address_n" type="text" placeholder="999" id="text" class="w-full rounded-md border border-gray-200 px-4 py-3 text-sm shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500" required>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row">
                    <div class="w-full lg:w-2/4 mb-2 mr-3">
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Complemento</label>
                        <input wire:model="form.address_complement" type="text" id="password" class="w-full rounded-md border border-gray-200 px-4 py-3 text-sm shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div class="w-full lg:w-2/4 mb-2 mr-3">
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Bairro</label>
                        <input wire:model="form.address_district" value="{{ $form['address_district'] }}"  type="text" id="password" class="w-full rounded-md border border-gray-200 px-4 py-3 text-sm shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500" required>
                    </div>
                    <div class="w-full lg:w-2/4 mb-2 mr-3">
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Cidade</label>
                        <input wire:model="form.address_city" value="{{ $form['address_city'] }}" type="text" id="text" class="w-full rounded-md border border-gray-200 px-4 py-3 text-sm shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500" required>
                    </div>
                    <div class="w-full lg:w-2/4 mb-2 mr-3">
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900">UF</label>
                        <select wire:model="form.address_state" class="w-full rounded-md border border-gray-200 px-4 py-3 text-sm shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="">-- SELECIONE</option>
                            <option @if($form['address_state']=="AC") selected @endif value="AC">Acre</option>
                            <option @if($form['address_state']=="AL") selected @endif value="AL">Alagoas</option>
                            <option @if($form['address_state']=="AP") selected @endif value="AP">Amapá</option>
                            <option @if($form['address_state']=="AM") selected @endif value="AM">Amazonas</option>
                            <option @if($form['address_state']=="BA") selected @endif value="BA">Bahia</option>
                            <option @if($form['address_state']=="CE") selected @endif value="CE">Ceará</option>
                            <option @if($form['address_state']=="DF") selected @endif value="DF">Distrito Federal</option>
                            <option @if($form['address_state']=="ES") selected @endif value="ES">Espírito Santo</option>
                            <option @if($form['address_state']=="GO") selected @endif value="GO">Goiás</option>
                            <option @if($form['address_state']=="MA") selected @endif value="MA">Maranhão</option>
                            <option @if($form['address_state']=="MT") selected @endif value="MT">Mato Grosso</option>
                            <option @if($form['address_state']=="MS") selected @endif value="MS">Mato Grosso do Sul</option>
                            <option @if($form['address_state']=="MG") selected @endif value="MG">Minas Gerais</option>
                            <option @if($form['address_state']=="PA") selected @endif value="PA">Pará</option>
                            <option @if($form['address_state']=="PB") selected @endif value="PB">Paraíba</option>
                            <option @if($form['address_state']=="PR") selected @endif value="PR">Paraná</option>
                            <option @if($form['address_state']=="PE") selected @endif value="PE">Pernambuco</option>
                            <option @if($form['address_state']=="PI") selected @endif value="PI">Piauí</option>
                            <option @if($form['address_state']=="RJ") selected @endif value="RJ">Rio de Janeiro</option>
                            <option @if($form['address_state']=="RN") selected @endif value="RN">Rio Grande do Norte</option>
                            <option @if($form['address_state']=="RS") selected @endif value="RS">Rio Grande do Sul</option>
                            <option @if($form['address_state']=="RO") selected @endif value="RO">Rondônia</option>
                            <option @if($form['address_state']=="RR") selected @endif value="RR">Roraima</option>
                            <option @if($form['address_state']=="SC") selected @endif value="SC">Santa Catarina</option>
                            <option @if($form['address_state']=="SP") selected @endif value="SP">São Paulo</option>
                            <option @if($form['address_state']=="SE") selected @endif value="SE">Sergipe</option>
                            <option @if($form['address_state']=="TO") selected @endif value="TO">Tocantins</option>
                        </select>
                    </div>
                </div>

                @if($form['type_payment']=='c')
                    <p class="text-xl font-medium dark:text-gray-800 mt-6">Dados do Cartão</p>
                    <p class="text-gray-400 mb-3">Preencha os dados do cartão</p>
                    <label for="card-holder" class="mt-4 mb-2 block text-sm font-medium">Nome Impresso no Cartão</label>
                    <div class="relative">
                        <input type="text" id="card-holder" name="card-holder" class="w-full rounded-md border border-gray-200 px-4 py-3 pl-11 text-sm uppercase shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500" placeholder="Digite o nome do cartão">
                        <div class="pointer-events-none absolute inset-y-0 left-0 inline-flex items-center px-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <label for="card-no" class="mt-4 mb-2 block text-sm font-medium">Dados do Cartão de Crédito</label>
                    <div class="flex">
                        <div class="relative w-7/12 flex-shrink-0">
                            <input type="text" id="card-no" name="card-no" class="w-full rounded-md border border-gray-200 px-2 py-3 pl-11 text-sm shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500" placeholder="xxxx-xxxx-xxxx-xxxx">
                            <div class="pointer-events-none absolute inset-y-0 left-0 inline-flex items-center px-3">
                                <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M11 5.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1z"></path>
                                    <path d="M2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H2zm13 2v5H1V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1zm-1 9H2a1 1 0 0 1-1-1v-1h14v1a1 1 0 0 1-1 1z"></path>
                                </svg>
                            </div>
                        </div>
                        <input type="text" name="credit-expiry" class="w-full rounded-md border border-gray-200 px-2 py-3 text-sm shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500" placeholder="MM/AA">
                        <input type="text" name="credit-cvc" class="w-1/6 flex-shrink-0 rounded-md border border-gray-200 px-2 py-3 text-sm shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500" placeholder="CVC">


                    </div>

                    <div class="flex mt-3">
                        <div class="relative w-full mr-3">
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Número de Parcelas</label>
                            <select wire:model="form.installments" class="w-full rounded-md border border-gray-200 px-4 py-3 text-sm shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500" required>
                                @for($i=1;$i<=$data['max_installments'];$i++)
                                    <option value="{{ $i }}">{{ $i }}x de R$ {{ number_format((float)$data['amount'] / $i, 2, ",", ".") }}</option>
                                @endfor
                            </select>
                        </div>
                        </div>

                @endif
                <!-- Total -->
                <div class="mt-6 border-t border-b py-2">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-gray-900">Total da Compra</p>
                        <p class="font-semibold text-gray-900">R$ {{ number_format((float)$data['amount'], 2, ",", ".") }}</p>
                    </div>

                    @if($this->data['pass_tax'])
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-gray-900">Taxas</p>
                            <p class="font-semibold text-gray-900">R$ 1,00</p>
                        </div>
                    @endif
                </div>
                <div class="mt-6 flex items-center justify-between">
                    <p class="text-sm font-medium text-gray-900">Total</p>
                    <p class="text-2xl font-semibold text-gray-900">R$ {{ number_format((float)$data['amount'], 2, ",", ".") }}</p>
                </div>
            </div>
            <button type="submit" class="mt-4 mb-8 w-full rounded-md bg-[#ff6600] hover:bg-[#ff4800] px-6 py-3 font-medium text-white">Finalizar Compra</button>
        </div>
        </form>
    </div>
    <script>
        $(document).ready(function() {
            $('.cep').mask('00000-000');
        }) ;
    </script>
</div>
