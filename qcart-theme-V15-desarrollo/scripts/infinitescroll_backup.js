jQuery(document).ready(function($) {
    var loadMoreButton = $('#custom-widget-load-more');
    var isLoading = false;
    var currentPage = 1;
    var totalPosts = loadMoreButton.data('total');
    var perPage = loadMoreButton.data('per-page');
    var remainingPosts = loadMoreButton.data('remainingPosts');

    $(window).scroll(function() {
        if ($(window).scrollTop() + ($(window).height())*3 >= $(document).height() - 100 && !isLoading) {
            isLoading = true;
            loadMoreButton.text('');

            var remainingPosts = (totalPosts - (currentPage * perPage)) < 0 ? 0 : (totalPosts - (currentPage * perPage));
            var postsToLoad = (remainingPosts < perPage ? remainingPosts : perPage) < 0 ? 0 : (remainingPosts < perPage ? remainingPosts : perPage) ;

            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: {
                    action: 'custom_widget_load_more',
                    page: currentPage + 1,
                    total: totalPosts,
                    posts_to_load: postsToLoad,
                    remainingPosts : remainingPosts
                },
                success: function(response) {
                    loadMoreButton.text('Cargar más');
                    $('.custom-widget-grid').append(response.data.content);
                    isLoading = false;
                    currentPage++;

                    if (!response.data.has_more) {
                        loadMoreButton.remove();
                    }
                    
                }
            });
        }
    });
});