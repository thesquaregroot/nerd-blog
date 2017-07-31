
function generateSlug(title, callbackFunction) {
    $.get('/ajax/generate-slug.php?title=' + title).done(function (xml) {
        callbackFunction(xml);
    });
}

// checks slug for existing records
function checkSlug(slug, callbackFunction) {
    checkSlug(slug, null, callbackFunction);
}
// uses post ID to exclude current post
function checkSlug(slug, postId, callbackFunction) {
    let url = '/ajax/check-slug.php?slug=' + slug;
    if (postId) {
        url += '&post_id=' + postId;
    }
    $.get(url).done(function (xml) {
        callbackFunction(xml);
    });
}

function makeActive(element) {
    $('button.active').removeClass('active');
    $(element).addClass('active');
}

function loadComments(postId) {
    $.get('/ajax/get-comments.php?post=' + postId).done(function (xml) {
        let comments = "";
        $('comment', xml).each(function() {
            comments += "<div class=\"comment\" id=\"comment" + $(this).find('id').text() + "\">" +
                        "<div class=\"comment-header\">" +
                        "<span class=\"alias\">" + $(this).find('alias').text() + "</span>" +
                        "<span class=\"timestamp\">" + $(this).find('timestamp').text() + "</span>" +
                        "</div>" +
                        "<pre>" + $(this).find('contents').text() + "</pre>" +
                        "</div>";
        });
        $('.comments').html(comments);
    });
}

function postComment(postId, alias, contents, callbackFunction) {
    $.post('/ajax/add-comment.php', {
        'post_id' : postId,
        'alias' : alias,
        'contents' : contents
    }).done(function(xml) {
        if (typeof callbackFunction == 'function') {
            const success = $('success', xml).length > 0;
            callbackFunction(success);
        }
    });
}

function filterPostsBy(selector) {
    $('.post').hide();
    $(selector).show();
}

function select(category, element) {
    if (category == 'all') {
        filterPostsBy('.post');
    } else {
        filterPostsBy('.post:has(small:contains("' + category + '"))');
    }
    makeActive(element);
}

$(function() {
    // default selection for blog list
    select('all', '#category_selectors button:first');
});

