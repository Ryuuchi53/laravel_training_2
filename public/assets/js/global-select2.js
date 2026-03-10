// global-select2.js
window.initSelect2 = function (selector = '[data-type="select2"]') {
    $(selector).each(function () {
        if (!$(this).hasClass("select2-hidden-accessible")) {
            $(this).select2({
                width: '100%',
                placeholder: $(this).data('placeholder') || '',
                allowClear: true
            });
        }
    });
};