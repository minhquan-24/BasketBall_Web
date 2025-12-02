document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('live-search-input');
    const resultsContainer = document.getElementById('search-results');

    if (searchInput) {
        searchInput.addEventListener('keyup', function(e) {
            const keyword = this.value.trim();
            
            // Nếu ấn Enter thì chuyển trang luôn
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
                            
                            // 1. Hiển thị 5 sản phẩm gợi ý (như cũ)
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

                            // 2. LOGIC MỚI: THÊM NÚT "XEM TẤT CẢ" Ở CUỐI
                            const viewAllLink = document.createElement('a');
                            // Đường dẫn trỏ về trang index có kèm keyword
                            viewAllLink.href = `index.php?controller=products&action=index&keyword=${keyword}`;
                            viewAllLink.className = 'list-group-item list-group-item-action text-center bg-light text-primary fw-bold py-2';
                            viewAllLink.innerHTML = `Xem tất cả kết quả cho "${keyword}" <i class="bi bi-arrow-right"></i>`;
                            
                            resultsContainer.appendChild(viewAllLink);
                            
                        } else {
                            // Nếu không tìm thấy sản phẩm nào
                            resultsContainer.innerHTML = '<div class="list-group-item text-muted p-2">Không tìm thấy sản phẩm phù hợp.</div>';
                        }
                    })
                    .catch(error => {
                        console.error('Lỗi AJAX:', error);
                        resultsContainer.style.display = 'none';
                    });
            } else {
                // Nếu người dùng xóa hết chữ hoặc chỉ gõ 1 chữ -> Ẩn khung kết quả
                resultsContainer.style.display = 'none';
            }
        });

        // 5. UX: Ẩn kết quả khi click ra ngoài vùng tìm kiếm
        document.addEventListener('click', function(e) {
            // Nếu click không trúng ô input VÀ không trúng khung kết quả
            if (!searchInput.contains(e.target) && !resultsContainer.contains(e.target)) {
                resultsContainer.style.display = 'none';
            }
        });
    }
});