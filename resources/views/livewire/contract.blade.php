<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ativação de Conta') }}
        </h2>
    </x-slot>

    @if($contract)
        <form wire:submit="saveStep2">


        <div class="py-12">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 bg-white dark:bg-gray-800 mt-10">
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0 text-center ">
                        <div class="flex justify-center items-center">
                            <img width="100" height="100" class="rounded"
                                 src="https://ui-avatars.com/api/?background=ff6600&color=fff&name={{ $contract->business_name }}">
                        </div>
                        <br/>
                        <h1 class="text-white font-bold text-1xl mb-4">{{ $contract->business_name }}</h1>
                        <hr/>
                        <br/>
                        @if($contract->status=='P')
                            <p class="text-white bg-red-500 p-2 rounded-md">Cadastro Pendente</p>
                        @elseif($contract->status=='V')
                            <p class="text-white bg-yellow-500 p-2 rounded-md">Cadastro em Validação</p>

                        @endif
                    </div>
                    <div class="w-full md:w-3/4 px-3 mb-6 md:mb-0">
                        @if($contract->status!='V')
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full md:w-2/2 px-3 mb-6 md:mb-0">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs dark:text-white font-bold mb-2" for="grid-first-name">
                                    Selecione o Segmento
                                </label>
                                <select wire:model.blur="data.mcc" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white">
                                    @foreach($listMCC as $value)
                                        <option value="{{$value->code}}"> {{ $value->category }} > {{ $value->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs dark:text-white font-bold mb-2" for="grid-first-name">
                                    Data de Abertura da Empresa
                                </label>
                                <input type="date" wire:model="data.business_opening_date" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white">
                            </div>
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs dark:text-white font-bold mb-2" for="grid-first-name">
                                    Nome Transacional
                                </label>
                                <input type="text" wire:model="data.statement_descriptor" maxlength="10" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white">
                                <p class="text-white text-xs italic">{{ __('Nome que irá aparecer na fatura do cliente') }}</p>

                            </div>

                            <div class="mt-5 w-full flex dark:text-white">
                                <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0 bg-gray-700 rounded-md m-3 text-center p-5">
                                    <b>Identificação</b>

                                    @if($identify)
                                        <div class="flex justify-center items-center select-none bg-green-500 border-2 text-white text-xl font-bold p-2 m-2 rounded-full shadow h-20 w-20 focus:outline-none focus:shadow-outline">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-6 h-6">
                                                <path strokeLinecap="round" strokeLinejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                            </svg>
                                        </div>


                                        <p class="mt-5 mb-5 h-32 text-green-600"> Documento Recebido</p>
                                    @else
                                        <p class="mt-5 mb-5 h-32">Documento original com foto, válido em todo território nacional. No caso de pessoa jurídica, enviar o Cartão CNPJ.</p>
                                    @endif


                                    <label>
                                        <p class="w-full bg-gray-50 p-3 text-black">Enviar Imagem</p>
                                        <input wire:model="identify" type="file" class="hidden">
                                    </label>

                                </div>

                                <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0 bg-gray-700 rounded-md m-3 text-center p-5">
                                    <b>Comprovante de Endereço</b>

                                    <p class="mt-5 h-32">Envio de comprovante de endereço da própria empresa ou em nome do sócio</p>

                                    <label>
                                        <p class="w-full bg-gray-50 p-3 text-black">Enviar Imagem</p>
                                        <input wire:model="comprovante" type="file" class="hidden">
                                    </label>
                                </div>

                                <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0 bg-gray-700 rounded-md m-3 text-center p-5">
                                    <b>Comprovante de Atividade</b>

                                    <p class="mt-5 h-32">Alvará, nota fiscal de compras de produtos, fotos do estabelecimento, cartão de visitas, etc.</p>
                                    <label>
                                        <p class="w-full bg-gray-50 p-3 text-black">Enviar Imagem</p>
                                        <input wire:model="atividade" type="file" class="hidden">
                                    </label>

                                </div>
                            </div>

                        </div>

                        <button type="submit" class="w-full bg-red-50 p-3">Salvar</button>

                        @else

                            <h4 class="text-2xl mb-4 font-bold text-white">Estamos validando seus dados</h4>
                            <p class="text-white">Agora é necessário aguardar a validação de nossa equipe e das adquirentes bancárias para autorizar as transações via cartão</p>
                            <p class="text-white mt-5">Vamos te enviar um e-mail no momento da autorização!</p>
                        @endif
                    </div>
                </div>
            </div>

        </div>
        </form>
    @else

        <div class="py-12">
            <h1 class="text-slate-900 font-extrabold text-4xl sm:text-5xl lg:text-6xl tracking-tight text-center dark:text-white">Seja bem vindo!</h1>
            <h2 class="text-2xl sm:text-3xl lg:text-3xl tracking-tight text-center dark:text-white mt-4">Vamos juntos configurar sua empresa e iniciar os pagamentos?</h2>

            <form wire:submit="save" class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 bg-white dark:bg-gray-800 mt-10">
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs dark:text-white font-bold mb-2" for="grid-first-name">
                            Razão Social
                        </label>
                        <input wire:model.blur="data.business_name" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="grid-first-name" type="text" placeholder="Razão Social Empresa - LTDA">
                        <p class="text-red-500 text-xs italic">{{ __('Por favor preencha com a razão social identica ao Contrato Social e Cartão de CNPJ') }}</p>
                    </div>
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 dark:text-white" for="grid-last-name">
                            CNPJ
                        </label>
                        <input wire:model.blur="data.ein" wire:keydown="cnpj" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 cnpj" id="ein" type="text" placeholder="00.000.000/0000-00">
                        @if(!$validate)
                            <p class="text-red-500 text-xs italic mt-3">{{ __('Verifique a digitação correta do CNPJ') }}</p>
                        @else
                            <p class="text-[#32c75f] text-xs italic mt-3">{{ __('CNPJ é valido!') }}</p>
                        @endif
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs dark:text-white font-bold mb-2" for="grid-first-name">
                            E-mail de Cobrança
                        </label>
                        <input wire:model.blur="data.business_email" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="grid-first-name" type="text" placeholder="Ex.: seuemail@dominio.com">
                    </div>
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs dark:text-white font-bold mb-2" for="grid-first-name">
                            Site da Empresa
                        </label>
                        <input wire:model.blur="data.business_website" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="grid-first-name" type="text" placeholder="Ex.: seudominio.com">
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs dark:text-white font-bold mb-2" for="grid-first-name">
                            CEP
                        </label>
                        <input wire:model.blur="data.address_cep" wire:keydown="cep"  class="cep appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="grid-first-name" type="text" placeholder="Ex.: 00000-000">
                    </div>
                    <div class="w-full md:w-2/4 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs dark:text-white font-bold mb-2" for="grid-first-name">
                            Endereço
                        </label>
                        <input wire:model.blur="data.address_street" value="{{ $data['address_street'] }}" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="grid-first-name" type="text" placeholder="Ex.: Av. Paulista">
                    </div>
                    <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs dark:text-white font-bold mb-2" for="grid-first-name">
                            Nº
                        </label>
                        <input wire:model.blur="data.address_n" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="grid-first-name" type="text" placeholder="Ex.: 1235">
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs dark:text-white font-bold mb-2" for="grid-first-name">
                            Complemento
                        </label>
                        <input wire:model.blur="data.address_complement" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="grid-first-name" type="text" placeholder="Ex.: 00000-000">
                    </div>
                    <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs dark:text-white font-bold mb-2" for="grid-first-name">
                            Cidade
                        </label>
                        <input wire:model.live="data.address_city" value="{{ $data['address_city'] }}" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="grid-first-name" type="text" placeholder="Ex.: São Paulo">
                    </div>
                    <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs dark:text-white font-bold mb-2" for="grid-first-name">
                            Bairro
                        </label>
                        <input wire:model.blur="data.address_district" value="{{ $data['address_district'] }}" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="grid-first-name" type="text" placeholder="Ex.: Av. Paulista">
                    </div>
                    <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs dark:text-white font-bold mb-2" for="grid-first-name">
                            UF
                        </label>
                        <input wire:model.blur="data.address_state" value="{{ $data['address_state'] }}" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="grid-first-name" type="text" placeholder="Ex.: 1235">
                    </div>
                </div>



                <div class="flex flex-wrap -mx-3 mb-6">
                    <button type="submit" class="w-full m-3 bg-[#32c75f] p-5" @if(!$validate) disabled @endif>Continuar</button>
                </div>


            </form>

        </div>
    @endif

    <script>
        $(document).ready(function(){
            $('.cnpj').mask('00.000.000/0000-00', {reverse: true});
            $('.cep').mask('00000-000');

        })

    </script>

</div>
