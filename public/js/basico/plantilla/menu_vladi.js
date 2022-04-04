$('.nav-item').click(function() {
    console.log($(this));
    var nav_link = $(this)[0].children[0];
    console.log(nav_link);
    (nav_link).removeClass('collapsed');
});