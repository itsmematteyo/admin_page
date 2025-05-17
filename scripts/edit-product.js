$(document).ready(function() {
    // Store the current files (new uploads)
    let currentFiles = [];
    // Store existing images
    let existingImages = $('input[name="existing_images[]"]').map(function() {
        return $(this).val();
    }).get();

    // Function to update upload label visibility
    function updateUploadLabel() {
        const uploadLabel = $('.upload-label');
        const totalImages = existingImages.length + currentFiles.length;
        
        if (totalImages > 0) {
            uploadLabel.addClass('has-images');
        } else {
            uploadLabel.removeClass('has-images');
        }
    }

    // Initialize upload label visibility
    updateUploadLabel();

    // Image preview for new uploads
    $('#product-images').on('change', function() {
        const files = Array.from(this.files);
        currentFiles = currentFiles.concat(files);
        
        updateImagePreview();
        updateUploadLabel();
        
        // Clear the file input while keeping the files in currentFiles
        $(this).val('');
    });

    // Function to update image preview
    function updateImagePreview() {
        const previewContainer = $('#image-preview');
        previewContainer.empty();
        
        // Display existing images first
        existingImages.forEach((imagePath, index) => {
            const previewItem = $('<div>').addClass('preview-item');
            $('<img>').attr('src', '../' + imagePath)
                      .addClass('preview-image')
                      .appendTo(previewItem);
            
            // Add delete button for existing images
            $('<div>').addClass('delete-image')
                      .html('<i class="bx bx-x"></i>')
                      .attr('data-type', 'existing')
                      .attr('data-index', index)
                      .appendTo(previewItem);
            
            previewItem.appendTo(previewContainer);
        });
        
        // Display new uploads
        currentFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewItem = $('<div>').addClass('preview-item');
                $('<img>').attr('src', e.target.result)
                          .addClass('preview-image')
                          .appendTo(previewItem);
                
                // Add delete button for new files
                $('<div>').addClass('delete-image')
                          .html('<i class="bx bx-x"></i>')
                          .attr('data-type', 'new')
                          .attr('data-index', index)
                          .appendTo(previewItem);
                
                previewItem.appendTo(previewContainer);
            }
            reader.readAsDataURL(file);
        });
    }

    // Handle image deletion
    $(document).on('click', '.delete-image', function(e) {
        e.preventDefault();
        const type = $(this).data('type');
        const index = $(this).data('index');
        
        if (type === 'existing') {
            // Mark existing image for removal (will be handled server-side)
            const imagePath = existingImages[index];
            existingImages.splice(index, 1);
            
            // Add hidden input to indicate removed image
            $('#productForm').append(
                `<input type="hidden" name="removed_images[]" value="${imagePath}">`
            );
        } else if (type === 'new') {
            // Remove from currentFiles array
            currentFiles.splice(index, 1);
        }
        
        updateImagePreview();
        updateUploadLabel();
    });

    // Handle form submission
    $('#productForm').on('submit', function(e) {
        e.preventDefault();
        
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

        // Validate that at least one image remains (existing or new)
        if (existingImages.length === 0 && currentFiles.length === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please keep at least one product image!'
            });
            return;
        }

        // Show loading indicator
        Swal.fire({
            title: 'Processing...',
            html: 'Please wait while we update your product',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Create FormData and append all form data
        const formData = new FormData(this);
        
        // Remove the original file input to prevent duplicate files
        formData.delete('productImages[]');
        
        // Append all current files (new uploads) with proper file names
        currentFiles.forEach((file) => {
            formData.append('productImages[]', file, file.name);
        });

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success'
                    }).then(() => {
                        window.location.href = 'view-products.php';
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: response.message,
                        icon: 'error'
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    title: 'Error!',
                    text: 'An error occurred while updating the product',
                    icon: 'error'
                });
            }
        });
    });
});