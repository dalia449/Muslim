<?php
session_start();
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login_id = $_POST['login_id'];
    $login_pass = $_POST['login_pass'];

    // التحقق من بيانات داليا عائض الغامدي المعتمدة
    if ($login_id == "12345678910" && $login_pass == "123456") {
        $_SESSION['user'] = "داليا عائض الغامدي";
        $_SESSION['id'] = "12345678910";
        // التوجه للوحة التحكم بعد النجاح
        header("Location: ../dashboard.php");
        exit();
    } else {
        $message = "خطأ في رقم الهوية أو كلمة المرور!";
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>منصة مسلم | تسجيل الدخول</title>
    <style>
        :root { --primary: #1b4d3e; --secondary: #c5a059; --bg: #f4f6f4; }
        * { box-sizing: border-box; font-family: 'Segoe UI', sans-serif; margin: 0; padding: 0; }
        body { background: var(--bg); display: flex; justify-content: center; align-items: center; height: 100vh; }
        .login-card { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); width: 100%; max-width: 400px; border-top: 5px solid var(--primary); }
        h2 { color: var(--primary); margin-bottom: 10px; text-align: center; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; font-size: 14px; }
        input { width: 100%; padding: 10px; border: 1px solid #cbd5e0; border-radius: 6px; font-size: 14px; }
        .btn { background: var(--primary); color: white; border: none; padding: 10px; width: 100%; border-radius: 6px; cursor: pointer; font-weight: bold; font-size: 16px; margin-top: 10px; }
        .btn:hover { background: #13362c; }
        .alert { padding: 10px; background: #fed7d7; color: #9b2c2c; border-radius: 6px; margin-bottom: 15px; font-size: 13px; font-weight: bold; text-align: center; display: none; }
    </style>
</head>
<body>

<div class="login-card">
    <h2>🔐 تسجيل الدخول</h2>
    <p style="text-align: center; font-size: 12px; color: #718096; margin-bottom: 20px;">منصة مسلم - بوابة ضيوف الرحمن</p>
    
    <!-- مكان ظهور الخطأ -->
    <div id="error-box" class="alert"></div>

    <form id="loginForm" method="POST" action="login.php" onsubmit="validateLogin(event)">
        <div class="form-group">
            <label>رقم الهوية الوطنية:</label>
            <input type="text" id="login_id" name="login_id" placeholder="12345678910" required>
        </div>
        <div class="form-group">
            <label>كلمة المرور:</label>
            <input type="password" id="login_pass" name="login_pass" placeholder="******" required>
        </div>
        <button type="submit" class="btn">تسجيل الدخول</button>
    </form>
</div>

<script>
    // جافاسكريبت ذكي لتشغيل النموذج فوراً على جيت هاب إذا لم يتعرف المتصفح على الـ PHP
    function validateLogin(e) {
        const id = document.getElementById('login_id').value.trim();
        const pass = document.getElementById('login_pass').value.trim();
        const errorBox = document.getElementById('error-box');

        // إذا تطابقت بياناتكِ المعتمدة
        if (id === "12345678910" && pass === "123456") {
            errorBox.style.display = "none";
            alert("🎉 تم التحقق بنجاح! أهلاً بكِ يا داليا عائض الغامدي.");
            // التوجه إلى صفحة لوحة التحكم المعتمدة بنجاح
            window.location.href = "../dashboard.php";
            e.preventDefault(); 
        } else {
            e.preventDefault(); 
            errorBox.innerText = "❌ رقم الهوية أو كلمة المرور غير صحيحة!";
            errorBox.style.display = "block";
        }
    }
</script>

</body>
</html>
