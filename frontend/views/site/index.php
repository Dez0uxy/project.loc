<?php

/** @var yii\web\View $this */
/** @var common\models\FilterAuto $vendors */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Запчастини на американські автомобілі за вигідними цінами від перевірених виробників';

$this->registerMetaTag(['property' => 'og:url', 'content' => \yii\helpers\Url::to('', true)], 'og:url');
$this->registerMetaTag(['property' => 'og:image', 'content' => \yii\helpers\Url::to('/', true).'images/Main4.png'], 'og:image');
$this->registerMetaTag(['property' => 'og:image:type', 'content' => 'image/png'], 'og:image:type');
$this->registerMetaTag(['property' => 'og:image:width', 'content' => 483], 'og:image:width');
$this->registerMetaTag(['property' => 'og:image:height', 'content' => 292], 'og:image:height');
?>
<div class="amercars_cover">
    <?php $form = ActiveForm::begin([
            'id' => 'searchForm',
        'action' => ['search/index'],
        'method' => 'get',
        'enableClientValidation' => false,
    ]); $sfModel = new \frontend\models\SearchForm();?>
        <?= $form->field($sfModel, 'q')
            ->textInput(['required' => 'required', 'placeholder' => 'номер деталі (артикул)', 'class' => 'form-control', 'id' => 'search_field', 'style' => 'width:80%;float: left;'])
            ->label(false) ?>
        <input value="пошук" type="submit">
    <?php ActiveForm::end(); ?>
    <img src="images/Main4.png" alt="Запчастини AmericanCars" style="margin-top: -17px !important;" />
    <div class="search_item">
        <form id="parts-filter">
            <select id="vendor" name="vendor">
                <option value="">Марка</option>
                <?php foreach ($vendors as $vendor): ?>
                    <?= '<option value="'.Html::encode($vendor).'">'.Html::encode($vendor).'</option>' ?>
                <?php endforeach; ?>
            </select>

            <select id="model" name="model">
                <option value="">Модель</option>
            </select>

            <select id="year" name="year">
                <option value="">Рік</option>
            </select>
            <select id="engine" name="engine">
                <option value="">Двигун</option>
            </select>
            <input type="submit" name="search_item" value="знайти запчастини">
        </form>
    </div>
