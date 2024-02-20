<div>
    <a class="header__cart" href="#" data-bs-toggle="modal" data-bs-target="#orderModal">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="30" viewBox="0 0 28 30" fill="none">
            <path d="M25.759 25.78C25.7906 26.0606 25.7622 26.3446 25.676 26.6136C25.5898 26.8824 25.4478 27.13 25.259 27.34C25.0698 27.5496 24.8382 27.717 24.5798 27.8306C24.3212 27.9444 24.0414 28.0022 23.759 28H4.23905C3.95659 28.0022 3.67689 27.9444 3.41835 27.8306C3.15981 27.717 2.92829 27.5496 2.73905 27.34C2.55031 27.13 2.40819 26.8824 2.32201 26.6136C2.23583 26.3446 2.20755 26.0606 2.23905 25.78L3.99905 10H23.999L25.759 25.78Z"
                  stroke="#F7F8F9" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M8.99902 10V7C8.99902 5.67392 9.5258 4.40214 10.4635 3.46446C11.4012 2.52678 12.6729 2 13.999 2C15.3251 2 16.5969 2.52678 17.5346 3.46446C18.4722 4.40214 18.999 5.67392 18.999 7V10"
                  stroke="#F7F8F9" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        @if(\Gloudemans\Shoppingcart\Facades\Cart::count() > 0)
        <span class="cart-badge">{{\Gloudemans\Shoppingcart\Facades\Cart::count()}}</span>
        @endif
    </a>
</div>
@script
<script>
    Livewire.on('openCart', () => {
        Livewire.hook('element.init', ({ component, el }) => {
            window.initPhoneMasks();
            new bootstrap.Modal(document.getElementById('orderModal')).show();
        })
    });
</script>
@endscript

