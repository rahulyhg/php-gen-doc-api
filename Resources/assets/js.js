$(document).ready(function () {

    $('#php-apidoctab a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
    });

    $('.tooltipP').tooltip({
        placement: 'bottom'
    });

    $('code[id^=response]').hide();

    $.each($('pre[id^=sample_response]'), function () {
        if ($(this).html() == 'NA') {
            return;
        }
        var str = JSON.stringify(JSON.parse($(this).html().replace(/'/g, '"')), undefined, 4);
        $(this).html(str);
    });

    $.each($('pre.sample_root_object'), function () {
        var str = $(this).html().replace(/'/g, '"');
        $(this).html(str);
    });

    $("[data-toggle=popover]").popover({
        placement: 'right'
    });

    $('body').on('shown.bs.popover', function () {
        var sample = $(this).find(".popover-content");
        console.log(sample);
        var str = '';

        try {
            str = JSON.stringify(JSON.parse(sample.html().replace(/'/g, '"')), undefined, 2);
        } catch (e) {
            str = sample.html();
        }
        sample.html('<pre class="prettyprint">' + str + '</pre>');
        prettyPrint();
    });

    $('body').on('click', '.send', function (e) {
        e.preventDefault();
        var form = $(this).closest('form');
        var matchedParamsInRoute = $(form).attr('action').match(/{\w+}/g);
        var theId = $(this).attr('rel');

        var urlForm = $(form).attr('action');
        var dataSerialize = '';

        if (matchedParamsInRoute) {
            $("form#" + $(form).attr('id') + " input[type=text]").each(function () {
                var input = $(this);
                var index;
                for (index = 0; index < matchedParamsInRoute.length; ++index) {
                    try {
                        var tmp = matchedParamsInRoute[index].replace('{', '').replace('}', '');
                        if ($(this).attr('id') == tmp) {
                            urlForm = urlForm.replace(matchedParamsInRoute[index], $(this).val());
                        }
                    } catch (err) {
                        console.log(err);
                    }
                }
            });
        };

        $('#' + $(form).attr('id') + ' input[type=text]').each(function () {
            if (matchedParamsInRoute.indexOf('{' + $(this).attr('id') + '}') === -1 && $(this).val() !== '') {
                dataSerialize += $(this).serialize() + '&';
            }
        });

        var st_headers = {};
        st_headers[$('#apikey_key').val()] = $('#apikey_value').val();
        $.ajax({
            url: $('#apiUrl').val() + urlForm,
            data: dataSerialize,
            type: '' + $(form).attr('method') + '',
            dataType: 'json',
            headers: st_headers,
            success: function (data, textStatus, jqXHR) {
                if (typeof data === 'object') {
                    $('#response' + theId).html(JSON.stringify(data, undefined, 4)).removeClass("prettyprinted");
                    $('#response_body_' + theId + ' pre').html(JSON.stringify(data, undefined, 4)).removeClass("prettyprinted");
                    prettyPrint();
                } else {
                    $('#response' + theId).html(data);
                    $('#response_body_' + theId + ' pre').html(data);
                }
            },
            error: function (jqXHR, textStatus, error) {
                if (typeof jqXHR.responseJSON === 'object') {
                    $('#response_body_' + theId + ' pre').html(JSON.stringify(jqXHR.responseJSON, undefined, 4)).removeClass("prettyprinted");
                    prettyPrint();
                } else {
                    $('#response_body_' + theId + ' pre').html(jqXHR.responseText);
                }
            },
            complete: function (jqXHR, textStatus) {
                $('#request_url_' + theId + ' pre').html(location.protocol + '//' + location.host + this.url);
                // $('#request_headers_' + theId + ' pre').html(this.headers);
                // console.log(this.headers);
                $('#response_code_' + theId + ' pre').html(jqXHR.status);
                $('#response_headers_' + theId + ' pre').html(jqXHR.getAllResponseHeaders());
                $('#response_' + theId).show();
            }
        });

        return false;
    });
    // Beautify node with class "prettyprint"
    prettyPrint();
});
