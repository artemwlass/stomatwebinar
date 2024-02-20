<div>
    <main>

        <div class="register authorization">

            <div class="container authorization__container">

                <form class="register__form authorization__form" wire:submit="updatePassword">



                    <div class="modal-content">

                        <div class="modal-header">
                            <h2 class="modal-title">Новий пароль</h2>

                            <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                        </div>
                        <div class="modal-body">
                            <!-- Форма обратного звонка -->
                            <form class="callback-form">
                                <div class="mb-4 password">
                                    <input wire:model="password" placeholder="Введіть новий пароль" type="password" class="form-control" id="password" name="password">
                                    <button type="button" id="togglePassword">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="19" viewBox="0 0 25 19" fill="none">
                                            <g clip-path="url(#clip0_0_2998)">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12.5001 0.466309C8.22073 0.466309 4.27964 2.6856 1.5682 6.43269C0.936153 7.30353 0.648254 8.42223 0.648254 9.49447C0.648254 10.5664 0.936041 11.6848 1.5678 12.5556C4.27925 16.3031 8.22052 18.5226 12.5001 18.5226C16.7795 18.5226 20.7206 16.3033 23.4321 12.5562C24.0641 11.6853 24.352 10.5666 24.352 9.49447C24.352 8.42245 24.0642 7.30398 23.4324 6.43325C20.721 2.68581 16.7798 0.466309 12.5001 0.466309ZM9.96891 9.50009C9.96891 8.09947 11.0995 6.96884 12.5001 6.96884C13.9008 6.96884 15.0314 8.09947 15.0314 9.50009C15.0314 10.9007 13.9008 12.0313 12.5001 12.0313C11.0995 12.0313 9.96891 10.9007 9.96891 9.50009ZM12.5001 5.28134C10.1676 5.28134 8.28141 7.16748 8.28141 9.50009C8.28141 11.8327 10.1676 13.7188 12.5001 13.7188C14.8328 13.7188 16.7189 11.8327 16.7189 9.50009C16.7189 7.16748 14.8328 5.28134 12.5001 5.28134Z" fill="#47C0F3" fill-opacity="0.34"/>
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_0_2998">
                                                    <rect width="25" height="19" fill="white"/>
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </button>
                                </div>

                                <button type="submit" class="btn btn-success">Підтвердити</button>

                            </form>
                        </div>

                </form>


            </div>

        </div>

        </section>

    </main>
</div>
