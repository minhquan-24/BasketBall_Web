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

    // =========================================================================
    // HOME PAGE INTERACTIVE MOTION: SHOOTING MINI-GAME
    // =========================================================================
    const interactiveBallWrap = document.getElementById('interactive-ball-wrap');
    const interactiveBall = document.getElementById('interactive-ball');
    const miniHoopNet = document.getElementById('mini-hoop-net');
    const scoreToast = document.getElementById('score-toast');
    let points = 0;
    let isShooting = false;

    if (interactiveBallWrap && interactiveBall) {
        interactiveBallWrap.addEventListener('click', function() {
            if (isShooting) return;
            isShooting = true;

            // Trigger shooting arc animation
            interactiveBall.classList.add('shooting');

            // Ball hits the net
            setTimeout(() => {
                if (miniHoopNet) {
                    miniHoopNet.classList.add('swish');
                }
                points += 3;
                if (scoreToast) {
                    scoreToast.innerHTML = `SWISH! +3 PTS 🔥 (${points} PTS)`;
                    scoreToast.classList.add('active');
                }
            }, 700);

            // Hide toast and reset
            setTimeout(() => {
                if (scoreToast) {
                    scoreToast.classList.remove('active');
                }
                if (miniHoopNet) {
                    miniHoopNet.classList.remove('swish');
                }
            }, 1800);

            // Reset ball position
            setTimeout(() => {
                interactiveBall.classList.remove('shooting');
                isShooting = false;
            }, 2000);
        });
    }

    // =========================================================================
    // HOME PAGE: MASCOT PLAYSTYLE ADVISOR
    // =========================================================================
    const playstyleButtons = document.querySelectorAll('.btn-playstyle');
    const mascotSpeechText = document.getElementById('mascot-speech-text');
    const mascotSpeechAction = document.getElementById('mascot-speech-action');

    const playstyleData = {
        guard: {
            text: "⚡ <strong>Hậu vệ (Guard):</strong> Bạn cần độ bám sân (traction) cực bén, trọng lượng siêu nhẹ và phản xạ đổi hướng tức thì! Gợi ý chiến hài đỉnh cao: <em>Curry 10, Kyrie Flytrap</em>.",
            url: "index.php?controller=products&action=index&keyword=Curry"
        },
        forward: {
            text: "🚀 <strong>Tiền đạo (Forward):</strong> Bạn cần đệm giảm chấn Zoom Air êm ái, bọc mắt cá chắc chắn và lực bật tối đa khi úp rổ! Gợi ý: <em>Nike LeBron 20, Jordan Zion 1</em>.",
            url: "index.php?controller=products&action=index&keyword=LeBron"
        },
        center: {
            text: "🛡️ <strong>Trung phong (Center):</strong> Ưu tiên độ ổn định cao, chống lật cổ chân vững chãi và độ bền càn lướt khu vực dưới rổ! Gợi ý: <em>Adidas Harden Vol 7, Cosmic Unity</em>.",
            url: "index.php?controller=products&action=index&keyword=Harden"
        },
        allround: {
            text: "🌟 <strong>Đa năng (All-Around):</strong> Lựa chọn cân bằng hoàn hảo giữa tốc độ và độ êm, cày tốt cả mặt sân Outdoor lẫn Indoor!",
            url: "index.php?controller=products&action=index"
        }
    };

    if (playstyleButtons.length > 0 && mascotSpeechText) {
        playstyleButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                playstyleButtons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const style = this.getAttribute('data-style');
                if (playstyleData[style]) {
                    mascotSpeechText.style.opacity = '0';
                    setTimeout(() => {
                        mascotSpeechText.innerHTML = playstyleData[style].text;
                        if (mascotSpeechAction) {
                            mascotSpeechAction.href = playstyleData[style].url;
                            mascotSpeechAction.style.display = 'inline-flex';
                        }
                        mascotSpeechText.style.opacity = '1';
                    }, 200);
                }
            });
        });
    }
});