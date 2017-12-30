$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();

    $("#selectImageButton").click(function () {
        $("#pic").click();
    });

    $("#pic").change(function() {
        var file = this.files[0];
        var imagefile = file.type;
        if (imagefile == "image/jpeg" || imagefile == "image/png" || imagefile == "image/jpg" || imagefile == "image/gif") {
            $('#imagePreviewRow').append($('#imagePreviewTemplate').html());
            $('.imagePreviewDeleteButton').last().click(deleteAttachment);
            var fd = new FormData(document.querySelector("#form-upload-images")); // XXX: Neex AJAX2

            // You could show a loading image for example...
            $.ajax({
                url: $('#form-upload-images').attr('action'),
                xhr: function () { // custom xhr (is the best)

                    var xhr = new XMLHttpRequest();
                    var total = 0;

                    // Get the total size of files
                    $.each(document.getElementById('pic').files, function (i, file) {
                        total += file.size;
                    });

                    // Called when upload progress changes. xhr2
                    xhr.upload.addEventListener("progress", function (evt) {
                        // show progress like example
                        var loaded = (evt.loaded / total).toFixed(2) * 100; // percent

                        $('.loadingBar').last().css('width', loaded + '%');
                    }, false);

                    return xhr;
                },
                type: 'POST',
                processData: false,
                contentType: false,
                data: fd,
                success: function (data) {
                    $('.imagePreviewLoadingTableCell').last().hide();
                    $('.imagePreviewLoadingTable').last().css('background-image', "url('" + getUrl() + "/attachments/" + data.file_name + "')");
                    $('.imagePreviewDeleteButton').last().attr('data-id', data.id);
                    $('#imagePreviewRow').find('.col-md-3').last().attr('id', 'imagePreview'+data.id);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + ', ' + thrownError + '\n');
                    $('#imagePreviewRow').find('.col-md-3').last().remove();
                }
            });
            $('#btn-upload-images').attr('disabled', false);
        } else {
            //open new modal with error message
            alert('ERROR: solo son admitidos los formatos jpeg, jpg, png, gif.');
            return false;
        }
    });

    deleteAttachment = function(e) {
        e.preventDefault();
        var attachment_id = $(this).data('id');
        var action = $('#hidden-delete-attachment-route').val().replace(':ATTACHMENT_ID', attachment_id);
        $('#delete-attachment-form').attr('action', action);
        var fd = new FormData(document.querySelector("#delete-attachment-form"));
        $.ajax({
            url: action, // Url to which the request is send
            type: "POST",             // Type of request to be send, called as method
            data: fd, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData:false,        // To send DOMDocument or non processed data file it is set to false
            success: function(data)   // A function to be called if request succeeds
            {
                $('#imagePreview'+attachment_id).remove();
            }
        });
    };

    var getUrl = function () {
        var full_url = window.location.href,
            path = window.location.pathname;
        return full_url.substring(0, full_url.indexOf(path));
    }

    $('.imageThumb').find('a').click(function() {
        var img_src = $(this).data('url');
        var info_page = $(this).attr('href');
        $('#attachmentShow').attr('src', img_src);
        var imgModal = $('.imgModal');
        imgModal.find('a.full-size').attr('href', img_src);
        imgModal.find('a.info-page').attr('href', info_page);
    });

    $('a.tags').click(function (e) {
        e.preventDefault();
        var tagsField = $('#tags-field');
        if (tagsField.val() == '')
        {
            tagsField.val($(this).text());
        }
        else
        {
            var tFVal = tagsField.val();
            tagsField.val(tFVal + ',' + $(this).text());
        }
        tagsField.focus();
    });

    $('#search-form').find('button').click(function (e) {
        e.preventDefault();
        var searchForm = $('#search-form');
        var action = searchForm.attr('action');
        searchForm.attr('action', action + '?tags=' + $('#tags-field').val());
        searchForm.submit();
    });
});