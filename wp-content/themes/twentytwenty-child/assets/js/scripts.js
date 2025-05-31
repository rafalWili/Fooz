jQuery(document).ready(function($) {


    $.ajax({
        url: fooz_ajax_obj.ajax_url,
        method: 'POST',
        data: {
            action: 'get_recent_books_ajax',
        },
        success: function(response) {
            if (response.success) {
                console.log(response.data); // log books data 
            } else {
                console.log('No data found');
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX error:', error);
        }
    });


});