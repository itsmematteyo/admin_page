$(document).ready(function() {
    // Edit button click handler
    $('.action-btn.edit').click(function() {
        const productId = $(this).data('product-id');
        window.location.href = 'edit-product.php?id=' + productId;
    });
    
    // Archive button click handler
    $('.action-btn.archive').click(function() {
        const productId = $(this).data('product-id');
        Swal.fire({
            title: 'Archive Product?',
            text: "Are you sure you want to archive this product?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, archive it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('../actions/archive_product.php', { product_id: productId }, function(response) {
                    if (response.success) {
                        Swal.fire('Archived!', 'Product has been archived.', 'success')
                            .then(() => location.reload());
                    } else {
                        Swal.fire('Error', response.message || 'Failed to archive product', 'error');
                    }
                }, 'json');
            }
        });
    });
    
    // Search and filter functionality
    $('#product-search, #status-filter, #category-filter').on('keyup change', function() {
        const searchText = $('#product-search').val().toLowerCase();
        const statusFilter = $('#status-filter').val();
        const categoryFilter = $('#category-filter').val();
        
        $('#products-table tbody tr').each(function() {
            const $row = $(this);
            const productName = $row.find('td:eq(0)').text().toLowerCase();
            const category = $row.find('td:eq(1)').text();
            const statusClass = $row.find('.status').attr('class').split(' ')[1];
            
            const matchesSearch = productName.includes(searchText);
            const matchesStatus = !statusFilter || statusClass === statusFilter;
            const matchesCategory = !categoryFilter || category === categoryFilter;
            
            if (matchesSearch && matchesStatus && matchesCategory) {
                $row.show();
            } else {
                $row.hide();
            }
        });
    });
});