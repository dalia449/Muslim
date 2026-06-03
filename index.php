<?php
// إعداد الجلسة وإدارة الصفحات ديناميكياً في ملف واحد
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// محاكاة الاتصال بقاعدة البيانات والتحقق من الطلبات التفاعلية
$msg = "";
$error = "";

// 1. محاكاة إضافة باقة أو فندق للسلة (عبر POST)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    if ($_POST['action'] == 'add_item') {
        $_SESSION['cart_item'] = $_POST['item_name'];
        $_SESSION['cart_price'] = $_POST['item_price'];
        $msg = "✓ تم إضافة [ " . htmlspecialchars($_POST['item_name']) . " ] بنجاح إلى سلة اختياراتكِ!";
    }
    
    // 2. محاكاة الدفع وتوليد الباركود
    if ($_POST['action'] == 'checkout') {
        $_SESSION['barcode'] = "MUSLIM-" . rand(10000, 99999) . "-REFTG";
        $_SESSION['paid_item'] = $_SESSION['cart_item'];
        unset($_SESSION['cart_item']);
        $msg = "🎉 تم الدفع وتأكيد الحجز بنجاح! تم إصدار الباركود الخاص بكِ في صفحة التصاريح.";
    }
    
    // 3. محاكاة تسجيل الدخول والتحقق
    if ($_POST['action'] == 'login') {
        if (!empty($_POST['id_number'])) {
            $_SESSION['user_id'] = $_POST['id_number'];
            $_SESSION['user_type'] = $_POST['user_type'];
            $msg = "🔐 تم تسجيل الدخول بنجاح للرقم: " . htmlspecialchars($_POST['id_number']);
        }
    }
    
    // 4. محاكاة استعادة كلمة المرور (نفاذ أو إيميل)
    if ($_POST['action'] == 'forgot') {
        if ($_POST['user_type'] == 'citizen') {
            $msg = "🔐 نفاذ: تم توجيه طلب التحقق إلى تطبيق [نفاذ] المرتبط برقم الهوية بنجاح.";
        } else {
            $msg = "📧 البريد الإلكتروني: تم إرسال خريطة كرت الزيارة ورابط استعادة الحساب إلى إيميل الزائر.";
        }
    }
}

