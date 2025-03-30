
$(function () {
    var site_url = '';
    $('#vendor').change(function () {
        $.ajax({
            url: site_url + 'filter-vendor-model/' + encodeURIComponent($(this).val()),
            url: site_url + 'filter-used-parts/' + encodeURIComponent($(this).val()),
            type: 'get',
            dataType: 'json',
            success: function (response) {

                let len = response.length;

                $("#model").empty().append('<option disabled selected value="">Модель</option>');
                $("#year").empty().append('<option disabled selected value="">Год</option>');
                $("#engine").empty().append('<option disabled selected value="">Двигатель</option>');
                for (var i = 0; i < len; i++) {
                    var value = response[i]['value'];
                    var text = response[i]['text'];

                    $("#model").append("<option value='" + value + "'>" + text + "</option>");

                }
            }
        });
    });

    $('#model').change(function () {
        $.ajax({
            url: site_url + 'filter-vendor-model/' + encodeURIComponent($('#vendor').val()) + '/' + encodeURIComponent($(this).val()),
            url: site_url + 'filter-used-parts/' + encodeURIComponent($('#vendor').val()) + '/' + encodeURIComponent($(this).val()),
            type: 'get',
            dataType: 'json',
            success: function (response) {

                var len = response.year.length;
                $("#year").empty().append('<option disabled selected value="">Год</option>');
                for (var i = 0; i < len; i++) {
                    var value = response.year[i]['value'];
                    var text = response.year[i]['text'];

                    $("#year").append("<option value='" + value + "'>" + text + "</option>");
                }

                var len = response.engine.length;
                $("#engine").empty().append('<option disabled selected value="">Двигатель</option>');
                for (var i = 0; i < len; i++) {
                    var value = response.engine[i]['value'];
                    var text = response.engine[i]['text'];

                    $("#engine").append("<option value='" + value + "'>" + text + "</option>");
                }

            }
        });
    });
    
    $('#year').change(function () {
        $.ajax({
            url: site_url + 'filter-vendor-model/' + encodeURIComponent($('#vendor').val()) +
                '/' + encodeURIComponent($('#model').val()) + '/' + encodeURIComponent($(this).val()),
            url: site_url + 'filter-used-parts/' + encodeURIComponent($('#vendor').val()) +
                '/' + encodeURIComponent($('#model').val()) + '/' + encodeURIComponent($(this).val()),
            type: 'get',
            //data: {depart:deptid},
            dataType: 'json',
            success: function (response) {

                var len = response.engine.length;
                $("#engine").empty().append('<option disabled selected value="">Двигатель</option>');
                for (var i = 0; i < len; i++) {
                    var value = response.engine[i]['value'];
                    var text = response.engine[i]['text'];

                    $("#engine").append("<option value='" + value + "'>" + text + "</option>");
                }

            }
        });
    });

    $('#parts-filter').submit(function (e) {
        e.preventDefault();
        var search_url = 'filter';
        if ($('#vendor').val()) {
            search_url += '/' + encodeURIComponent($('#vendor').val());
        }
        if ($('#model').val()) {
            search_url += '/' + encodeURIComponent($('#model').val());
        }
        if ($('#year').val()) {
            search_url += '/' + encodeURIComponent($('#year').val());
        }
        if ($('#engine').val()) {
            search_url += '/' + encodeURIComponent($('#engine').val());
        }

        window.location.href = site_url + search_url;
    });

    $('#used-filter').submit(function (e) {
        e.preventDefault();
        var search_url = 'used-parts';
        if ($('#vendor').val()) {
            search_url += '/' + encodeURIComponent($('#vendor').val());
        }
        if ($('#model').val()) {
            search_url += '/' + encodeURIComponent($('#model').val());
        }
        if ($('#year').val()) {
            search_url += '/' + encodeURIComponent($('#year').val());
        }
        if ($('#engine').val()) {
            search_url += '/' + encodeURIComponent($('#engine').val());
        }

        window.location.href = site_url + search_url;
    });
});
