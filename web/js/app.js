function fixButtonHeight() {
    $('.select2-container + span.input-group-btn > button').each(function () {
        $(this).height($(this).parent().prev().height() - 20);
    });
}