<div>
    @php
        // Показывать форму: новый флаг form_enabled ИЛИ старый boolean form ИЛИ наличие массива form
        $showForm = $webinar['form_enabled'] ?? (
            (isset($webinar['form']) && $webinar['form'] === true) || is_array($webinar['form'] ?? null)
        );

        // Массив вопросов по новому формату. На старом — соберём из одиночного form_question.
        $questions = [];
        if (isset($webinar['form']) && is_array($webinar['form'])) {
            $questions = $webinar['form'];
        } elseif (!empty($webinar['form_question'])) {
            // legacy: один вопрос, считаем его select (Да/Нет)
            $questions = [[ 'form_question' => $webinar['form_question'], 'field_type' => 'select' ]];
        }
    @endphp

    @if($showForm)
        <div class="container" style="padding-bottom: 40px">
            <form class="form" id="preorderForm">
                <div style="text-align: center; color: black">
                    <h1>Реєстрація на вебінар</h1>
                </div>

                <div class="mb-3">
                    <input type="text" placeholder="Ваше ім'я" id="name" name="name" class="form-control control">
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

                {{-- ДИНАМИЧЕСКИЕ ВОПРОСЫ --}}
                @foreach($questions as $i => $q)
                    @php
                        $qText = (string)($q['form_question'] ?? '');
                        $qType = in_array(($q['field_type'] ?? 'select'), ['text','select'], true)
                                 ? $q['field_type'] : 'select';
                    @endphp

                    <div class="mb-3" data-q-wrapper data-q-index="{{ $i }}" data-q-type="{{ $qType }}" data-q-text="{{ e($qText) }}">
                        <p style="color: black">{{ $qText }}</p>

                        @if($qType === 'text')
                            <input
                                type="text"
                                class="form-control control"
                                id="dyn_q_{{ $i }}"
                                name="dyn_q_{{ $i }}"
                                placeholder="Ваша відповідь">
                        @else
                            <div class="form-check">
                                <input class="form-check-input"
                                       value="yes"
                                       type="radio"
                                       name="dyn_q_{{ $i }}"
                                       id="dyn_q_{{ $i }}_yes"
                                       checked>
                                <label class="form-check-label" style="color: black" for="dyn_q_{{ $i }}_yes">Так</label>
                            </div>
                            <div class="form-check" style="margin-bottom: 15px">
                                <input class="form-check-input"
                                       value="no"
                                       type="radio"
                                       name="dyn_q_{{ $i }}"
                                       id="dyn_q_{{ $i }}_no">
                                <label class="form-check-label" style="color: black" for="dyn_q_{{ $i }}_no">Ні</label>
                            </div>
                        @endif
                    </div>
                @endforeach

                <button type="submit" class="btn btn-success">Зареєструватися</button>
            </form>
        </div>
    @endif

    <style>
        .form { max-width: 700px; margin: 0 auto; }
        .form .control {
            padding: 30px 50px;
            font-family: Geologica;
            font-size: 18px;
            font-weight: 400;
            border-radius: 20px;
            border: 1px solid rgba(0,0,0,.34);
        }
        .form .control:focus {
            transition: .2s ease;
            color: black;
            background-color: transparent;
            border-color: transparent;
            outline: 0;
            box-shadow: 0 0 0 .25rem #128BD0;
        }
        .form .btn {
            border: none; width: 100%; transition: .2s ease;
            border-radius: 41px; background: #47C0F3; color: #fff;
            font-family: Geologica; font-size: 18px; font-weight: 400;
            padding: 30px; margin-bottom: 30px;
        }
        .form .btn:hover { background-color: #43B8E6; }
        .form .btn:active { background-color: #128BD0; }
    </style>
</div>

<script>
    document.addEventListener('livewire:init', () => {
        const form = document.getElementById('preorderForm');
        if (!form) return;

        form.addEventListener('submit', function (event) {
            event.preventDefault();

            // Базовые поля
            const formData = {
                name:  form.querySelector('#name')?.value ?? '',
                phone: form.querySelector('#phone')?.value ?? '',
                email: form.querySelector('#email')?.value ?? '',
                city:  form.querySelector('#city')?.value ?? '',
                answers: []
            };

            // Собираем динамические ответы
            const wrappers = form.querySelectorAll('[data-q-wrapper]');
            wrappers.forEach(w => {
                const qText = w.dataset.qText || '';
                const qType = w.dataset.qType || 'select';

                let value = null;
                if (qType === 'text') {
                    value = (w.querySelector('input[type="text"]')?.value ?? '').trim();
                } else {
                    value = w.querySelector('input[type="radio"]:checked')?.value || null; // 'yes' | 'no'
                }

                formData.answers.push({ question: qText, type: qType, value });
            });

            // Совместимость со старым ключом endodontics (если единственный вопрос типа select)
            const onlySelect = formData.answers.length === 1 && formData.answers[0].type === 'select';
            formData.endodontics = onlySelect ? formData.answers[0].value : null;

            // Отправка в Livewire
            @this.dispatch('formSubmittedPreorder', { formData });

            // Очистка формы
            form.reset();
        });
    });
</script>
