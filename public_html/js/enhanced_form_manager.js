$(document).ready(function () {
    $('#commentBoxShortened').click(function () {
        $('#commentBoxShortened').remove();
        $('#commentBoxExpanded')
            .show()
            .find("div[role='textbox']").focus();
    });

    $('.tag').click(function () {
        //var textbox = $('#commentBoxExpanded').find('div[role="textbox"]');
        var sel = window.getSelection();
        alert(sel);
    });
});