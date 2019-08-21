var lastScrollTop = 0;
var hidden = 0;
$(window).scroll(function(event){
    var st = $(this).scrollTop();
    if (st >= lastScrollTop && hidden == 0) {
        $('#navbar').slideUp(200);
        hidden=1;
    }
    if (st < lastScrollTop && hidden ==1){
        $('#navbar').slideDown(200);
        hidden =0;
    }
    lastScrollTop = st;
});