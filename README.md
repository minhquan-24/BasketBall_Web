# Basketball4Life - Website Bán Giày Bóng Rổ Trực Tuyến

Dự án website thương mại điện tử phục vụ môn học Web Programming. Hệ thống cho phép người dùng xem, tìm kiếm, đặt mua các sản phẩm giày bóng rổ và quản trị viên quản lý sản phẩm, đơn hàng.

## 🚀 Giới thiệu

Basketball4Life là một nền tảng web được xây dựng theo mô hình **MVC (Model-View-Controller)** tự phát triển (Custom Framework), không sử dụng các Framework PHP nặng nề như Laravel hay CodeIgniter. Dự án tập trung vào hiệu năng, bảo mật và trải nghiệm người dùng.

## 🛠️ Công nghệ sử dụng

Dự án sử dụng các công nghệ và thư viện sau (đã được documented theo yêu cầu):

*   **Ngôn ngữ:**
    *   **PHP (v8.0+):** Xử lý logic phía server (Backend).
    *   **JavaScript (ES6):** Xử lý AJAX Search, giỏ hàng động, logic phía client.
    *   **HTML5 / CSS3:** Xây dựng cấu trúc và giao diện.
*   **Cơ sở dữ liệu:**
    *   **MySQL:** Lưu trữ thông tin sản phẩm, người dùng, đơn hàng.
*   **Thư viện & Framework (Front-end):**
    *   **Bootstrap 5.3.3:** Framework CSS chính giúp xây dựng giao diện Responsive (tương thích Mobile/Tablet/Desktop) nhanh chóng.
    *   **Bootstrap Icons:** Bộ icon vector nhẹ và đẹp mắt.
*   **Mô hình kiến trúc:**
    *   **MVC Pattern:** Tách biệt Logic, Dữ liệu và Giao diện.
    *   **Singleton Pattern:** Sử dụng cho kết nối Database (Database.php).

## ✨ Tính năng nổi bật

### 1. Phía Người dùng (User)
*   **Xác thực:** Đăng ký, Đăng nhập (Mật khẩu được mã hóa `password_hash`).
*   **Sản phẩm:**
    *   Xem danh sách sản phẩm, lọc theo danh mục.
    *   Sắp xếp theo giá, ngày tạo.
    *   Phân trang (Pagination).
    *   Xem chi tiết sản phẩm (Hình ảnh, Mô tả).
*   **Tìm kiếm thông minh (AJAX):** Tìm kiếm tên giày tức thì mà không cần tải lại trang.
*   **Giỏ hàng & Thanh toán:**
    *   Thêm sản phẩm vào giỏ (Chọn Size, Số lượng).
    *   Quản lý giỏ hàng: Xóa từng món, chọn món cần thanh toán (Checkbox).
    *   Đặt hàng và lưu vào lịch sử.
*   **Cá nhân:** Xem Profile, Lịch sử mua hàng, Hủy đơn hàng (khi chưa duyệt).

### 2. Phía Quản trị viên (Admin)
*   **Quản lý Sản phẩm:** Thêm, Sửa, Xóa sản phẩm. Quản lý biến thể (Size/Số lượng) động.
*   **Quản lý Người dùng:** Xem danh sách, Xóa người dùng.
*   **Quản lý Đơn hàng:** Xem chi tiết đơn hàng, Cập nhật trạng thái đơn hàng (Duyệt, Đang giao, Hủy...).

### 3. Tối ưu hóa & SEO
*   **SEO:** Sử dụng Semantic HTML, Meta Descriptions động cho từng trang, Schema Markup (JSON-LD) cho sản phẩm.
*   **Security:** Chống SQL Injection (Prepared Statements), XSS Protection (htmlspecialchars).
*   **Responsive:** Giao diện hiển thị tốt trên mọi thiết bị.

## 📂 Cấu trúc thư mục

```text
project-root/
│
├── app/                 # Chứa logic ứng dụng (Core MVC)
│   ├── controllers/     # Xử lý điều hướng (Admin & User)
│   ├── models/          # Tương tác với Database
│   └── core/            # Các file cốt lõi (Database Connection)
│
├── config/              # File cấu hình (database.php)
├── public/              # Thư mục public ra ngoài (css, js, images, index.php)
├── resources/           # Views (Giao diện HTML/PHP)
│   └── views/           # Các file giao diện (products, cart, admin...)
└── README.md            # Tài liệu dự án