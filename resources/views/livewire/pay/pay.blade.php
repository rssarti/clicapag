<div>
    <div class="dark:text-white text-center justify-center items-center">

        <div class="bg-white rounded-lg w-full justify-center items-center content-center	 object-center	 p-4 mb-6">
            <div class="grid place-items-center">
                {{ QrCode::size(200)->generate($payment->data_payment['payment_method']['qr_code']['emv']) }}
            </div>

        </div>

        <h2 class="text-4xl font-bold mb-6">R$ {{ number_format($payment->amount, 2, ",", ".") }}</h2>
        <h2 class="text-sm">Pagamento para: Rafael Ulisses Sarti</h2>
        <h2 class="text-sm">VIA: ZOOP BRASIL</h2>
    </div>
</div>
