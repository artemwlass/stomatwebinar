<x-layout>
    <main>
        <section class="error">
            <div class="container error__container">

                <img class="img-fluid error__img-desktop" src="{{asset('assets/img/404/404.png')}}" alt="">

                <img class="img-fluid error__img-mobile" src="{{asset('assets/img/404/404-mobile.png')}}" alt="">

                <a href="{{\Illuminate\Support\Facades\URL::to('/')}}/#services" class="section__link-secondary">
                    Вибрати вебінар
                </a>

            </div>
        </section>
    </main>
</x-layout>


