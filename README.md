**VTC SmartNews - Hệ thống tin tức thông minh**

**VTC SmartNews** là một nền tảng báo điện tử hiện đại, tích hợp Trí tuệ nhân tạo (AI) giúp độc giả nắm bắt thông tin nhanh chóng và tương tác thông minh với nội dung bài viết.

---

## 🚀 Tính năng nổi bật
- **AI Summary:** Tự động tóm tắt bài báo súc tích bằng Google Gemini AI.
- **AI Chatbot:** Hỗ trợ độc giả đặt câu hỏi và thảo luận trực tiếp về nội dung bài báo.
- **CMS Management:** Hệ thống quản trị nội dung chuyên nghiệp.
- **Modern UI/UX:** Giao diện được thiết kế tỉ mỉ trên Figma và phát triển bằng Tailwind CSS.

## 🛠 Công nghệ sử dụng
- **Backend:** Laravel 12, MySQL.
- **Frontend:** Tailwind CSS, Blade Template.
- **AI:** Google Gemini API.
- **Design:** Figma.

## 🎨 Design (Figma)
Dự án được thiết kế theo quy trình UI/UX bài bản. 
https://www.figma.com/design/nCnI7jo5qEINojosYRH0AZ/SNH_project?node-id=0-1&t=svOYxvNqO2m0tKCE-1

## 📦 Hướng dẫn cài đặt

1. Clone dự án:
    git clone https://github.com/VinhTran-code/vtc-smartnews.git.
    cd vtc-smartnews
2. Cài đặt thư viện:
    composer install.
    npm install.
    npm run build.
3. cấu hình database:

    lấy file mẫu database ở trong thư mục _database.

4. Cấu hình môi trường:
    Sao chép file .env.example thành .env:
        Bash
        cp .env.example .env
    Tạo khóa ứng dụng:
        Bash
        php artisan key:generate
    Cấu hình Database trong file .env (DB_DATABASE, DB_USERNAME, DB_PASSWORD).

    Dán API Key của bạn vào file .env:
        GEMINI_API_KEY=your_api_key_here
5. khởi chạy:
    php artisan serve

## 👨‍💻 Tác giả
Trần Ngọc Vinh

Chuyên ngành: Kỹ thuật phần mềm - Khoa Công nghệ thông tin.

Trường: Đại học Thủy Lợi (TLU).

Đơn vị thực tập: Phòng R&D - Báo điện tử VTC News.
