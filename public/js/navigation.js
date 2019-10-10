$(document).ready(function() {
    let page = $.urlParam('page', 1);
    let orderBy = $.urlParam('orderBy', 'id');
    let orderDirection = $.urlParam('orderDirection', 'DESC');

    let sortingElements = $('.js-sort');
    let navigationElements = $('.js-navigation');

    $.each(sortingElements, function (n, e) {
        let data = $(e).data('id');
        let href = {
            page: page,
            orderBy: data,
            orderDirection: orderDirection
        };

        if(data === orderBy) {
            href.orderDirection = href.orderDirection === 'DESC' ? 'ASC' : 'DESC';
            $(e).removeClass('fa-sort');
            $(e).addClass(href.orderDirection === 'DESC' ? 'fa-sort-up' : 'fa-sort-down')
        }

        $(e).parent().attr('href', '?' + $.param(href));
    });

    $.each(navigationElements, function (n, e) {
        let data = $(e).data('id');
        let href = {
            page: data,
            orderBy: orderBy,
            orderDirection: orderDirection
        };

        $(e).attr('href', '?' + $.param(href));
    });

});