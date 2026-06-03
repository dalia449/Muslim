<?php
session_start();
// قراءة اسم المستخدم من الجلسة بالـ PHP
$user_name = isset($_SESSION['user']) ? $_SESSION['user'] : "داليا عائض الغامدي";
$user_id = isset($_SESSION['id']) ? $_SESSION['id'] : "12345678910";
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>منصة مسلم | لوحة التحكم</title>
    <style>
        :root { --primary: #1b4d3e; --secondary: #c5a059; --bg: #f4f6f4; }
        * { box-sizing: border-box; font-family: 'Segoe UI', sans-serif; margin: 0; padding: 0; }
        body { background: var(--bg); color: #2d3748; padding: 20px; }
        .dash-container { max-width: 600px; margin: 50px auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border-right: 6px solid var(--secondary); }
        h2 { color: var(--primary); margin-bottom: 15px; }
        .info-box { background: var(--bg); padding: 15px; border-radius: 6px; margin-top: 15px; }
        .btn-out { background: #e53e3e; color: white; padding: 8px 15px; border: none; border-radius: 4px; cursor: pointer; margin-top: 20px; font-weight: bold; text-decoration: none; display: inline-block; }
    </style>
</head>
<body>

<div class="dash-container">
    <h2>💻 لوحة تحكم المستفيد النشطة</h2>
    <p>تم تسجيل الدخول بنجاح عبر نظام الـ PHP المعتمد للمنصة.</p>
    
    <div class="info-box">
        <p style="margin-bottom: 8px;">اسم الحاج/المعتمر: <strong style="color: var(--primary);"><?php echo $user_name; ?></strong></p>
        <p>رقم الهوية الوطنية: <strong><?php echo $user_id; ?></strong></p>
    </div>

    <div style="margin-top: 20px; background: #ebf8ff; padding: 12px; border-radius:6px; color: #2b6cb0; font-size: 14px;">
        ℹ️ بقية الأقسام (الفنادق، الحافلات الـ 5، الخرائط) قيد التطوير والربط البرمجي وفقاً للمخطط الهيكلي للمشروع.
    </div>

    <a href="logout.php" class="btn-out">تسجيل الخروج الآمن 🔒</a>
</div>

</body>
</html>
