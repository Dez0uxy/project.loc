$(function () {
    var availableRegion = [
        "АР Крым",
        "Винницкая",
        "Волынская",
        "Днепропетровская",
        "Донецкая",
        "Житомирская",
        "Закарпатская",
        "Запорожская",
        "Ивано-Франковская",
        "Киевская",
        "Кировоградская",
        "Луганская",
        "Львовская",
        "Николаевская",
        "Одесская",
        "Полтавская",
        "Ровенская",
        "Сумская",
        "Тернопольская",
        "Харьковская",
        "Херсонская",
        "Хмельницкая",
        "Черкасская",
        "Черниговская",
        "Черновицкая"
    ];
    $("#region").autocomplete({
        source: availableRegion
    });
    var availableCity = [
        "Киев",
        "Харьков",
        "Одесса",
        "Днепропетровск",
        "Донецк",
        "Запорожье",
        "Львов",
        "Кривой Рог",
        "Николаев",
        "Мариуполь",
        "Луганск",
        "Севастополь",
        "Винница",
        "Макеевка",
        "Симферополь",
        "Херсон",
        "Полтава",
        "Чернигов",
        "Черкассы",
        "Житомир",
        "Сумы",
        "Хмельницкий",
        "Горловка",
        "Ровно",
        "Кировоград",
        "Днепродзержинск",
        "Черновцы",
        "Кременчуг",
        "Ивано-Франковск",
        "Тернополь",
        "Белая Церковь",
        "Луцк",
        "Краматорск",
        "Мелитополь",
        "Керчь",
        "Никополь",
        "Северодонецк",
        "Славянск",
        "Бердянск",
        "Ужгород",
        "Алчевск",
        "Павлоград",
        "Евпатория",
        "Лисичанск",
        "Каменец-Подольский"
    ];
    $("#city").autocomplete({
        source: availableCity
    });

});

emailRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/,
        lastname = $("#lastname"),
        firstname = $("#firstname"),
        middlename = $("#middlename"),
        email = $("#email"),
        tel = $("#tel"),
        password = $("#password"),
        allFields = $([]).add(lastname).add(firstname).add(middlename).add(tel).add(email).add(password),
        tips = $(".validateTips");
var form_elements = $("#docContainer").find(":input");

function updateTips(t) {
    tips
            .text(t)
            .addClass("ui-state-highlight");
    setTimeout(function () {
        tips.removeClass("ui-state-highlight", 1500);
    }, 500);
}

function checkLength(o, n, min, max) {
    if (o.val().length > max || o.val().length < min) {
        o.addClass("ui-state-error");
        updateTips("" + n + " от " + min + " до " + max + " символов.");
        return false;
    } else {
        return true;
    }
}

function checkRegexp(o, regexp, n) {
    if (!(regexp.test(o.val()))) {
        o.addClass("ui-state-error");
        updateTips(n);
        return false;
    } else {
        return true;
    }
}


$('#docContainer').on('submit', function (e) {
    e.preventDefault();

    var valid = true;
    allFields.removeClass("ui-state-error");

    valid = valid && checkLength(email, "Email", 6, 80);
    valid = valid && checkRegexp(email, emailRegex, "например: ivanpetrov@gmail.com");
    valid = valid && checkLength(lastname, "Фамилия", 2, 16);
    valid = valid && checkLength(firstname, "Имя", 2, 16);
    valid = valid && checkLength(middlename, "Отчество", 2, 16);
    valid = valid && checkLength(tel, "Телефон", 7, 16);
    valid = valid && checkLength(password, "пароль", 4, 16);

    //valid = valid && checkRegexp(lastname, /^[a-z]([0-9a-z_\s])+$/i, "Username may consist of a-z, 0-9, underscores, spaces and must begin with a letter.");
    //valid = valid && checkRegexp(password, /^([0-9a-zA-Z])+$/, "Password field only allow : a-z 0-9");

    if (valid) {
        this.submit();
    } else {
        alert('Пожалуйста, заполните все обязательные поля.');
    }
});