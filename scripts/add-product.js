$(document).ready(function() {
    // Store the current files
    let currentFiles = [];
    
    // Image preview functionality
    $('#product-images').on('change', function() {
        currentFiles = Array.from(this.files);
        updateImagePreview();
        updateUploadLabel();
    });

    // Form reset handler (for the Clear button)
    $('#productForm').on('reset', function() {
        // Clear the image preview
        $('#image-preview').empty();
        currentFiles = [];
        
        // Reset the file input by recreating it
        const fileInput = $('#product-images');
        fileInput.replaceWith(fileInput.val('').clone(true));
        
        // Uncheck all size checkboxes
        $('input[name="sizes[]"]').prop('checked', false);
        
        // Show upload label again
        updateUploadLabel();
    });

    // Handle image deletion
    $(document).on('click', '.delete-image', function() {
        const index = $(this).data('index');
        currentFiles.splice(index, 1);
        
        // Update the file input (this is tricky with multiple files)
        const dataTransfer = new DataTransfer();
        currentFiles.forEach(file => dataTransfer.items.add(file));
        $('#product-images')[0].files = dataTransfer.files;
        
        updateImagePreview();
        updateUploadLabel();
    });

    // Form submission handler
    $('#productForm').on('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        // Validate that at least one size is selected
        const sizes = $('input[name="sizes[]"]:checked').length;
        if (sizes === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please select at least one size!'
            });
            return;
        }

        // Validate that at least one image is selected
        if (currentFiles.length === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please upload at least one product image!'
            });
            return;
        }

        // Show loading indicator
        Swal.fire({
            title: 'Processing...',
            html: 'Please wait while we add your product',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // AJAX request to submit the form
        $.ajax({
            url: '../actions/process-add-product.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Product has been added successfully',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Reset the form completely
                        $('#productForm').trigger('reset');
                    }
                });
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'An error occurred while adding the product: ' + error
                });
            }
        });
    });

    // Function to update image preview
    function updateImagePreview() {
        const previewContainer = $('#image-preview');
        previewContainer.empty();
        
        if (currentFiles.length > 0) {
            currentFiles.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewItem = $('<div>').addClass('preview-item');
                    $('<img>').attr('src', e.target.result)
                              .addClass('preview-image')
                              .appendTo(previewItem);
                    
                    // Add delete button
                    $('<div>').addClass('delete-image')
                              .html('<i class="bx bx-x"></i>')
                              .attr('data-index', index)
                              .appendTo(previewItem);
                    
                    previewItem.appendTo(previewContainer);
                }
                reader.readAsDataURL(file);
            });
        }
    }
    
    // Function to update upload label visibility
    function updateUploadLabel() {
        const uploadLabel = $('.upload-label');
        if (currentFiles.length > 0) {
            uploadLabel.addClass('has-images');
        } else {
            uploadLabel.removeClass('has-images');
        }
    }
});