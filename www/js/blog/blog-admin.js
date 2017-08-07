function loadPreview() {
    // fill in preview
    $('#contents_area').replaceWith('<div id="contents_area"></div>');
    $('#title_area').html($('#title').val());
    $('#contents_area').html($('#contents').val());
}

function addPost(title, slug, author, contents, categories, callbackFunction) {
    let data = {
        'title'      : title,
        'slug'       : slug,
        'author'     : author,
        'contents'   : contents
    };
    for (let i in categories) {
        data[categories[i]] = true;
    }
    $.post('/ajax/add-post.php', data).done(function (xml) {
        callbackFunction(xml);
    });
}

function editPost(postId, title, slug, author, contents, categories, callbackFunction) {
    let data = {
        'post_id'    : postId,
        'title'      : title,
        'slug'       : slug,
        'author'     : author,
        'contents'   : contents
    };
    for (let i in categories) {
        data[categories[i]] = true;
    }
    $.post('/ajax/edit-post.php', data).done(function (xml) {
        callbackFunction(xml);
    });
}

function checkSlugValidity(postId) {
    checkSlug($('#slug').val(), postId, function (xml) {
        let exists = $('exists', xml).text();
        setSlugValidity(exists);
    });
}

function setSlugValidity(exists) {
    if (exists) {
        $('#slug')[0].setCustomValidity("Slug exists, please change.");
        $('#slug').css('border-color', 'red');
    } else {
        $('#slug')[0].setCustomValidity("");
        $('#slug').css('border-color', '');
    }
}

function displayNotification(message, clearForm) {
    $('#notification-area').html('<div class="notification">' + message + '</div>');
    sendToAnchor('notification');

    if (clearForm) {
        clearAllInputs();
    }
}

function clearAllInputs() {
    $('#post_to_edit').val('');

    $('#title').val('');
    $('#slug').val('');
    $('#author').val('');
    $('#contents').val('');
    $('[id^="category"]').prop('checked', false);

    $('#contents').show('slow');
    $('#preview_area').hide('slow');
    $('#submit_button').hide('slow');
}

function sendToAnchor(name) {
    window.location = String(window.location).replace(/\#.*$/, "") + "#" + name;
}

$(function() {
    // hide post selector since create is default
    $('#post_selector').hide();
    // show when edit selected
    $('input[type=radio]').change(function() {
        if ($('#post_selector').is(':visible')) {
            // create mode, selector will not be visible
            $('#submit_button').val('Post');
            $('#post_to_edit').attr('required', '');
            // data may be pre-filled from selecting a post
            clearAllInputs();
        } else {
            // edit mode, selector will be visible
            $('#submit_button').val('Save');
            $('#post_to_edit').attr('required', 'required');
        }
        // clear selection and toggle visibility
        $('#post_to_edit').val('');
        $('#post_selector').toggle('fast');
    });

    // fill data when post to edit selected
    $('#post_to_edit').change(function() {
        $.ajax({
            url: "/ajax/get-posts.php?id=" + $(this).val()
        }).done(function(xml) {
            // set title and contents
            $('#title').val($('title', xml).text());
            $('#slug').val($('slug', xml).text());
            $('#author').val($('author', xml).text());
            $('#contents').val($('contents', xml).text());
            // clear categories
            $('[id^="category"]').prop('checked', false);
            // set categories
            $('category', xml).each(function() {
                $('#category' + $(this).attr('id')).prop('checked', true);
            });
            checkSlugValidity($('#post_to_edit').val());
            loadPreview();
        });
    });

    $('#title').on('keyup change', function() {
        generateSlug($('#title').val(), function (xml) {
            let slug = $('slug', xml).text();
            $('#slug').val(slug);
            //setSlugValidity(exists);
        });
    });

    $('#slug').on('keyup change', function() {
        const postId = $('#post_to_edit').val();
        checkSlugValidity(postId);
    });

    // preview post
    $('#preview_area').hide();
    $('#submit_button').hide();
    $('#preview_button').click(function() {
        loadPreview();
        // change button -- may seem backward but isn't
        if ($('#preview_area').is(':visible')) {
            $('#preview_button').val('Preview');
            sendToAnchor('edit');
        } else {
            $('#preview_button').val('Edit');
            sendToAnchor('preview');
        }
        // show fields
        $('#contents').toggle('slow');
        $('#preview_area').toggle('slow');
        $('#submit_button').toggle('slow');
    });

    // handle form submit
    $('#post_form').submit(function(e) {
        e.preventDefault();
        const title = $('#title').val();
        const slug = $('#slug').val();
        const author = $('#author').val();
        const contents = $('#contents').val();

        let categories = [];
        $('[name^=category]').each(function() {
            const checked = $(this).prop('checked');
            if (checked) {
                categories.push($(this).attr('name'));
            }
        });

        const action = $('[name="post_interaction"]:checked').val();
        if (action == "create_post") {
            addPost(title, slug, author, contents, categories, function(xml) {
                const error = $('postId', xml).val();
                if (error) {
                    displayNotification('<i class="fa fa-exclamation-circle"></i> Problem creating post: ' + error, false);
                } else {
                    const postId = $('postId', xml).text();
                    displayNotification('<i class="fa fa-check-circle"></i> Post (' + postId + ') created successfully: <a href="/blog/' + slug + '">view post</a>.', true);
                }
            });
        } else {
            const postId = $('#post_to_edit').val();
            editPost(postId, title, slug, author, contents, categories, function(xml) {
                const success = $('success', xml).text();
                if (success) {
                    displayNotification('<i class="fa fa-check-circle"></i> Post edited successfully: <a href="/blog/' + slug + '">view post</a>.', true);
                } else {
                    const error = $('error', xml).val();
                    displayNotification('<i class="fa fa-exclamation-circle"></i> Problem creating post: ' + error, false);
                }
            });
        }
    });
});
