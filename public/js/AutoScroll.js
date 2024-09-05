$(document).ready(function() {
    $(function() {
        var tickerLength = $('.announcements-div ul li').length;
        var tickerHeight = $('.announcements-div ul li').outerHeight();
        $('.announcements-div ul li:last-child').prependTo('.announcements-div ul');
        $('.announcements-div ul').css('marginTop', -tickerHeight);

        function moveTop() {
            $('.announcements-div ul').animate({
                top: -tickerHeight
            }, 600, function() {
                $('.announcements-div ul li:first-child').appendTo('.announcements-div ul');
                $('.announcements-div ul').css('top', '');
            });
        }
        setInterval(function() {
            moveTop();
        }, 3000);
    });
});