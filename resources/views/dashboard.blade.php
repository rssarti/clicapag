<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 p-6">

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="text-white p-5 bg-white rounded-lg">
                        <div class="text-white">
                            <div class="grid grid-cols-2 gap-1">
                                <div class="text-white text-center bg-[#ff6600] rounded-md pb-3 pt-3">
                                    <h3 class="h-10 text-2xl">R$ 100,00</h3>
                                    <p>Recebido</p>
                                </div>
                                <div class="text-white text-center bg-[#ff9933] rounded-md pb-3 pt-3">
                                    <h3 class="h-10 text-2xl">R$ 100,00</h3>
                                    <p>Pendente</p>
                                </div>
                                <div class="text-gray-900 text-center bg-gray-100 rounded-md pb-3 pt-3">
                                    <h3 class="h-10 text-2xl">R$ 100,00</h3>
                                    <p>Expirados</p>
                                </div>
                                <div class="text-gray-900 text-center bg-gray-100 rounded-md pb-3 pt-3">
                                    <h3 class="h-10 text-2xl">R$ 100,00</h3>
                                    <p>Boletos</p>
                                </div>
                            </div>

                        </div>
                        <br/>
                        <hr/>
                        <br/>
                        <div id="chart_dashboard" class="text-black"></div>

                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4 text-white">
                    <h2 class="text-black dark:text-white">Últimos pagamentos</h2>
                    <br/>
                    <div class="overflow-hidden shadow-sm text-black">

                        <livewire:components.item-invoice />
                        <livewire:components.item-invoice />
                        <livewire:components.item-invoice />
                        <livewire:components.item-invoice />



                        <a href="{{ route('invoices') }}" class="button rounded-lg bg-[#ff6600] p-2 w-full text-white mt-5">Veja mais</a>


                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        var options = {
            series: [{
                name: 'Vendas Cartão',
                data: [4500, 32545, 28821, 53210, 48200, 38541, 32154, 54560, 65500]
            }, {
                name: 'Vendas Pix',
                data: [7500, 12500, 32541, 49521, 51200, 42541, 38120, 24123, 35000]
            }, {
                name: 'Vendas Boleto',
                data: [12500, 4500, 32541, 53210, 51200, 28821, 28120, 34123, 39000]
            }],
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set'],
            },
            yaxis: {
                title: {
                    text: 'R$'
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return "R$ " + val + ""
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart_dashboard"), options);
        chart.render();
    </script>
</x-app-layout>
