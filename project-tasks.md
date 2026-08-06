# Project Tasks Tracking

## 1. Môi trường & Backend (Laravel 11)
- [x] Thiết lập Docker Compose (PostgreSQL, Redis, Laravel App).
- [x] Tạo toàn bộ hệ thống Database Migrations & Models:
  - Users, ConsultantProfiles.
  - Categories, Tags, ConsultantTags.
  - Availabilities (Lịch rảnh).
  - Bookings & Payments (Hệ thống đặt lịch & thanh toán).
  - Reviews (Đánh giá).
- [x] Tạo Data Fake (Seeder & Factory) để dễ dàng kiểm thử UI.
- [x] Setup Sanctum API Authentication.
- [x] Hoàn thiện API cốt lõi:
  - `GET /api/consultants` (Danh sách chuyên gia).
  - `GET /api/consultants/{slug}` (Chi tiết chuyên gia).
  - `POST /api/bookings` & `GET /api/bookings/{id}`.
  - `POST /api/payments` (Xử lý thanh toán).
- [x] Tích hợp Socialite (Google Login API) & Password Reset (OTP Email API).

## 2. Frontend (Nuxt 3)
- [x] Setup hệ thống Nuxt 3, Tailwind CSS (Design tokens chuẩn UI/UX).
- [x] Tích hợp Pinia Stores:
  - `auth.ts`: Xử lý trạng thái người dùng (Login, Logout, Token, SSR).
- [x] Xây dựng Composables gọi API chuẩn (`useAsyncData`, `$fetch`).
- [x] Hoàn thiện các giao diện (Pages):
  - Trang danh sách chuyên gia.
  - Trang chi tiết chuyên gia (`/consultants/[slug]`).
  - Trang Checkout (`/checkout`) và Success (`/checkout/success`).
  - Trang Đăng ký (`/register`), Đăng nhập (`/login`).
  - Trang Quên mật khẩu (`/forgot-password`) kèm chức năng nhập mã OTP đẹp mắt.

## 3. Các Luồng Nghiệp Vụ Đã Thông Hoàn Toàn
1. **Luồng Đặt Lịch (Booking & Checkout Flow):** 
   - Khách hàng xem lịch trống của chuyên gia -> Chọn ngày giờ -> Đặt lịch -> Chuyển hướng trang thanh toán -> Xác nhận thanh toán thành công -> Hiển thị hóa đơn (Booking Status).
2. **Luồng Xác thực Người Dùng (Auth Flow):**
   - Đăng nhập/Đăng ký truyền thống (Email & Password).
   - Đăng nhập bằng Google (Social Login chuyển hướng 2 chiều Backend -> Frontend).
   - Quên mật khẩu gửi mã OTP qua Email (Hiện tại đang dùng `MAIL_MAILER=log`, **CẦN SETUP SMTP THẬT VÀO NGÀY MAI**).

---

## 4. Kế hoạch công việc tiếp theo (Ngày mai)
Đây là những phần việc tiếp theo thuộc hệ thống cốt lõi mà chúng ta cần thực hiện:

### Nhóm 1: Quản lý Người Dùng (User Management)
- [ ] Xây dựng trang **Client Dashboard**: Nơi khách hàng cập nhật thông tin cá nhân (Avatar, Số điện thoại) và xem lại các gói tư vấn đã mua.
- [ ] Xây dựng trang **Consultant Dashboard**: Nơi chuyên gia cập nhật Hồ sơ (Bio, Giá tiền, Lĩnh vực).

### Nhóm 2: Lịch & Thu Nhập (Core SaaS Features)
- [ ] Tích hợp tính năng chuyên gia tự thiết lập Lịch rảnh (Availabilities).
- [ ] Trang Thu nhập (Earnings/Wallet) cho phép chuyên gia xem lịch sử dòng tiền.
- [ ] Xây dựng trang Quản trị viên (Admin Panel) để duyệt chuyên gia và xem thống kê tổng.
