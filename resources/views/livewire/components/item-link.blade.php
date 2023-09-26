<a href="{{ route('link.form', ['uuid' => $link->uuid]) }}" class="flex flex-row bg-gray-100 dark:bg-gray-700 hover:dark:text-black dark:text-white hover:bg-gray-200 sm:rounded-lg p-4 mb-3 w-full">
    <div class="basis-1/2">
        <p><b>{{ $link->name }}</b></p>
        <small>Criado: {{ $link->created_at->format("d/m/Y H:i:s") }}</small>
    </div>
    <div class="basis-1/3 p-2">
        <p class="bg-[#ff6600] p-2 rounded-lg text-center">
            {{ $link->views }} <br/>
            Visualizações
        </p>
    </div>
    <div class="basis-1/3 p-2">
        <p class="bg-[#ff6600] p-2 rounded-lg text-center">
            102 <br/>
            Compras
        </p>
    </div>
</a>
