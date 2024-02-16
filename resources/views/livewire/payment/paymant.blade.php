<div>
<br><br><br><br>
    <div id="liqpay_checkout"></div>
    <script src="//static.liqpay.ua/libjs/checkout.js" async></script>

    <script>

        window.LiqPayCheckoutCallback = function() {
            LiqPayCheckout.init({
                data: "{{ $dataEncoded }}",
                signature: "{{ $signature }}",
                embedTo: "#liqpay_checkout",
                language: "ru",
                mode: "embed" // embed || popup
            }).on("liqpay.callback", function(data){
                console.log(data.status);
                console.log(data);
                Livewire.dispatch('payment', { formData: data })
                // Обработка ответа от LiqPay
            }).on("liqpay.ready", function(data){
                // ready
            }).on("liqpay.close", function(data){
                // close
            });
        };
    </script>

</div>
