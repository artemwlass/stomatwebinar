<div>
    @if($webinar['form'] == true)
    <div class="container" style="padding-bottom: 40px">
        <form class="form">
            <div style="text-align: center; color: black">
                <h1>Реєстрація на вебінар</h1>
            </div>
            <div class="mb-3">
                <input type="text"  placeholder="Ваше імя" id="name" name="name" class="form-control control">
            </div>
            <div class="mb-3">
                <input placeholder="Ваш телефон" type="tel" class="form-control control" id="phone" name="phone" required>
            </div>
            <div class="mb-3">
                <input type="email" placeholder="Ваша пошта" id="email" name="email" class="form-control control">
            </div>
            <div class="mb-3">
                <input type="text" placeholder="Ваше місто" id="city" name="city" class="form-control control">
            </div>
            <p style="color: black">{{$webinar['form_question']}}</p>
            <div class="form-check">
                <input class="form-check-input" value="yes" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                <label class="form-check-label"  style="color: black" for="flexRadioDefault1">
                    Так
                </label>
            </div>
            <div class="form-check" style="margin-bottom: 15px">
                <input class="form-check-input" value="no" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                <label class="form-check-label" style="color: black" for="flexRadioDefault2">
                    Ні
                </label>
            </div>

            <button type="submit" class="btn btn-success">Зареєструватися</button>
        </form>
    </div>
    @endif
    <style>
        .form {
            max-width: 700px;
            margin: 0 auto;
        }
        .form .control {
            padding: 30px 50px;
            font-family: Geologica;
            font-size: 18px;
            font-style: normal;
            font-weight: 400;
            line-height: normal;
            border-radius: 20px;
            border: 1px solid rgba(0, 0, 0, 0.34);
        }
        .form .control:focus {
            transition: 0.2s ease;
            color: black;
            background-color: transparent;
            border-color: transparent;
            outline: 0;
            box-shadow: 0 0 0 0.25rem #128BD0;
        }
        .form .btn {
            border: none;
            width: 100%;
            transition: 0.2s ease;
            border-radius: 41px;
            background: #47C0F3;
            color: #fff;
            font-family: Geologica;
            font-size: 18px;
            font-style: normal;
            font-weight: 400;
            line-height: normal;
            padding: 30px;
            margin-bottom: 30px;
        }
        .form .btn:hover {
            transition: 0.2s ease;
            background-color: #43B8E6;
        }
        .form .btn:active {
            transition: 0.2s ease;
            background-color: #128BD0;
        }
    </style>
</div>
<script>
    document.addEventListener('livewire:init', () => {
        const form = document.querySelector('.form');
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            // Сбор данных из формы
            const formData = {
                name: form.querySelector('#name').value,
                phone: form.querySelector('#phone').value,
                email: form.querySelector('#email').value,
                city: form.querySelector('#city').value,
                endodontics: form.querySelector('input[name="flexRadioDefault"]:checked').value
            };

            // Отправка данных через Livewire
        @this.dispatch('formSubmittedPreorder', { formData: formData });

            // Очистка формы
            form.reset();
        });
    })
</script>
