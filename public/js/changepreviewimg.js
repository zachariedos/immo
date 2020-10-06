if ($('.vich-image img').length) {
    $('.vich-image img').css("width", '100%');
    $('.vich-image a').removeAttr("href");
}
$("#bien_imageFile_file").change(function (e) {
    let url = URL.createObjectURL(e.target.files[0]);
    $('.vich-image img').remove();
    let fileName = e.target.files[0].name;
    $(this).next('.custom-file-label').html(fileName);
    $(this).parents('.vich-image').append('<img class="preview_image" src="' + url + '" />');
    $('.vich-image img').css("width", '100%');
})
