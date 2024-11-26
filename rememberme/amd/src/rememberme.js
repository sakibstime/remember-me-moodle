define(['jquery'], function($) {
    return {
        init: function() {
            $('#rememberme').on('change', function() {
                if ($(this).is(':checked')) {
                    console.log('Remember Me enabled.');
                }
            });
        }
    };
});
