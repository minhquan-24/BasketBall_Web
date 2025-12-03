document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('live-search-input');
    const resultsContainer = document.getElementById('search-results');

    if (searchInput) {
        searchInput.addEventListener('keyup', function(e) {
            const keyword = this.value.trim();
            
            if (e.key === 'Enter' && keyword.length > 0) {
                window.location.href = `index.php?controller=products&action=index&keyword=${keyword}`;
                return;
            }

            if (keyword.length > 1) {
                fetch(`index.php?controller=products&action=searchAjax&keyword=${keyword}`)
                    .then(response => response.json())
                    .then(data => {
                        resultsContainer.innerHTML = ''; 
                        
                        if (data.length > 0) {
                            resultsContainer.style.display = 'block';
                            
                            data.forEach(product => {
                                const price = new Intl.NumberFormat('vi-VN').format(product.price);
                                const item = document.createElement('a');
                                item.href = `index.php?controller=products&action=show&id=${product.id}`;
                                item.className = 'list-group-item list-group-item-action d-flex align-items-center p-2';
                                item.innerHTML = `
                                    <img src="${product.image_url}" width=50" height="50" class="me-3 rounded border" style="object-fit:cover;">
                                    <div>
                                        <div class="text-white small">${product.name}</div>
                                        <small class="text-danger">${price} VNĐ</small>
                                    </div>
                                `;
                                resultsContainer.appendChild(item);
                            });

                            const viewAllLink = document.createElement('a');
                            viewAllLink.href = `index.php?controller=products&action=index&keyword=${keyword}`;
                            viewAllLink.className = 'list-group-item list-group-item-action text-center bg-light text-primary fw-bold py-2';
                            viewAllLink.innerHTML = `Xem tất cả kết quả cho "${keyword}" <i class="bi bi-arrow-right"></i>`;
                            
                            resultsContainer.appendChild(viewAllLink);
                            
                        } else {
                            resultsContainer.innerHTML = '<div class="list-group-item text-muted p-2">Không tìm thấy sản phẩm phù hợp.</div>';
                        }
                    })
                    .catch(error => {
                        console.error('Lỗi AJAX:', error);
                        resultsContainer.style.display = 'none';
                    });
            } else {
                resultsContainer.style.display = 'none';
            }
        });

        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !resultsContainer.contains(e.target)) {
                resultsContainer.style.display = 'none';
            }
        });
    }
});