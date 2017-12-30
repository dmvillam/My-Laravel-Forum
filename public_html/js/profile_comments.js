$(document).ready(function(){
    $(".pls-rspnd").click(function(e){
        e.preventDefault();
        if ($(this).parent().find(".reply").text() == "")
        {
            if ($(this).parent().find(".replies").css('display') == 'none')
            {
                $(this).parent().find(".replies").css('display', '');
            } else $(this).parent().find(".replies").css('display', 'none');
        }
        if ($(this).parent().find(".reply-form").css('display') == 'none')
        {
            $(this).parent().find(".reply-form").css('display', '');
        } else $(this).parent().find(".reply-form").css('display', 'none');
    });

    $('.btn-delete').click(function(e) {
        e.preventDefault();

        if (confirm('¿Seguro que desea eliminar?'))
        {
            var row = $(this).parentsUntil('.panel','.comment');
            var id = row.attr('id');
            var form = $('#form-delete');
            var url = form.attr('action').replace(':COMMENT_ID', id);
            var data = form.serialize();

            $.post(url, data, function (result) {
                if (row.attr('class').contains("reply"))
                {
                    row.fadeOut();
                }
                else row.parent().fadeOut();
            }).fail(function () {
                alert("Ha ocurrido un error. Asegúrate de que aún tienes acceso a internet.");
            });
        }
    });
    String.prototype.contains = function(it) { return this.indexOf(it) != -1; };

    $('.btn-edit').click(function(e) {
        e.preventDefault();
    });

    $('#ModalEditComment').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var comment_id = button.parentsUntil('.panel','.comment').attr('id');

        var action = $('.hidden-edit-route').val().replace(':COMMENT_ID', comment_id);
        $("#form-edit").attr('action', action);
        var modal = $(this);
        modal.find('.modal-body textarea').val(button.parentsUntil('.panel','.comment').find('.content:first').text());
    });

    $('.btn-avatar').click(function(e) {
        e.preventDefault();
    });

    /*$('.save-avatar').click(function (e) {
        if($('#ModalEditAvatar').find('#avatar')[0].files.length == 0) {
            e.preventDefault();
            $('#ModalEditAvatar').modal('hide');
            $('#ModalEditAvatarError').modal('show');
        }
    });*/
});
