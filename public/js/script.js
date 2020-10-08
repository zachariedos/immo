$(document).ready(function () {
    const $valueSpan = $('.valueSpanPrixMin');
    const $value = $('#SliderPrixMax');
    $valueSpan.html($value.val());
    $value.on('input change', () => {
        $valueSpan.html($value.val());
    });
});