$(document).ready(function () {
    // Define tolltip header Api-Key
    $('.tooltipP').tooltip({
        placement: 'bottom'
    });

    // Define popover sample value in Path Parameters (for @ApiParams)
    $("a[data-toggle=popover]").click(function () {
        $("a[data-toggle=popover]").not(this).popover('hide');
    });
    $("a[data-toggle=popover]").popover();

    // Prettify node with class "prettyprint"
    prettyPrint();

    // Replace JSON simple quote ' by double quote " in Response Classes (for @ApiReturnRootSample)
    $.each($('pre.sample_root_object'), function () {
        var str = $(this).html().replace(/'/g, '"');
        $(this).html(str);
    });

    // Prettify sample code in popover
    $('tr').on('shown.bs.popover', function () {
        var sample = $(this).find(".popover-content");
        var str = '';

        try {
            str = JSON.stringify(JSON.parse(sample.html().replace(/'/g, '"')), undefined, 2);
        } catch (e) {
            str = sample.html();
        }
        sample.html('<pre class="prettyprint">' + str + '</pre>');
        prettyPrint();
    });

    // Process to send ajax request on API
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

        var customHeaders = {};
        customHeaders[$('#apikey_key').val()] = $('#apikey_value').val();

        $.ajax({
            url: urlForm,
            data: dataSerialize,
            type: '' + $(form).attr('method') + '',
            dataType: 'json',
            headers: customHeaders,
            success: function (data, textStatus, jqXHR) {
                if (typeof data === 'object') {
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
                } else {
                    if( jqXHR.getResponseHeader('content-type').indexOf('text/html') >= 0 ) {
                        $('#response_body_' + theId + ' pre').html('<b>Error : response MIME type equal to \'text/html\'</b>').removeClass("prettyprinted");
                    } else {
                        $('#response_body_' + theId + ' pre').html(jqXHR.responseText).removeClass("prettyprinted");
                    }
                }
                prettyPrint();
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
});
