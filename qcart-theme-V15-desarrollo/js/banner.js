jQuery(document).ready(function($) {
    // Subir imágenes para escritorio
    $('#qcart-theme-desktop-images').on('change', function(e) {
        e.preventDefault();
        var fileInput = $(this)[0];
        var imagesContainer = $(this).next('ul');
        
        if (fileInput.files.length > 0) {
            var fileData = new FormData();
            $.each(fileInput.files, function(i, file) {
                fileData.append('file-' + i, file);
            });

            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: fileData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        $.each(response.data.ids, function(i, imageId) {
                            imagesContainer.append('<li><img src="' + response.data.urls[i] + '" width="100"></li>');
                        });
                    }
                }
            });
        }
    });

    // Subir imágenes para celular
    $('#qcart-theme-mobile-images').on('change', function(e) {
        e.preventDefault();
        var fileInput = $(this)[0];
        var imagesContainer = $(this).next('ul');
        
        if (fileInput.files.length > 0) {
            var fileData = new FormData();
            $.each(fileInput.files, function(i, file) {
                fileData.append('file-' + i, file);
            });

            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: fileData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        $.each(response.data.ids, function(i, imageId) {
                            imagesContainer.append('<li><img src="' + response.data.urls[i] + '" width="100"></li>');
                        });
                    }
                }
            });
        }
    });
});
