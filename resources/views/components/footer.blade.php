<style>
    .site-footer {
        width: 100%;
        background: #fff;
        color: #111827;
        border-top: 1px solid #e5e7eb;
        box-shadow: 0 -8px 24px rgba(0, 0, 0, .06);
    }

    .site-footer .footer-inner {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 60px;
        display: flex;
        /* ใช้ flex */
        justify-content: space-between;
        /* ดันซ้าย-ขวา */
        align-items: flex-start;
        gap: 32px;
    }

    .footer-brand img {
        width: 140px;
        height: auto;
        display: block;
        margin-bottom: 12px;
    }

    .footer-brand .tagline {
        color: #6b7280;
        line-height: 1.6;
    }

    .footer-brand {
        flex: 1;
        /* กินพื้นที่ 1 ส่วน */
        max-width: 600px;
        /* กำหนดความกว้างสูงสุด */
    }

    .footer-right {
        flex: 2;
        /* กินพื้นที่ 2 ส่วน (กว้างกว่า logo) */
        display: flex;
        justify-content: flex-end;
        /* เน้นชิดขวา */
        gap: 50px;
    }


    .site-footer h4 {
        font-size: 1.05rem;
        font-weight: 700;
        margin: 8px 0 14px;
        position: relative;
    }

    .site-footer h4::after {
        content: "";
        display: block;
        width: 32px;
        height: 2px;
        background: #0B76BC;
        margin-top: 8px;
        border-radius: 999px;
    }

    .site-footer ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .site-footer li+li {
        margin-top: 8px;
    }

    .site-footer a {
        color: #0B76BC;
        text-decoration: none;
    }

    .site-footer a:hover,
    .site-footer a:focus-visible {
        text-decoration: underline;
    }

    .footer-bottom {
        border-top: 1px solid #f0f1f3;
        text-align: center;
        color: #6b7280;
        padding: 14px 60px 18px;
        font-size: .95rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .site-footer .footer-inner {
            flex-direction: column;
            /* เรียงลง */
            padding: 28px 16px;
        }

        .footer-right {
            flex-direction: column;
            /* ติดต่อเรา/เมนู เรียงแนวตั้ง */
            gap: 24px;
        }

        .footer-bottom {
            padding: 14px 16px 18px;
        }
    }
</style>

<footer class="site-footer">
    <div class="footer-inner">
        <div class="footer-brand">
            <img src="{{ asset('img/logo.png') }}" alt="Room Booking">
            <p class="tagline">ระบบจองห้องออนไลน์สำหรับนักศึกษาและบุคลากร</p>
        </div>

        <div class="footer-right">
            <div class="footer-col">
                <h4>ติดต่อเรา</h4>
                <ul>
                    <li>วิทยาลัยการคอมพิวเตอร์ มข.</li>
                    <li>123 ถ.มิตรภาพ ต.ในเมือง อ.เมือง จ.ขอนแก่น 40002</li>
                    <li>โทร: <a href="tel:043009700">043-009700</a></li>
                    <li>Email: <a href="mailto:computing.kkumail@kku.ac.th">computing.kkumail@kku.ac.th</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>เมนู</h4>
                <ul>
                    <li><a href="/about">เกี่ยวกับเรา</a></li>
                    <li><a href="/guide">วิธีใช้งาน</a></li>
                    {{-- <li><a href="/privacy">นโยบายความเป็นส่วนตัว</a></li> --}}
                </ul>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        © {{ now()->year }} Room Booking System · All rights reserved.
    </div>
</footer>
