$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});
$('#example').popover()
$( document ).ready(function() {
    $('.flex-images').flexImages({rowHeight: 150});

    $('.ds_hassubmenu').click(function() {
        $(this).next().toggle();
        $(this).toggleClass('opened')
    });
    if( $('.ds_hassubmenu').next().children().hasClass('active') ) {
        $('.ds_hassubmenu').next().show();
        $('.ds_hassubmenu').addClass('opened')
    }
});
