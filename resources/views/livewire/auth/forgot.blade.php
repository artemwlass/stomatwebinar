<div>
    <main>

        <div class="register authorization">

            <div class="container authorization__container">

                <form class="register__form authorization__form" wire:submit="sendInstruction">



                    <div class="modal-content">

                        <div class="modal-header">
                            <h2 class="modal-title">Відновлення паролю</h2>

                            <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                        </div>
                        <div class="modal-body">
                            <!-- Форма обратного звонка -->
                            <form class="callback-form">

                                @if (session()->has('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                    @if (session()->has('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                <div class="mb-4">
                                    <!-- <label for="email" class="form-label">Ваша пошта</label> -->
                                    <input wire:model="email" placeholder="Ваша пошта" type="email" class="form-control" id="email" name="email">
                                </div>

                                <button type="submit" class="btn btn-success">Підтвердити</button>

                                <div class="form-tip">
                                    <a href="{{route('login')}}">Увійті</a>

                                </div>

                            </form>
                        </div>

                </form>


            </div>

        </div>

        </section>

    </main>
</div>
