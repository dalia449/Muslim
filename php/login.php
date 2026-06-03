<?php
// تفعيل الجلسات في حال تشغيل الملف على خادم محلي XAMPP
if (session_status() == PHP_SESSION_NONE) {
    @session_start();
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>منصة مسلم | إدارة خدمات ضيوف الرحمن</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* تنسيقات هيكلية تمنع تداخل العناصر وتوزع التخطيط (25% جانب مخصص و 75% محتوى) */
        :root {
            --primary-color: #1b4d3e;
            --secondary-color: #c5a059;
            --bg-light: #f4f6f4;
            --dark-text: #2d3748;
        }
        * { box-sizing: border-box; font-family: 'Segoe UI', Tahoma, sans-serif; margin: 0; padding: 0; }
        body { background-color: var(--bg-light); color: var(--dark-text); direction: rtl; }
        
        header { 
            background: var(--primary-color); 
            color: white; 
            padding: 15px 30px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            border-bottom: 4px solid var(--secondary-color); 
        }
        .logo-container { display: flex; align-items: center; gap: 15px; }
        .logo-container img { height: 60px; background: white; padding: 4px; border-radius: 8px; }
        
        nav a { color: white; text-decoration: none; margin-right: 15px; font-weight: bold; font-size: 14px; cursor: pointer; padding: 5px 10px; border-radius: 4px; }
        nav a:hover, nav a.active { color: var(--secondary-color); background: rgba(255,255,255,0.1); }
        
        .main-wrapper { display: flex; flex-direction: row; justify-content: space-between; gap: 20px; max-width: 1200px; margin: 30px auto; padding: 0 20px; }
        .sidebar { flex: 1; min-width: 280px; background: white; border-radius: 12px; padding: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-right: 5px solid var(--secondary-color); height: fit-content; }
        .content-view { flex: 3; background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        
        /* شاشات المحتوى يتم التحكم بظهورها برمجياً */
        .page-section { display: none; }
        .page-section.active { display: block; }
        
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-top: 20px; }
        .card { background: var(--bg-light); border-radius: 8px; padding: 20px; border-top: 4px solid var(--primary-color); }
        
        .btn { background: var(--primary-color); color: white; border: none; padding: 11px 15px; border-radius: 6px; cursor: pointer; font-weight: bold; width: 100%; margin-top: 10px; text-align: center; }
        .btn:hover { background: #13362c; }
        
        .form-group { margin-bottom: 15px; text-align: right; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="password"], select { width: 100%; padding: 10px; border: 1px solid #cbd5e0; border-radius: 6px; }
        
        .badge { background: #e2e8f0; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; display: inline-block; margin-top: 5px; }
        .success-banner { background: #c6f6d5; color: #22543d; padding: 12px; border-radius: 6px; margin-bottom: 20px; display: none; font-weight: bold; }
        
        footer { text-align: center; padding: 20px; margin-top: 40px; background: #edf2f7; font-size: 13px; }
    </style>
</head>
<body>

<header>
    <div class="logo-container">
        <img src="logo.png.PNG" alt="شعار مسلم" onerror="this.src='https://placehold.co/60x60?text=Muslim'">
        <div>
            <h1 style="color: var(--secondary-color); font-size: 22px;">مُـسـلِـم</h1>
            <p style="color: white; font-size: 11px; margin: 0;">نظام إدارة ضيوف الرحمن</p>
        </div>
    </div>
    <nav>
        <a onclick="switchPage('home')" id="nav-home" class="active">الرئيسية</a>
        <a onclick="switchPage('about')" id="nav-about">عن المنصة</a>
        <a onclick="switchPage('hotels')" id="nav-hotels">الفنادق والسكن</a>
        <a onclick="switchPage('transport')" id="nav-transport">الحافلات الـ 5</a>
        <a onclick="switchPage('services')" id="nav-services">الخدمات والعداد</a>
        <a onclick="switchPage('cart')" id="nav-cart">السلة والدفع</a>
        <a onclick="switchPage('login')" id="nav-login">تسجيل الدخول</a>
    </nav>
</header>

<div class="main-wrapper">
    
    <aside class="sidebar">
        <h3 style="color: var(--primary-color); font-size: 18px; margin-bottom: 10px;">بيانات الحساب الحالي</h3>
        <div style="background: var(--bg-light); padding: 12px; border-radius: 8px; margin-bottom: 15px;">
            <p style="font-size: 14px;">الاسم: <strong id="side-user-name">زائر افتراضي</strong></p>
            <p style="font-size: 13px; color: #4a5568;">الهوية: <span id="side-user-id">-----------</span></p>
            <span class="badge" id="side-user-status" style="background: #e53e3e; color: white;">لم يتم تسجيل الدخول</span>
        </div>
        
        <hr style="margin: 15px 0; border: 0; border-top: 1px solid #cbd5e0;">
        <h4 style="font-size: 14px; margin-bottom: 10px;">ملخص اختياراتكِ الحالية:</h4>
        <p style="font-size: 13px;">🏨 الفندق: <strong id="side-chosen-hotel" style="color: var(--primary-color);">لم يحدد</strong></p>
        <p style="font-size: 13px;">🚌 الحافلة المخصصة: <strong id="side-chosen-bus" style="color: var(--primary-color);">لم تحدد</strong></p>
        <p style="font-size: 13px; margin-bottom: 10px;">🕋 شوط الطواف الحالي: <strong id="side-tawaf-lap" style="color: var(--secondary-color);">0 / 7</strong></p>
        
        <div style="background: #edf2f7; padding: 10px; border-radius: 6px; text-align: center; font-size: 12px;">
            <span>عدد زيارات الحج السابقة: <strong>1</strong></span><br>
            <span>عدد زيارات العمرة السابقة: <strong>3</strong></span>
        </div>
    </aside>

    <main class="content-view">
        <div id="action-banner" class="success-banner"></div>

        <section id="page-home" class="page-section active">
            <h2 style="color: var(--primary-color); margin-bottom: 10px;">Your Smart Hajj & Umrah Companion</h2>
            <p style="color: #4a5568; margin-bottom: 20px;">مرحباً بكِ في منصة مسلم الموحدة. نسهل لكِ حجز باقات السكن الفندقي، وتتبع مسارات الحافلات الترددية الخمسة وإدارة مناسك العبادة برقمية كاملة.</p>
            <div style="background: linear-gradient(135deg, #1b4d3e, #2d6a4f); color: white; padding: 20px; border-radius: 8px;">
                <h3 style="color: var(--secondary-color); margin-bottom: 8px;">خطوات الرحلة السريعة:</h3>
                <p style="font-size: 14px;">1. توجهي لصفحة تسجيل الدخول لتفعيل حسابك الشخصي.<br>2. اختاري الفندق المناسب والحافلة الترددية لتحديث بياناتك تلقائياً.</p>
                <button class="btn" style="background: var(--secondary-color); color: #000; width: auto; padding: 8px 20px; margin-top: 10px;" onclick="switchPage('login')">الانتقال لتسجيل الدخول ←</button>
            </div>
        </section>

        <section id="page-about" class="page-section">
            <h2 style="color: var(--primary-color); margin-bottom: 15px;">عن مشروع منصة مسلم</h2>
            <p style="line-height: 1.6; color: #4a5568; margin-bottom: 15px;">نظام متكامل متوافق مع متطلبات مشروع مادة تطوير تطبيقات الويب (IT1262).</p>
            <h4 style="margin-bottom: 10px; color: var(--primary-color);">فريق العمل البرمجي:</h4>
            <ul style="margin-right: 20px; line-height: 2; font-weight: bold; color: #2d3748;">
                <li>داليا عائض الغامدي (446006712)</li>
                <li>بيان مسفر الغامدي (446005010)</li>
                <li>ليان عبد الله الزهراني (446007015)</li>
                <li>أريام سعيد القرني (446008745)</li>
                <li>أمل علي الغامدي (446009261)</li>
            </ul>
        </section>

        <section id="page-hotels" class="page-section">
            <h2 style="color: var(--primary-color);">🏨 قائمة الفنادق وغرف التسكين</h2>
            <p style="color: #718096; margin-bottom: 15px;">انقري على الفندق لتخصيصه وتحديث لوحة التحكم الجانبية فوراً.</p>
            <div class="grid">
                <div class="card">
                    <h4>فندق أنوار المدينة (المركزية)</h4>
                    <p style="font-size: 13px; color: #4a5568;">غرف ثنائية فاخرة بجوار ساحات المسجد النبوي الشريف.</p>
                    <button class="btn" onclick="selectHotel('فندق أنوار المدينة')">حجز وتخصيص الفندق</button>
                </div>
                <div class="card">
                    <h4>فندق إطلالة مكة (برج الساعة)</h4>
                    <p style="font-size: 13px; color: #4a5568;">أجنحة ملكية عائلية بإطلالة ومسار مباشر إلى الحرم المكي.</p>
                    <button class="btn" onclick="selectHotel('فندق إطلالة مكة')">حجز وتخصيص الفندق</button>
                </div>
            </div>
        </section>

        <section id="page-transport" class="page-section">
            <h2 style="color: var(--primary-color);">🚌 إدارة حافلات النقل الترددية الخمسة</h2>
            <p style="color: #718096; margin-bottom: 15px;">اختاري رقم الحافلة لربط خط سيرها برحلتكِ اللوجستية وتحديث بيانات الملف:</p>
            <div class="grid">
                <div class="card">
                    <h4>🚌 حافلة المسار الأول (BUS-01)</h4>
                    <p style="font-size: 13px;">المسار: مواقف كدي ← ساحات الحرم المكي</p>
                    <button class="btn" onclick="selectBus('الحافلة 1 (كدي)')">ركوب الحافلة</button>
                </div>
                <div class="card">
                    <h4>🚌 حافلة المسار الثاني (BUS-02)</h4>
                    <p style="font-size: 13px;">المسار: مطار المدينة ← المنطقة المركزية</p>
                    <button class="btn" onclick="selectBus('الحافلة 2 (المدينة)')">ركوب الحافلة</button>
                </div>
                <div class="card">
                    <h4>🚌 حافلة المسار الثالث (BUS-03)</h4>
                    <p style="font-size: 13px;">المسار: مشعر منى ← مشعر عرفات</p>
                    <button class="btn" onclick="selectBus('الحافلة 3 (المشاعر)')">ركوب الحافلة</button>
                </div>
            </div>
        </section>

        <section id="page-services" class="page-section">
            <h2 style="color: var(--primary-color);">🕋 مساعد المناك التفاعلي (عداد أشواط الطواف)</h2>
            <p style="color: #718096; margin-bottom: 20px;">اضغطي على الزر لحساب وتسجيل الشوط الحالي لمنع النسيان أثناء الطواف.</p>
            <div class="card" style="text-align: center; max-width: 400px; margin: 0 auto;">
                <h3 style="font-size: 32px; color: var(--secondary-color);" id="tawaf-counter-display">0</h3>
                <p style="margin-bottom: 15px; font-weight: bold;">الشوط الحالي</p>
                <button class="btn" onclick="incrementTawaf()">تسجيل شوط طواف جديد +1</button>
                <button class="btn" style="background: #e53e3e; margin-top: 5px;" onclick="resetTawaf()">إعادة تعيين العداد</button>
            </div>
        </section>

        <section id="page-cart" class="page-section">
            <h2 style="color: var(--primary-color);">🛒 مراجعة تفاصيل الباقة وإصدار التصريح</h2>
            <div class="card" style="margin-top: 15px;">
                <h4>تفاصيل حيازتكِ الحالية:</h4>
                <p style="margin: 10px 0;">السكن الفندقي المختار: <strong id="cart-hotel">لم يحدد بعد</strong></p>
                <p style="margin: 10px 0;">وسيلة النقل المخصصة: <strong id="cart-bus">لم تحدد بعد</strong></p>
                <hr style="margin: 15px 0; border: 0; border-top: 1px solid #cbd5e0;">
                <button class="btn" style="background: var(--secondary-color); color: black;" onclick="confirmCheckout()">تأكيد الحجز الفوري وإصدار الباركود (QR) 💳</button>
            </div>
            
            <div id="barcode-area" class="card" style="margin-top: 20px; display: none; text-align: center;">
                <h4 style="color: green;">✓ تم إصدار التصريح الرقمي بنجاح</h4>
                <div style="font-family: monospace; font-size: 26px; letter-spacing: 8px; font-weight: bold; padding: 15px; background: white; border: 2px solid #000; margin: 15px 0;">
                    ||||| ||| |||| || ||||<br>
                    <span style="font-size: 14px; letter-spacing: normal;" id="barcode-text">MUSLIM-446006712</span>
                </div>
                <p style="font-size: 12px; color: #718096;">امسحي الرمز عند بوابة الفحص الميداني للحافلات والفنادق.</p>
            </div>
        </section>

        <section id="page-login" class="page-section">
            <h2 style="color: var(--primary-color); margin-bottom: 15px;">🔐 بوابة تسجيل الدخول الموحدة للمنصة</h2>
            <div style="background: #fffaf0; border-right: 4px solid var(--secondary-color); padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 13px;">
                💡 <strong>بيانات الدخول التجريبية الخاصة بكِ المعتمدة:</strong><br>
                الهوية: <code style="font-weight: bold; color: #b7791f;">12345678910</code> | كلمة المرور: <code style="font-weight: bold; color: #b7791f;">123456</code>
            </div>
            
            <form onsubmit="handleLogin(event)" style="max-width: 450px;">
                <div class="form-group">
                    <label>نوع الحساب المستفيد:</label>
                    <select id="user_type">
                        <option value="citizen">مواطن / مقيم (التحقق الآمن عبر نفاذ)</option>
                        <option value="visitor">زائر دولي (التحقق عبر كرت الزيارة)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>رقم الهوية الوطنية:</label>
                    <input type="text" id="login_id" placeholder="ادخلي رقم الهوية الوطنية" required>
                </div>
                <div class="form-group">
                    <label>كلمة المرور:</label>
                    <input type="password" id="login_pass" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn">تسجيل الدخول الآمن</button>
            </form>
        </form>
    </main>
</div>

<footer>
    <p>© 2026 Muslim Platform | مشروع تخرج وتطوير مادة الويب IT1262 للفريق البرمجي</p>
</footer>

<script>
    // كائنات حفظ حالة واجهة المستخدم فورياً وثباتها
    let currentHotel = "لم يحدد";
    let currentBus = "لم تحدد";
    let tawafCount = 0;
    let isLoggedIn = false;

    // دالة التحول الكامل بين الصفحات السبع لمنع التراكم والتداخل المكتبي
    function switchPage(pageId) {
        // إخفاء كل السكاشن
        document.querySelectorAll('.page-section').forEach(sec => {
            sec.classList.remove('active');
        });
        // إزالة نشاط روابط الـ Nav
        document.querySelectorAll('nav a').forEach(link => {
            link.classList.remove('active');
        });
        
        // إظهار السكشن المطلوب وتفعيل الرابط الخاص به
        const targetSection = document.getElementById('page-' + pageId);
        const targetNavLink = document.getElementById('nav-' + pageId);
        
        if(targetSection) targetSection.classList.add('active');
        if(targetNavLink) targetNavLink.classList.add('active');
        
        // إخفاء بنر الإشعارات عند تغيير الصفحة
        document.getElementById('action-banner').style.display = 'none';
    }

    // دالة تسجيل الدخول والتحقق من بيانات داليا عايض الغامدي
    function handleLogin(e) {
        e.preventDefault();
        const idInp = document.getElementById('login_id').value.trim();
        const passInp = document.getElementById('login_pass').value.trim();
        const banner = document.getElementById('action-banner');

        if(idInp === "12345678910" && passInp === "123456") {
            isLoggedIn = true;
            // تحديث بيانات داليا في اللوحة الجانبية فوراً
            document.getElementById('side-user-name').innerText = "داليا عايض الغامدي";
            document.getElementById('side-user-id').innerText = idInp;
            
            const statusBadge = document.getElementById('side-user-status');
            statusBadge.innerText = "متصل (مصادقة معتمدة)";
            statusBadge.style.background = "#2f855a"; // تحويل اللون للأخضر
            
            banner.innerText = "🔐 مرحباً بكِ يا داليا عايض الغامدي، تم التحقق وتنشيط الملف الشخصي بنجاح!";
            banner.style.background = "#c6f6d5";
            banner.style.color = "#22543d";
            banner.style.display = "block";
            
            // التوجيه التلقائي لصفحة الفنادق لتبدأ الاختيار
            setTimeout(() => { switchPage('hotels'); }, 1500);
        } else {
            banner.innerText = "❌ خطأ في رقم الهوية أو كلمة المرور! يرجى إدخال البيانات المعتمدة للتجربة.";
            banner.style.background = "#fed7d7";
            banner.style.color = "#9b2c2c";
            banner.style.display = "block";
        }
    }

    // دالة تخصيص واختيار الفندق
    function selectHotel(hotelName) {
        currentHotel = hotelName;
        document.getElementById('side-chosen-hotel').innerText = hotelName;
        document.getElementById('cart-hotel').innerText = hotelName;
        
        const banner = document.getElementById('action-banner');
        banner.innerText = `🏨 تم ربط وتخصيص [ ${hotelName} ] بملف حيازتكِ اللوجستي بنجاح!`;
        banner.style.background = "#ebf8ff";
        banner.style.color = "#2b6cb0";
        banner.style.display = "block";
        window.scrollTo({top: 0, behavior: 'smooth'});
    }

    // دالة ركوب واختيار الحافلة من الخمسة حافلات
    function selectBus(busName) {
        currentBus = busName;
        document.getElementById('side-chosen-bus').innerText = busName;
        document.getElementById('cart-bus').innerText = busName;
        
        const banner = document.getElementById('action-banner');
        banner.innerText = `🚌 تم ربط مسار [ ${busName} ] ببطاقتكِ الإرشادية بنجاح!`;
        banner.style.background = "#ebf8ff";
        banner.style.color = "#2b6cb0";
        banner.style.display = "block";
        window.scrollTo({top: 0, behavior: 'smooth'});
    }

    // دالة كاونتر الطواف التفاعلي
    function incrementTawaf() {
        if(tawafCount < 7) {
            tawafCount++;
            updateTawafDisplay();
            if(tawafCount === 7) {
                alert("🕋 ما شاء الله! أتممتِ الأشواط السبعة كاملة. تقبل الله طوافكِ وصالح أعمالكِ.");
            }
        }
    }
    function resetTawaf() {
        tawafCount = 0;
        updateTawafDisplay();
    }
    function updateTawafDisplay() {
        document.getElementById('tawaf-counter-display').innerText = tawafCount;
        document.getElementById('side-tawaf-lap').innerText = tawafCount + " / 7";
    }

    // دالة تأكيد الدفع وإصدار باركود الفحص النهائي
    function confirmCheckout() {
        if(currentHotel === "لم يحدد") {
            alert("⚠️ يرجى الذهاب لصفحة الفنادق واختيار فندق وتسكين أولاً قبل الدفع وتوليد التصريح.");
            switchPage('hotels');
            return;
        }
        
        // إظهار باركود الـ QR
        document.getElementById('barcode-area').style.display = 'block';
        const randCode = "MUSLIM-" + Math.floor(100000 + Math.random() * 900000);
        document.getElementById('barcode-text').innerText = randCode;
        
        const banner = document.getElementById('action-banner');
        banner.innerText = "💳 تم تأكيد السداد وإصدار كرت التصريح الرقمي بالباركود الفعلي!";
        banner.style.background = "#c6f6d5";
        banner.style.color = "#22543d";
        banner.style.display = "block";
        window.scrollTo({top: document.body.scrollHeight, behavior: 'smooth'});
    }
</script>

</body>
</html>
