<div>
    <div class="container" id="liqpay_checkout"></div>
</div>
<script src="//static.liqpay.ua/libjs/checkout.js" async></script>

<script>
    if (typeof fbq === 'function' && !window.__fbLeadTracked) {
        fbq('track', 'Lead');
        window.__fbLeadTracked = true;
    }

    window.LiqPayCheckoutCallback = function () {
        LiqPayCheckout.init({
            data: "{{ $dataEncoded }}",
            signature: "{{ $signature }}",
            embedTo: "#liqpay_checkout",
            language: "ru",
            mode: "embed" // embed || popup
        }).on("liqpay.callback", function (data) {
            const isSuccessfulPayment = data && data.status === 'success';

            if (isSuccessfulPayment && typeof fbq === 'function' && !window.__fbPurchaseTracked) {
                const callbackAmount = parseFloat(data.amount);
                const fallbackAmount = parseFloat("{{ $formattedPurchaseAmount }}");
                const purchaseValue = Number.isFinite(callbackAmount) ? callbackAmount : fallbackAmount;

                fbq('track', 'Purchase', {
                    value: Number(purchaseValue.toFixed(2)),
                    currency: 'UAH'
                });

                window.__fbPurchaseTracked = true;

                setTimeout(function () {
                    window.location.href = '/account';
                }, 300);
                return;
            }

            window.location.href = '/account';
        });
    };
</script>
