<div>
    <div class="modal fade callBackModal" id="callBackModal" tabindex="-1" aria-labelledby="callBackModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="callBackModalLabel">Замовити дзвінок</h2>
                    <p class="modal-subtitle">Менеджер зв'язується з Вами найближчим часом</p>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div>
                <div class="modal-body">
                    <!-- Форма обратного звонка -->
                    <form class="callback-form">
                        <div class="mb-4">
                            <!-- <label for="name" class="form-label">Ваше имя</label> -->
                            <input placeholder="Ваше імя" type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-4">
                            <!-- <label for="phone" class="form-label">Номер телефона</label> -->
                            <input placeholder="Ваш телефон" type="tel" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="mb-4">
                            <!-- <label for="phone" class="form-label">Номер телефона</label> -->
                            <input placeholder="Ваша пошта" type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <button type="submit" class="btn btn-success">Відправити</button>
                        <div class="form-check mt-2">
                            <input type="checkbox" class="form-check-input" id="termsCheckbox" required>
                            <label class="form-check-label" for="termsCheckbox">Згоден(а) з політикою конфіденційності</label>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('livewire:init', () => {
        const form = document.querySelector('.callback-form');
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            // Сбор данных из формы
            const formData = {
                name: form.querySelector('#name').value,
                phone: form.querySelector('#phone').value,
                email: form.querySelector('#email').value,
            };

            // Отправка данных через Livewire
        @this.dispatch('formSubmitted2', { formData: formData });

            // Очистка формы
            form.reset();
        });
    })
</script>
