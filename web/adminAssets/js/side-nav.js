$(function(){
    $('.side-nav > ul.nav').on('mouseenter','> li.menu-list',function() {
        $(this).addClass('nav-hover');
    }).on('mouseleave','> li.menu-list',function(){
        $(this).removeClass('nav-hover');
    });

    $('.side-nav > ul.nav > li.menu-list').on('click','> a',function(){
        var li_menu = $(this).parent('.menu-list');
        var is_active = li_menu.hasClass('nav-active');
        var all_li_menu = $('.side-nav > ul.nav > li.menu-list');
        all_li_menu.removeClass('nav-active');
        all_li_menu.find('.sub-menu-list').collapse('hide');
        all_li_menu.find('> a').addClass('collapsed');

        if(!is_active){
            $(this).next('.sub-menu-list').collapse('show');
            li_menu.addClass('nav-active');
            $(this).removeClass('collapsed');
        }
    });
});