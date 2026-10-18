<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mã Giảm Giá 15% Từ Dried Chilli</title>
    <style>
        @media only screen and (max-width: 600px) {
            .email-container {
                width: 100% !important;
                border-radius: 12px !important;
            }
            .email-body {
                padding: 24px 16px 20px !important;
            }
            .email-header {
                padding: 24px 16px !important;
            }
            .email-header h2 {
                font-size: 22px !important;
            }
            .email-title {
                font-size: 20px !important;
            }
            .coupon-box {
                padding: 16px 12px !important;
                margin-bottom: 20px !important;
            }
            .coupon-code-badge {
                font-size: 22px !important;
                letter-spacing: 1.5px !important;
                padding: 8px 12px !important;
                word-break: break-all;
            }
            .cta-button {
                display: block !important;
                width: 100% !important;
                box-sizing: border-box !important;
                padding: 14px 20px !important;
                font-size: 15px !important;
            }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #F8F5F0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #2B1D14; -webkit-font-smoothing: antialiased;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #F8F5F0; padding: 20px 10px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="email-container" style="max-width: 600px; background-color: #FFFFFF; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.06); border: 1px solid #ECE3D4;">
                    <!-- Header -->
                    <tr>
                        <td align="center" class="email-header" style="background-color: #2B1D14; padding: 32px 20px; color: #FFFFFF;">
                            <h2 style="margin: 0; font-size: 26px; font-weight: 800; letter-spacing: 1px; color: #FFFFFF;">
                                DRIED CHILLI
                            </h2>
                            <p style="margin: 8px 0 0; font-size: 13px; color: #E0D3C5; text-transform: uppercase; letter-spacing: 2px;">
                                Authentic Gourmet Spices
                            </p>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td class="email-body" style="padding: 40px 32px 30px;">
                            <h1 class="email-title" style="margin: 0 0 16px; font-size: 24px; font-weight: 800; color: #D32F2F; text-align: center; line-height: 1.3;">
                                BẠN ĐÃ NHẬN ĐƯỢC ƯU ĐÃI 15% OFF! 🎉
                            </h1>
                            <p style="margin: 0 0 24px; font-size: 15px; line-height: 1.6; color: #555555; text-align: center;">
                                Cảm ơn bạn đã đăng ký nhận ưu đãi từ <strong>Dried Chilli</strong>. Dưới đây là mã voucher giảm giá 15% dành riêng cho bạn:
                            </p>

                            <!-- Coupon Box -->
                            <div class="coupon-box" style="background-color: #FDF9F3; border: 2px dashed #D32F2F; border-radius: 12px; padding: 24px 20px; text-align: center; margin-bottom: 28px;">
                                <div style="font-size: 13px; font-weight: 700; color: #8D6E63; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 8px;">
                                    MÃ KHUYẾN MÃI CỦA BẠN
                                </div>
                                <div class="coupon-code-badge" style="font-size: 28px; font-weight: 900; letter-spacing: 2.5px; color: #D32F2F; padding: 10px 16px; background-color: #FFFFFF; display: inline-block; border-radius: 8px; border: 1px solid #FFCDD2; margin-bottom: 12px; user-select: all;">
                                    {{ $coupon->code }}
                                </div>
                                <div style="font-size: 14px; color: #2E7D32; font-weight: 700; margin-bottom: 6px;">
                                    ✔ Giảm 15% cho đơn hàng của bạn
                                </div>
                                @if ($coupon->expires_at)
                                <div style="font-size: 12px; color: #757575;">
                                    Hạn sử dụng: {{ $coupon->expires_at->format('d/m/Y') }}
                                </div>
                                @endif
                            </div>

                            <!-- Instructions -->
                            <div style="background-color: #FAFAFA; border-radius: 10px; padding: 18px 20px; margin-bottom: 30px; border-left: 4px solid #D32F2F;">
                                <h3 style="margin: 0 0 10px; font-size: 14px; font-weight: 700; color: #2B1D14; text-transform: uppercase;">
                                    Cách sử dụng mã:
                                </h3>
                                <ol style="margin: 0; padding-left: 20px; font-size: 13px; line-height: 1.6; color: #555555;">
                                    <li>Chọn các sản phẩm ớt khô và gia vị yêu thích vào giỏ hàng.</li>
                                    <li>Tại trang <strong>Giỏ hàng</strong>, nhập mã <strong style="color: #D32F2F;">{{ $coupon->code }}</strong> vào ô khuyến mãi.</li>
                                    <li>Nhấn <strong>Apply</strong> để áp dụng mức giảm 15% ngay lập tức.</li>
                                </ol>
                            </div>

                            <!-- CTA Button -->
                            <div style="text-align: center; margin-bottom: 20px;">
                                <a href="{{ url('/shop') }}" class="cta-button" style="display: inline-block; background-color: #D32F2F; color: #FFFFFF; font-size: 16px; font-weight: 800; text-decoration: none; padding: 16px 36px; border-radius: 30px; text-transform: uppercase; letter-spacing: 1px; box-shadow: 0 4px 12px rgba(211,47,47,0.35);">
                                    Khám Phá Cửa Hàng Ngay
                                </a>
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #F8F5F0; padding: 24px 32px; text-align: center; border-top: 1px solid #ECE3D4;">
                            <p style="margin: 0 0 8px; font-size: 12px; color: #8D6E63;">
                                Nếu bạn không yêu cầu mã này, bạn có thể yên tâm bỏ qua email.
                            </p>
                            <p style="margin: 0; font-size: 12px; color: #BDBDBD;">
                                &copy; {{ date('Y') }} Dried Chilli. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

