// Shorthand for $( document ).ready()
$(function () {


    $('.runCommand').on('click', function () {
        console.log('run command');

        var url = $(this).data('src');

        $.get(url, function (data) {
            //$(".commandResult").html(data);

            var newHTML = $.map(data, function(value) {
                return(value + '<br>');
            });
            $(".commandResult").html(newHTML.join(""));

            console.log(data);
        });

    })
});