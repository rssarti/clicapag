<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Link de Pagamento') }}
        </h2>

        <a href="{{ route('link.form') }}" class="float-right bg-gray-900 text-[#ff6600] p-2 rounded-lg">Novo Link</a>

    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800  overflow-hidden shadow-sm sm:rounded-lg">
                <div class="grid grid-cols-2 gap-4 p-6">

                    @foreach($items as $item)
                        <livewire:components.item-link :link="$item" />
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