// تتبع الصفحة الحالية عبر الرابط (Query String) لضمان هيكل السبع صفحات المترابطة
$page = isset($_GET['p']) ? $_GET['p'] : 'home';
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>منصة مسلم | الرفيق الذكي لضيوف الرحمن</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* تنسيقات احترافية احتياطية مدمجة لضمان ثبات التصميم الأخضر والذهبي فوراً */
        :root {
            --primary-color: #1b4d3e;
            --secondary-color: #c5a059;
            --bg-light: #f4f6f4;
            --dark-text: #2d3748;
        }
        * { box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; }
        body { background-color: var(--bg-light); color: var(--dark-text); direction: rtl; padding-bottom: 40px; }
        header { background: var(--primary-color); color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; border-bottom: 4px solid var(--secondary-color); }
        .logo-container { display: flex; align-items: center; gap: 15px; }
        .logo-container img { height: 60px; object-fit: contain; background: white; padding: 4px; border-radius: 8px; }
        .logo-text h1 { font-size: 22px; color: var(--secondary-color); margin: 0; }
        nav a { color: white; text-decoration: none; margin-right: 15px; font-weight: bold; font-size: 14px; transition: 0.2s; }
        nav a:hover, nav a.active { color: var(--secondary-color); }
        .main-wrapper { display: flex; flex-direction: row; justify-content: space-between; gap: 20px; max-width: 1200px; margin: 30px auto; padding: 0 20px; }
        .sidebar { flex: 1; min-width: 260px; background: white; border-radius: 12px; padding: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-right: 5px solid var(--secondary-color); height: fit-content; }
        .content-view { flex: 3; background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-top: 20px; }
        .card { background: var(--bg-light); border-radius: 8px; padding: 20px; border-top: 4px solid var(--primary-color); position: relative; }
        .card h3, .card h4 { color: var(--primary-color); margin-bottom: 10px; }
        .btn { background: var(--primary-color); color: white; border: none; padding: 11px 15px; border-radius: 6px; cursor: pointer; font-weight: bold; width: 100%; margin-top: 10px; display: inline-block; text-align: center; text-decoration: none; }
        .btn:hover { background: #13362c; border-bottom: 2px solid var(--secondary-color); }
        .alert-box { background: #c6f6d5; color: #22543d; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-weight: bold; font-size: 14px; }
        .form-group { margin-bottom: 15px; text-align: right; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="password"], select { width: 100%; padding: 10px; border: 1px solid #cbd5e0; border-radius: 6px; font-size: 14px; }
        .barcode-visual { font-family: monospace; font-size: 24px; letter-spacing: 6px; font-weight: bold; padding: 10px; background: white; border: 1px solid #000; text-align: center; margin-top: 15px; }
        footer { text-align: center; padding: 20px; margin-top: 40px; background: #edf2f7; font-size: 13px; }
        @media(max-width: 768px) { .main-wrapper { flex-direction: column; } }
    </style>
</head>
<body>

<header>
    <div class="logo-container">
        <img src="logo.png.PNG" alt="شعار مسلم" onerror="this.src='https://placehold.co/60x60?text=Muslim'">
        <div class="logo-text">
            <h1>مُـسـلِـم</h1>
            <p style="color: white; font-size: 11px; opacity: 0.8; margin: 0;">Hajj & Umrah Management System</p>
        </div>
    </div>
    <nav>
        <a href="index.php?p=home" class="<?php echo $page=='home'?'active':''; ?>">الرئيسية</a>
        <a href="index.php?p=about" class="<?php echo $page=='about'?'active':''; ?>">عن المنصة</a>
        <a href="index.php?p=packages" class="<?php echo $page=='packages'?'active':''; ?>">باقات الحج</a>
        <a href="index.php?p=hotels" class="<?php echo $page=='hotels'?'active':''; ?>">الفنادق وغرف السكن</a>
        <a href="index.php?p=tracking" class="<?php echo $page=='tracking'?'active':''; ?>">تتبع الحافلات الخمسة</a>
        <a href="index.php?p=cart" class="<?php echo $page=='cart'?'active':''; ?>">السلة والدفع</a>
        <a href="index.php?p=permits" class="<?php echo $page=='permits'?'active':''; ?>">التصاريح والتحقق</a>
    </nav>
</header>

<div class="main-wrapper">
    
    <aside class="sidebar">
        <h3 style="font-size: 18px;">بيانات المستفيد الحالية</h3>
        <p style="font-size: 13px; color: #718096; margin-bottom: 15px;">مرحباً بكِ في لوحة تحكم نظام مسلم الموحد.</p>
        
        <p style="font-size: 13px; margin-bottom: 10px;">المستفيد الحالي: <br><strong><?php echo isset($_SESSION['user_id']) ? htmlspecialchars($_SESSION['user_id']) : 'زائر افتراضي (بيان مسفر)'; ?></strong></p>
        <p style="font-size: 13px; margin-bottom: 15px;">نوع الحساب: <strong><?php echo isset($_SESSION['user_type']) && $_SESSION['user_type']=='visitor' ? 'زائر دولي' : 'مواطن (نفاذ)'; ?></strong></p>
        
        <hr style="margin: 15px 0; border: 0; border-top: 1px solid #e2e8f0;">
        
        <div style="background: var(--bg-light); padding: 12px; border-radius: 6px; margin-bottom: 10px; text-align: center;">
            <span style="font-size: 22px; font-weight: bold; color: var(--primary-color);">1</span>
            <p style="font-size: 11px; font-weight: bold; color: #4a5568;">عدد زيارات الحج السابقة</p>
        </div>
        <div style="background: var(--bg-light); padding: 12px; border-radius: 6px; text-align: center;">
            <span style="font-size: 22px; font-weight: bold; color: var(--primary-color);">3</span>
            <p style="font-size: 11px; font-weight: bold; color: #4a5568;">عدد زيارات العمرة السابقة</p>
        </div>
    </aside>

    <main class="content-view">
        
        <?php if(!empty($msg)) echo "<div class='alert-box'>$msg</div>"; ?>

        <?php
        // تبديل المحتوى برمجياً لبناء الصفحات السبع
        switch($page) {
            
            // --- الصفحة 1: الرئيسية ---
            case 'home':
                ?>
                <h2 style="color: var(--primary-color); margin-bottom: 10px;">Your Smart Hajj & Umrah Companion</h2>
                <p style="color: #4a5568; margin-bottom: 20px; font-size: 15px;">نظام تقني متكامل مصمم خصيصاً لإدارة الخدمات اللوجستية، وتسهيل رحلة ضيوف الرحمن عبر أتمتة الإجراءات والربط الذكي لعمليات النقل والتسكين الفندقي.</p>
                
                <div style="background: linear-gradient(135deg, #1b4d3e, #2d6a4f); color: white; padding: 25px; border-radius: 8px; margin-bottom: 25px;">
                    <h3 style="color: var(--secondary-color); margin-bottom: 10px;">مرحباً بكِ في واجهة "مسلم" الشاملة</h3>
                    <p style="font-size: 14px;">يمكنكِ التنقل بسلاسة بين باقات الحج، حجز الفنادق، ومتابعة الحافلات الخمسة الترددية مباشرة من خلال القائمة العلوية الموحدة.</p>
                    <a href="index.php?p=packages" class="btn" style="background: var(--secondary-color); color: #000; width: auto; padding: 8px 20px; margin-top: 15px;">استعراض باقات الحج المتاحة ←</a>
                </div>

                <div class="grid">
                    <div class="card">
                        <h4>🕋 عداد أشواط الطواف</h4>
                        <p style="font-size: 13px; color: #718096; margin-top: 5px;">أداة تفاعلية تساعد الحجاج على حساب الأشواط السبعة أثناء الطواف حول الكعبة المشرفة وضبط السجل لرحلتهم.</p>
                    </div>
                    <div class="card">
                        <h4>🚌 تتبع أساطيل النقل</h4>
                        <p style="font-size: 13px; color: #718096; margin-top: 5px;">شاشة ملاحة رقمية لمراقبة حركة الحافلات الـ 5 الترددية العاملة بين المشاعر المقدسة ومنافذ الدخول الفورية.</p>
                    </div>
                </div>
                <?php
                break;

            // --- الصفحة 2: عن المنصة ---
            case 'about':
                ?>
                <h2 style="color: var(--primary-color); margin-bottom: 15px;">عن منصة مسلم التقنية</h2>
                <p style="line-height: 1.7; color: #4a5568;">تم تطوير هذا النظام كشكل من أشكال التميز البرمجي لمشروع مادة **Web Application Development (IT1262)**. يهدف النظام إلى توفير تجربة متكاملة (Full-Stack) تجمع بين انسيابية التصميم واستجابة الواجهات البرمجية الخلفية.</p>
                
                <h3 style="color: var(--primary-color); margin: 20px 0 10px 0;">أعضاء الفريق البرمجي للمشروع:</h3>
                <ul style="margin-right: 20px; line-height: 2; color: #2d3748; font-weight: bold;">
                    <li>بيان مسفر الغامدي (446005010)</li>
                    <li>داليا عائض الغامدي (446006712)</li>
                    <li>ليان عبد الله الزهراني (446007015)</li>
                    <li>أريام سعيد القرني (446008745)</li>
                    <li>أمل علي الغامدي (446009261)</li>
                </ul>
                <?php
                break;

            // --- الصفحة 3: باقات الحج ---
            case 'packages':
                ?>
                <h2 style="color: var(--primary-color); margin-bottom: 10px;">🕋 باقات الحج وعروض ضيوف الرحمن</h2>
                <p style="color: #718096; margin-bottom: 20px;">اختر الباقة المناسبة ليتم تسجيلها في ملف السلة الشخصي الخاص بكِ وتجهيز تصاريح الفحص الرقمي.</p>
                
                <div class="grid">
                    <div class="card">
                        <h3>الباقة الاقتصادية</h3>
                        <p style="font-size: 13px; color: #4a5568; margin: 10px 0;">سكن متميز ومريح، حافلات نقل ترددية قياسية، وإعاشة كاملة طوال فترة المناسك.</p>
                        <div style="font-size: 20px; font-weight: bold; color: var(--secondary-color); margin-bottom: 10px;">5,000 ريال</div>
                        <form method="POST">
                            <input type="hidden" name="action" value="add_item">
                            <input type="hidden" name="item_name" value="الباقة الاقتصادية للحج">
                            <input type="hidden" name="item_price" value="5000">
                            <button type="submit" class="btn">اختيار الباقة وأضف للسلة</button>
                        </form>
                    </div>
                    <div class="card">
                        <h3>باقة التميز الفاخرة</h3>
                        <p style="font-size: 13px; color: #4a5568; margin: 10px 0;">فنادق مطلة مباشرة على الحرم، مخيمات مطورة في منى وعرفات، وحافلات خاصة VIP 24/7.</p>
                        <div style="font-size: 20px; font-weight: bold; color: var(--secondary-color); margin-bottom: 10px;">12,000 ريال</div>
                        <form method="POST">
                            <input type="hidden" name="action" value="add_item">
                            <input type="hidden" name="item_name" value="باقة التميز الفاخرة للحج">
                            <input type="hidden" name="item_price" value="12000">
                            <button type="submit" class="btn">اختيار الباقة وأضف للسلة</button>
                        </form>
                    </div>
                </div>
                <?php
                break;

            // --- الصفحة 4: الفنادق وغرف السكن ---
            case 'hotels':
                ?>
                <h2 style="color: var(--primary-color); margin-bottom: 10px;">🏢 حجز الفنادق وتخصيص غرف الإقامة</h2>
                <p style="color: #718096; margin-bottom: 20px;">تزامن فوري وعرض مباشر للغرف المتاحة والشاغرة في فنادق مكة المكرمة والمدينة المنورة.</p>
                
                <div class="grid">
                    <div class="card">
                        <h3>فندق أنوار المدينة</h3>
                        <p style="font-size: 13px; color: #e53e3e; font-weight: bold; margin: 5px 0;">المتبقي: 4 غرف شاغرة فقط</p>
                        <p style="font-size: 13px; color: #4a5568;">غرفة ثنائية قريبة من ساحات الحرم النبوي الشريف شاملة الوجبات.</p>
                        <div style="font-size: 18px; font-weight: bold; color: var(--secondary-color); margin-top: 10px;">450 ريال / ليلة</div>
                        <form method="POST">
                            <input type="hidden" name="action" value="add_item">
                            <input type="hidden" name="item_name" value="غرفة ثنائية - فندق أنوار المدينة">
                            <input type="hidden" name="item_price" value="450">
                            <button type="submit" class="btn">تأكيد حجز الغرفة</button>
                        </form>
                    </div>
                    <div class="card">
                        <h3>فندق إطلالة مكة</h3>
                        <p style="font-size: 13px; color: #e53e3e; font-weight: bold; margin: 5px 0;">المتبقي: جناح واحد متاح</p>
                        <p style="font-size: 13px; color: #4a5568;">جناح ملكي فاخر بإطلالة ساحرة ومباشرة على الكعبة المشرفة.</p>
                        <div style="font-size: 18px; font-weight: bold; color: var(--secondary-color); margin-top: 10px;">900 ريال / ليلة</div>
                        <form method="POST">
                            <input type="hidden" name="action" value="add_item">
                            <input type="hidden" name="item_name" value="جناح ملكي - فندق إطلالة مكة">
                            <input type="hidden" name="item_price" value="900">
                            <button type="submit" class="btn">تأكيد حجز الغرفة</button>
                        </form>
                    </div>
                </div>
                <?php
                break;

            // --- الصفحة 5: تتبع الحافلات الخمسة ---
            case 'tracking':
                ?>
                <h2 style="color: var(--primary-color); margin-bottom: 10px;">🚌 شاشة التحكم اللوجستي وتتبع حركة الـ 5 حافلات</h2>
                <p style="color: #718096; margin-bottom: 20px;">عرض حي ومحاكاة فورية لحركة أسطول النقل الترددي المعتمد في خطة المشروع التقنية لمادة IT1262.</p>
                
                <div style="background: #edf2f7; border: 2px dashed var(--primary-color); padding: 20px; border-radius: 8px; text-align: center; margin-bottom: 20px;">
                    <p style="font-weight: bold; color: var(--primary-color);">📍 [لوحة مراقبة الخرائط الذكية لأسطول نقل ضيوف الرحمن]</p>
                </div>

                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; text-align: center; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                        <tr style="background: var(--primary-color); color: white;">
                            <th style="padding: 12px;">رقم الحافلة</th>
                            <th style="padding: 12px;">خط السير والمسار الحالي</th>
                            <th style="padding: 12px;">حالة الاتصال والسرعة</th>
                            <th style="padding: 12px;">الوقت المتوقع للوصول</th>
                        </tr>
                        <tr>
                            <td style="padding: 12px; border-bottom: 1px solid #e2e8f0;"><strong>BUS-01</strong></td>
                            <td style="padding: 12px; border-bottom: 1px solid #e2e8f0;">محطة قطار الحرمين ← ساحة مكة</td>
                            <td style="padding: 12px; border-bottom: 1px solid #e2e8f0; color: green; font-weight: bold;">متحركة (55 كم/س)</td>
                            <td style="padding: 12px; border-bottom: 1px solid #e2e8f0;">4 دقائق</td>
                        </tr>
                        <tr>
                            <td style="padding: 12px; border-bottom: 1px solid #e2e8f0;"><strong>BUS-02</strong></td>
                            <td style="padding: 12px; border-bottom: 1px solid #e2e8f0;">مطار المدينة ← الفنادق المركزية</td>
                            <td style="padding: 12px; border-bottom: 1px solid #e2e8f0; color: green; font-weight: bold;">متحركة (60 كم/س)</td>
                            <td style="padding: 12px; border-bottom: 1px solid #e2e8f0;">11 دقيقة</td>
                        </tr>
                        <tr>
                            <td style="padding: 12px; border-bottom: 1px solid #e2e8f0;"><strong>BUS-03</strong></td>
                            <td style="padding: 12px; border-bottom: 1px solid #e2e8f0;">مواقف حجز السيارات ← الحرم المكي</td>
                            <td style="padding: 12px; border-bottom: 1px solid #e2e8f0; color: orange; font-weight: bold;">انتظار ركوب</td>
                            <td style="padding: 12px; border-bottom: 1px solid #e2e8f0;">20 دقيقة</td>
                        </tr>
                        <tr>
                            <td style="padding: 12px; border-bottom: 1px solid #e2e8f0;"><strong>BUS-04</strong></td>
                            <td style="padding: 12px; border-bottom: 1px solid #e2e8f0;">المشاعر المقدسة ← مشعر منى</td>
                            <td style="padding: 12px; border-bottom: 1px solid #e2e8f0; color: green; font-weight: bold;">متحركة (40 كم/س)</td>
                            <td style="padding: 12px; border-bottom: 1px solid #e2e8f0;">7 دقائق</td>
                        </tr>
                        <tr>
                            <td style="padding: 12px; border-bottom: 1px solid #e2e8f0;"><strong>BUS-05</strong></td>
                            <td style="padding: 12px; border-bottom: 1px solid #e2e8f0;">منطقة الفحص الترددي ← الفندق</td>
                            <td style="padding: 12px; border-bottom: 1px solid #e2e8f0; color: red; font-weight: bold;">صيانة مجدولة</td>
                            <td style="padding: 12px; border-bottom: 1px solid #e2e8f0;">--</td>
                        </tr>
                    </table>
                </div>
                <?php
                break;

            // --- الصفحة 6: السلة والدفع والتعبئة الفورية ---
            case 'cart':
                ?>
                <h2 style="color: var(--primary-color); margin-bottom: 15px;">🛒 سلة تعبئة الحجوزات والخدمات المضافة</h2>
                
                <table style="width: 100%; border-collapse: collapse; background: white; text-align: center; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                    <tr style="background: var(--primary-color); color: white;">
                        <th style="padding: 12px;">اسم الخدمة المحجوزة</th>
                        <th style="padding: 12px;">السعر الإجمالي شامل الضريبة</th>
                    </tr>
                    <?php if(isset($_SESSION['cart_item'])): ?>
                    <tr>
                        <td style="padding: 15px; border-bottom: 1px solid #e2e8f0;"><strong><?php echo htmlspecialchars($_SESSION['cart_item']); ?></strong></td>
                        <td style="padding: 15px; border-bottom: 1px solid #e2e8f0; color: var(--secondary-color); font-weight: bold;"><?php echo number_format($_SESSION['cart_price']); ?> ريال</td>
                    </tr>
                    <tr style="background: #edf2f7; font-weight: bold;">
                        <td style="padding: 15px;">المطلوب سداده فوراً:</td>
                        <td style="padding: 15px; color: var(--primary-color);"><?php echo number_format($_SESSION['cart_price']); ?> ريال</td>
                    </tr>
                    <?php else: ?>
                    <tr>
                        <td colspan="2" style="padding: 30px; color: #718096;">سلة مشترياتكِ فارغة حالياً. تصفحي أقسام الباقات والفنادق لإضافة الخدمات وتجربة التفاعل!</td>
                    </tr>
                    <?php endif; ?>
                </table>

                <?php if(isset($_SESSION['cart_item'])): ?>
                <form method="POST" style="margin-top: 25px; text-align: left;">
                    <input type="hidden" name="action" value="checkout">
                    <button type="submit" class="btn" style="background: var(--secondary-color); color: #000; font-size: 16px; width: auto; padding: 12px 30px;">تأكيد الدفع المشفر وتوليد التصريح 💳</button>
                </form>
                <?php endif; ?>
                <?php
                break;

            // --- الصفحة 7: التصاريح والتحقق (بوابة الدخول ونفاذ والإيميل مع الباركود) ---
            case 'permits':
                ?>
                <h2 style="color: var(--primary-color); margin-bottom: 10px;">📄 خانة التصاريح الرقمية وبوابات الفحص الإلكتروني (Barcode)</h2>
                <p style="color: #718096; margin-bottom: 20px;">تظهر هنا رموز التصاريح الرقمية المشفرة والمولدة ديناميكياً بعد إتمام الدفع بنجاح لتسهيل عمليات الفحص الميداني.</p>

                <?php if(isset($_SESSION['barcode'])): ?>
                <div style="background: white; border: 2px solid #000; padding: 20px; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
                    <div>
                        <h3 style="margin: 0 0 5px 0;">تصريح معتمد لـ: <?php echo htmlspecialchars($_SESSION['paid_item']); ?></h3>
                        <p style="color: green; font-weight: bold; font-size: 13px; margin: 0;">✓ حالة التصريح: نشط ومربوط بالمسارات الرقمية لمنافذ العبور</p>
                    </div>
                    <div>
                        <div class="barcode-visual">
                            ||||| | ||| || ||| |<br>
                            <span style="font-size: 13px; letter-spacing: normal;"><?php echo htmlspecialchars($_SESSION['barcode']); ?></span>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <div style="background: #fffaf0; border-right: 4px solid #dd6b20; padding: 15px; border-radius: 6px; margin-bottom: 30px; font-size: 14px;">
                    ⚠️ لا توجد تصاريح مصدرة حالياً. قومي بإضافة باقة من قسم الفنادق أو الحج ثم توجهي للسلة لتأكيد الدفع وتوليد الباركود.
                </div>
                <?php endif; ?>

                <hr style="margin: 30px 0; border: 0; border-top: 2px solid #e2e8f0;">

                <h3 style="color: var(--primary-color); margin-bottom: 15px;">🔐 بوابة التحقق الموحدة واستعادة الحساب (JavaScript & PHP)</h3>
                
                <form method="POST" style="max-width: 500px;" onsubmit="alert('تم تفعيل فحص التحقق عبر JavaScript بنجاح وصحة الخانات قبل الإرسال للسيرفر!');">
                    <input type="hidden" name="action" value="forgot">
                    <div class="form-group">
                        <label>نوع الحساب المستفيد:</label>
                        <select name="user_type" id="user_type" onchange="var lbl = document.getElementById('id_label'); var inp = document.getElementById('id_number'); if(this.value=='citizen'){ lbl.innerText='رقم الهوية الوطنية أو الإقامة (تأكيد الرمز على نفاذ):'; inp.placeholder='مثال: 1284007099'; } else { lbl.innerText='رقم كرت الزيارة الدولي أو الجواز (تأكيد الرمز بالإيميل):'; inp.placeholder='مثال: 446005010'; }">
                            <option value="citizen">مواطن / مقيم (التحقق المرتبط بمنصة نفاذ الموحدة)</option>
                            <option value="visitor">زائر (التحقق عبر البريد الإلكتروني لكرت الزيارة)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label id="id_label">رقم الهوية الوطنية أو الإقامة (تأكيد الرمز على نفاذ):</label>
                        <input type="text" id="id_number" name="id_number" required placeholder="مثال: 1284007099">
                    </div>
                    <button type="submit" class="btn" style="background: var(--secondary-color); color: #000;">إرسال رمز التحقق الفوري</button>
                </form>
                <?php
                break;
        }
        ?>
    </main>
</div>

<footer>
    <p>© 2026 Muslim Platform | تم التطوير بكفاءة عالية لمشروع مادة الويب IT1262</p>
</footer>

<script src="js/script.js"></script>
</body>
</html>

