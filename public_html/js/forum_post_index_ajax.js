$(document).ready(function () {
    $("#quickreply").click(function (e) {
        e.preventDefault();

        var button = $('#quickreply');
        var messageBody = $('#quick-reply').find('iframe').contents().find('body#tinymce');
        if (messageBody.text() == "")
        {
            alert('No puedes responder dejando el formulario vacío.');
            return;
        }

        var form = $(this).parents('form');
        var url = form.attr('action');
        var content = messageBody.html();
        form.append("<input type='hidden' name='content' id='content'>");
        $('input#content').val(content);
        var data = form.serialize();

        button.prop('disabled', true).text('Publicando...');

        $.post(url, data, function (r) {

            //alert('Title: '+r.title+'\nContent: '+r.content+'\nPosted by: '+r.user.nickname);
            postResponse(r);
            $('#quick-reply').find('iframe').contents().find('body#tinymce').html("");
            $('#quick-reply').find('#alt-user').val('');

        }).fail(function () {
            alert("Ha ocurrido un error. Asegúrate de que aún tienes acceso a internet.");
        }).always(function () {
            button.prop('disabled', false).text('Publicar');
        });
    });
});

function ViewHtml(element)
{
    return element.wrap('<div>').parent().html();
}

function postResponse(r)
{
    var user_profile_url = r.user.profile_url,
        user_nickname = r.user.nickname,
        user_profile_avatar_url = r.user.profile_avatar_url,
        user_type = r.user.type,
        user_thread_count = r.user.thread_count,
        user_post_count = r.user.post_count,
        user_website = r.user.website,
        user_twitter = r.user.twitter,
        user_country = r.user.country,
        post_title = r.post.title,
        post_content = r.post.content,
        edit_post_url = r.edit_post_url;

    var mother = $('.col-md-10.col-md-offset-1');
    var last_post = mother.find('.panel.panel-default.post').last();

    var new_post = $("<div>").attr("class", 'panel panel-default post').append(
        $("<div>").addClass('panel-heading').append(
            $('<div>').attr('class', 'row').append(
                $("<div>").addClass('col-md-2').append(
                    $("<a>").attr("href", user_profile_url).text(user_nickname)
                )
            ).append(
                $('<div>').addClass('col-md-10').append(
                    post_title + ' / ' + ViewHtml($('<a>').text('Enlace al post'))
                )
            )
        )
    ).append(
        $("<div>").addClass('panel-body').append(
            $("<div>").addClass('row').append(
                $("<div>").addClass('col-md-2').append(
                    $("<p>").append(
                        $('<img>').attr('src', user_profile_avatar_url)
                            .attr('title', 'Avatar de ' + user_nickname)
                            .addClass('img-circle')
                            .attr('style', 'max-width: 150px; max-height: 150px;')
                    )
                ).append(
                    $("<p>").append(
                        user_type
                    )
                ).append(
                    $("<p>").append(
                        'Hilos: ' + user_thread_count
                    )
                ).append(
                    $("<p>").append(
                        'Posts: ' + user_post_count
                    )
                ).append(
                    $("<p>").append(
                        user_website
                    )
                ).append(
                    $("<p>").append(
                        user_twitter
                    )
                ).append(
                    $("<p>").append(
                        'País: ' + user_country
                    )
                )
            ).append(
                $('<div>').addClass('col-md-10').append(
                    $('<p>').append(
                        post_content
                    )
                ).append(
                    $("<p>").append(
                        $('<div>').addClass('row').append(
                            $('<div>').addClass('col-md-8')
                        ).append(
                            $('<div>').addClass('col-md-2')
                        ).append(
                            $('<div>').addClass('col-md-2').append(
                                $('<a>').attr('href', edit_post_url)
                                    .attr('role', 'button')
                                    .addClass('btn btn-success')
                                    .append(
                                        ViewHtml($('<i>').addClass('glyphicon glyphicon-pencil')) + 'Editar'
                                    )
                            )
                        )
                    )
                )
            )
        )
    );

    last_post.after(new_post);
}