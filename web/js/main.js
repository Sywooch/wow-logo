function getPortfolioPage(n) {
    $('.page').css('display', 'none');
    $('#page' + n).css('display', 'block');
}

$(function() {
    var sliderValue = [];
    for (var i = 1; i <= 101; i++) {
        sliderValue.push(i);
    }

    $(".slider").slider({
        min:1,
        max:101,
        step:1,
        value:51,
        slide: function( event, ui ) {
            if( sliderValue.indexOf(ui.value)===-1 ) return false;
        }
    });

    $(".open_fancybox").click(function() {
        $.fancybox.open(portfolioImages[$(this).attr('rel')], {
            padding : 10,
            height: 485,
            minHeight: 485,
            maxHeight: 485,
            maxWidth: 740,
            //closeBtn: false,
            helpers: {
                thumbs: {
                    width: 50,
                    height: 50
                }
            }
        });

        return false;
    });

    $('.pageButton').click(function() {
        $('.pageButton').removeClass('active');
        $(this).addClass('active');
        getPortfolioPage($(this).data('id'));
    });
});