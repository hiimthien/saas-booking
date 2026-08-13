<x-mail::message>
# Lời nhắc: Lịch hẹn sắp diễn ra

Xin chào,

Đây là hệ thống nhắc nhở tự động từ SaaS Booking. Bạn có một lịch hẹn sắp diễn ra trong khoảng 1 tiếng nữa.

**Chi tiết lịch hẹn:**
- **Mã cuộc gọi:** {{ $consultation->ulid }}
- **Thời gian bắt đầu:** {{ $consultation->start_time }}
- **Thời lượng:** {{ \Carbon\Carbon::parse($consultation->start_time)->diffInMinutes($consultation->end_time) }} phút

<x-mail::button :url="$consultation->meeting_url">
Vào Phòng Trực Tuyến Ngay
</x-mail::button>

Vui lòng chuẩn bị sẵn sàng trước giờ hẹn ít nhất 5 phút để đảm bảo chất lượng cuộc gọi tốt nhất.

Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!<br>
{{ config('app.name') }}
</x-mail::message>
