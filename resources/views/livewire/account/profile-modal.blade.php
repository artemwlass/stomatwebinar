<section class="modal data-modal {{ $isOpen ? 'active' : '' }}" aria-hidden="{{ $isOpen ? 'false' : 'true' }}">
    <div class="modal-bg" wire:click="close"></div>
    <div class="modal-dialog">
        <div class="container">
            <form wire:submit="save" class="modal-content">
                <div class="modal-content__head">
                    <h2>Редагувати дані</h2>
                    <button type="button" class="modal-close" wire:click="close" aria-label="Закрити">
                        <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.19 11.37L1.44667 20.1133C1.29111 20.2689 1.1 20.3522 0.873333 20.3633C0.646666 20.3744 0.444444 20.2911 0.266666 20.1133C0.0888886 19.9356 0 19.7389 0 19.5233C0 19.3078 0.0888886 19.1111 0.266666 18.9333L9.01 10.19L0.266666 1.44667C0.111111 1.29111 0.0277774 1.1 0.0166663 0.873333C0.00555514 0.646666 0.0888886 0.444444 0.266666 0.266666C0.444444 0.0888886 0.641111 0 0.856667 0C1.07222 0 1.26889 0.0888886 1.44667 0.266666L10.19 9.01L18.9333 0.266666C19.0889 0.111111 19.2806 0.0277774 19.5083 0.0166663C19.7339 0.00555514 19.9356 0.0888886 20.1133 0.266666C20.2911 0.444444 20.38 0.641111 20.38 0.856667C20.38 1.07222 20.2911 1.26889 20.1133 1.44667L11.37 10.19L20.1133 18.9333C20.2689 19.0889 20.3522 19.2806 20.3633 19.5083C20.3744 19.7339 20.2911 19.9356 20.1133 20.1133C19.9356 20.2911 19.7389 20.38 19.5233 20.38C19.3078 20.38 19.1111 20.2911 18.9333 20.1133L10.19 11.37Z" fill="black" />
                        </svg>
                    </button>
                </div>
                <div class="form-group">
                    <input wire:model="full_name" type="text" placeholder="Прізвище ім'я по батькові" class="form-inp">
                    @error('full_name') <div class="form-label text-center" style="color: #BD3333">{{ $message }}</div> @enderror
                    <input wire:model="email" type="email" placeholder="Електронна пошта" class="form-inp">
                    @error('email') <div class="form-label text-center" style="color: #BD3333">{{ $message }}</div> @enderror
                    <input wire:model="phone" type="tel" placeholder="Номер телефону" class="form-inp">
                    @error('phone') <div class="form-label text-center" style="color: #BD3333">{{ $message }}</div> @enderror

                    <div class="form-date">
                        <label>Ваша дата народження</label>
                        <div class="form-date__inp">
                            <input wire:model="birth_day" type="text" inputmode="numeric" placeholder="дд" maxlength="2">
                            <input wire:model="birth_month" type="text" inputmode="numeric" placeholder="мм" maxlength="2">
                            <input wire:model="birth_year" type="text" inputmode="numeric" placeholder="рррр" maxlength="4">
                        </div>
                    </div>
                    @error('birth_day') <div class="form-label text-center" style="color: #BD3333">{{ $message }}</div> @enderror
                    @error('birth_month') <div class="form-label text-center" style="color: #BD3333">{{ $message }}</div> @enderror
                    @error('birth_year') <div class="form-label text-center" style="color: #BD3333">{{ $message }}</div> @enderror

                    <div class="row">
                        <input wire:model="country" type="text" placeholder="Країна" class="form-inp">
                        <input wire:model="city" type="text" placeholder="Місто" class="form-inp">
                    </div>
                    @error('country') <div class="form-label text-center" style="color: #BD3333">{{ $message }}</div> @enderror
                    @error('city') <div class="form-label text-center" style="color: #BD3333">{{ $message }}</div> @enderror

                    <input wire:model="work_place" type="text" placeholder="Місце роботи" class="form-inp">
                    @error('work_place') <div class="form-label text-center" style="color: #BD3333">{{ $message }}</div> @enderror
                    <input wire:model="position" type="text" placeholder="Займана посада" class="form-inp">
                    @error('position') <div class="form-label text-center" style="color: #BD3333">{{ $message }}</div> @enderror

                    <div class="form-radio">
                        @foreach (['Стоматологія', 'Терапевтична стоматологія', 'Ортопедична стоматологія', 'Хірургічна стоматологія', 'Дитяча стоматологія', 'Пародонтологія', 'Ортодонтія', 'Щелепно-лицева хірургія'] as $specialtyOption)
                            <label class="form-radio__item">
                                <input wire:model="specialty" type="radio" value="{{ $specialtyOption }}">
                                <span>{{ $specialtyOption }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('specialty') <div class="form-label text-center" style="color: #BD3333">{{ $message }}</div> @enderror
                </div>
                <button type="submit" class="main-btn">Зберегти</button>
            </form>
        </div>
    </div>
</section>
