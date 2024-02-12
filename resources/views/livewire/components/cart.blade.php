<div>

        <div class="modal-dialog">
            <div class="modal-content">
                @if(\Gloudemans\Shoppingcart\Facades\Cart::count() > 0)
                <div class="modal-header">
                    <h2 class="modal-title" id="orderModalLabel">Ваше замовлення</h2>
                    <!-- Add product details here (name, price, etc.) -->

                    <div class="modal-cart">
                        @foreach(\Gloudemans\Shoppingcart\Facades\Cart::content() as $item)
                            <div class="modal-cart__item">
                                <div class="item-name">
                                    <h6>
                                        {{$item->name}}
                                    </h6>
                                    <p>
                                        {{$item->options->date}} - {{$item->options->time}}
                                    </p>
                                </div>
                                <div class="item-price">
                                    <p>
                                        {{$item->price}}₴
                                    </p>
                                </div>
                                <div class="dismis-item">
                                    <a wire:click.prevent="destroy('{{$item->rowId}}')"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M6.83805 6.42391L0.937637 0.305664L0.217833 0.999841L6.11825 7.11808L0 13.0185L0.694178 13.7383L6.81243 7.83789L12.713 13.9563L13.4328 13.2621L7.53223 7.14371L13.6507 1.24312L12.9565 0.523319L6.83805 6.42391Z" fill="black" fill-opacity="0.5"/>
                                        </svg></a>

                                </div>

                            </div>
                        @endforeach

                    </div>
                    <div class="modal-cart__total">
                        <p>
                            Сумма:
                            <span>{{\Gloudemans\Shoppingcart\Facades\Cart::subtotal()}}₴</span>
                        </p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>
                <div class="modal-body">
                    <!-- Form for order -->
                    <form class="order-form">
                        <div class="mb-4">
                            <!-- Input for customer name -->
                            <input placeholder="Ваше імя" type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-4">
                            <!-- Input for customer name -->
                            <input placeholder="Ваше прiзвище" type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-4">
                            <!-- Input for customer email -->
                            <input placeholder="Ваша пошта" type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-4">
                            <!-- Input for customer phone -->
                            <input placeholder="Ваш телефон" type="tel" class="form-control" id="phone" name="phone" required>
                        </div>
                        <!-- Add more product details if needed -->
                        <button type="submit" class="btn btn-success">Замовити</button>
                        <div class="form-check mt-2">
                            <input type="checkbox" class="form-check-input" id="termsCheckbox" required>
                            <label class="form-check-label" for="termsCheckbox">Підтверджую, що Я уважно ознайомився(лася) з даною інструкцією з накладеними на ній правилами вебінару - *обов'язкове поле
                            </label>
                        </div>
                    </form>
                </div>
                @else
                    <div class="modal-header">
                        <h2 class="modal-title" id="orderModalLabel">Ваше замовлення</h2>
                        <!-- Add product details here (name, price, etc.) -->

                        <div class="modal-cart">
                            <div class="modal-cart__item">
                                <div class="item-name">
                                    <h6>
                                        У кошику порожньо
                                    </h6>
                                </div>


                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        </div>

</div>
