import * as z from 'zod';

export const loginSchema = z.object({
  email: z.string().min(1, 'Email là bắt buộc').email('Email không đúng định dạng'),
  password: z.string().min(1, 'Mật khẩu là bắt buộc'),
});

export const registerSchema = z.object({
  fullname: z.string().min(2, 'Tên phải chứa ít nhất 2 ký tự').max(255, 'Tên quá dài'),
  email: z.string().min(1, 'Email là bắt buộc').email('Email không đúng định dạng'),
  password: z.string().min(8, 'Mật khẩu phải chứa ít nhất 8 ký tự'),
  terms: z.boolean().refine(val => val === true, {
    message: 'Bạn phải đồng ý với Điều khoản dịch vụ'
  }),
});
