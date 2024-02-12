<?php

namespace Database\Seeders;

use App\Models\BlogPage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BlogPage::create([
            'title' => 'Блог',
            'description' => '<p>У цьому розділі ви знайдете статті на тему стоматологічних<br>вебінарів, поширених запитань та новин stomatwebinar</p>',
            'seo' => [
                'og_title' => 'Курси та вебінари зі стоматології від Ігора Ноєнка',
                'og_description' => 'Шкода гідроксиду кальцію та килимової доріжки. Навіщо лити більше, якщо достатньо 1 мл гіпохлориду для іригації? Знайти МБ2 без мікроскопа легко! Суха конкретика, факти та велика кількість цікавих кейсів. У Вас є що запитати? Нам є що відповісти.',
                'og_image' => 'https://static.tildacdn.com/tild6365-6539-4663-b565-363831303035/mini_2.jpg',
                'og_type' => 'website',
                'og_url' => 'https://stomat-webinar.vercel.app/',
                'title' => 'Курси та вебінари зі стоматології від Ігора Ноєнка',
                'keywords' => 'курс стоматологія, вебінари з стоматології,',
                'meta_description' => 'Навчальні курси та безкоштовні вебінари зі стоматології. Сертифікати від Ігора Ноєнка. Дитяча стоматологія.',
            ],
        ]);

    }
}