</div>
<div class="content">
    <div class="static_pages">
        <h1><?= Html::encode($this->title) ?></h1>

        <h2 style="text-align:center"><span style="font-size:18px"><span style="font-family:tahoma,geneva,sans-serif"><span style="color:#000000"><strong>Наш інтернет-магазин пропонує:</strong></span></span></span></h2>

        <h3 style="margin-left:36pt">&bull;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-family:tahoma,geneva,sans-serif">&nbsp;<span style="font-size:16px"> 
                    <strong>Автозапчастини для американських авто, 
                        <span style="color:#000000">починаючи від 1981 року випуску.</span></strong></span></span></h3>

        <p style="margin-left:18pt"><span style="font-family:tahoma,geneva,sans-serif">
                <span style="color:#000000">Тут ви знайдете запчастини для Додж, Крайслер, Акура, Б’юїк, Кадилак, Шевроле, Форд, Лінкольн, Хаммер, Понтіак, Джип.</span></span></p>

        <h3 style="margin-left:36pt"><span style="font-family:tahoma,geneva,sans-serif"><span style="color:#000000">&bull;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style="font-size:16px"><strong>Більше 10&nbsp;000 найменувань запчастин в наявності</strong></span></span></span></h3>

        <p style="margin-left:18pt"><span style="font-family:tahoma,geneva,sans-serif"><span style="color:#000000">Майже всі позиції з нашого </span>каталогу американських автозапчастин<span style="color:#000000"> є на нашому складі. Ви отримуєте необхідні деталі в стислі строки, не витрачаючи час на очікування.</span></span></p>

        <h3 style="margin-left:36pt"><span style="font-family:tahoma,geneva,sans-serif"><span style="color:#000000">&bull;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Доставка рідкісних автозапчастин з Америки в Україну під замовлення</strong></span></span></h3>

        <p style="margin-left:18pt"><span style="font-family:tahoma,geneva,sans-serif"><span style="color:#000000">Вам потрібні запчастини, яких немає в жодному магазині? Ми доставимо їх для вас з США протягом 10-14 днів.</span></span></p>

        <h3 style="margin-left:36pt"><span style="font-family:tahoma,geneva,sans-serif"><span style="color:#000000">&bull;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style="font-size:16px"><strong>Вигідні ціни</strong></span></span></span></h3>

        <p style="margin-left:18pt"><span style="font-family:tahoma,geneva,sans-serif"><span style="color:#000000">Працюємо напряму з американськими, європейськими постачальниками, тому ви отримуєте автозапчастини без витрат за послуги посередників.</span></span></p>

        <h3 style="margin-left:36pt"><span style="font-family:tahoma,geneva,sans-serif"><span style="color:#000000">&bull;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style="font-size:16px"><strong>Комплектування та відправка автозапчастин в день замовлення</strong></span></span></span></h3>

        <p style="margin-left:18pt"><span style="font-family:tahoma,geneva,sans-serif"><span style="color:#000000">Оформлюйте замовлення у зручний для вас спосіб, а ми надішлемо необхідні вам запчастини в той самий день. Для мешканців Києва діє кур’єрська доставка і можливий самовивіз зі складу.</span></span></p>

        <h3 style="margin-left:36pt"><span style="font-family:tahoma,geneva,sans-serif"><span style="color:#000000">&bull;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style="font-size:16px"><strong>Постійні знижки для оптових покупців</strong></span></span></span></h3>

        <p style="margin-left:18pt"><span style="font-family:tahoma,geneva,sans-serif"><span style="color:#000000">Станьте нашим постійним партнером та заробляйте більше, ніж ваші конкуренти. Для оптових покупців передбачена приваблива система знижок.</span></span></p>

        <h3 style="margin-left:36pt"><span style="font-family:tahoma,geneva,sans-serif"><span style="color:#000000">&bull;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style="font-size:16px"><strong>Гарантія якості та повернення</strong></span></span></span></h3>

        <p style="margin-left:18pt"><span style="font-family:tahoma,geneva,sans-serif"><span style="color:#000000">Ми гарантуємо 100% якість оригінальних запчастин. Якщо деталь не підійшла або виявилась зайвою, ми зобов’язуємось обміняти її або повернути гроші протягом 14 днів*.</span></span></p>

        <p><span style="font-family:tahoma,geneva,sans-serif"><span style="color:#000000">* за виключення автозапчастин, які були відправлені з США під ваше замовлення. Транспортні витрати під час обміну та повернення товару - за рахунок покупця.</span></span></p>

        <h2 style="text-align:center"><span style="font-size:18px"><span style="font-family:tahoma,geneva,sans-serif"><span style="color:#000000"><strong>Як замовити автодеталі?</strong></span></span></span></h2>

        <p><span style="color:#000000"><span style="font-family:tahoma,geneva,sans-serif">Скористайтесь одним із способів оформлення замовлення:</span></span></p>

        <p style="margin-left:36pt"><span style="font-family:tahoma,geneva,sans-serif"><span style="color:#000000">&bull;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Знайдіть деталь за назвою або кодом в каталозі</span> нових<span style="color:#000000"> або </span>б/в запчастин<span style="color:#000000"> через систему пошуку.</span></span></p>

        <p style="margin-left:36pt"><span style="font-family:tahoma,geneva,sans-serif"><span style="color:#000000">&bull;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Надішліть з нашого сайту</span> <a href="/vin-request/">VIN-запит</a><span style="color:#000000"> зазначивши параметри автомобіля. Наші менеджери оперативно опрацюють його, зв’яжуться з вами та нададуть готове рішення.</span></span></p>

        <p style="margin-left:36pt"><span style="font-family:tahoma,geneva,sans-serif"><span style="color:#000000">&bull;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Напишіть на нашу </span><a href="/contact/">електронну пошту</a><span style="color:#000000"> або зателефонуйте на номери телефонів, які вказані на сайті. Ми перевіримо наявність на складі необхідних автозапчастин та повідомимо вам результат.</span></span></p>

        <p><span style="color:#000000"><span style="font-family:tahoma,geneva,sans-serif">Детальна інформація про умови поставки автозапчастин в розділі &laquo;Доставка та оплата&raquo;.</span></span></p>

        <h2 style="text-align:center"><span style="font-size:18px"><span style="font-family:tahoma,geneva,sans-serif"><strong><span style="color:#000000">Які </span>автозапчастини для американьских машин <span style="color:#000000">можна купити у нас?</span></strong></span></span></h2>

        <p style="margin-left:36pt"><span style="font-family:tahoma,geneva,sans-serif">&bull;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style="color:#000000"><strong>Оригінальні автозапчастини американських виробників (GM, Ford, Chrysler(Mopar))</strong></span></span></p>

        <p style="margin-left:36pt"><span style="font-family:tahoma,geneva,sans-serif"><span style="color:#000000">&bull;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Сертифіковані запчастини від більш ніж 40 провідних світових брендів (Acdelco, Airtex, Ajusa, Autoextra, Behr, Bendix, Bosch, Cardone, Carlson, Centric, Crown, Clevite, Dayco, Denso, Depo, Dorman, Fel-Pro, Fram, Gates, GMB, Interparts, KYB, Kendall, Mevotech, Mobil, Monroe, Moog, National, NGK, Raybestos, Remsa, Ruville, Sachs, SCT, Sealed Power, Spectra Premium, Standard, Stant, Timken, Toko, TRW, Victor Reinz, Wagner, Walbro, Wix та інші).</strong></span></span></p>

        <p style="margin-left:18pt"><span style="color:#000000"><span style="font-family:tahoma,geneva,sans-serif">В каталозі нашого інтернет-магазину ви знайдете повний спектр запчастин для американських автомобілів: деталі кузову, двигуна та підвіски; запчастини для рульової, паливної, гальмівної, оптичної систем; електрообладнання; витратні матеріали та ін.</span></span></p>

    </div>
</div>