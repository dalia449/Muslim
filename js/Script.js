// دالة التحقق ومحاكاة الحساب المطلوب في المشروع الجامعي
function handleLogin(event) {
    event.preventDefault(); // منع الصفحة من التحديث التلقائي

    let idNumber = document.getElementById("idNumber").value.trim();
    let password = document.getElementById("password").value;

    // الحساب المحاكي المطلوب والمحدد من قبلكِ للمشروع
    const mockID = "12345678910";
    const mockPassword = "1234";

    if (idNumber === mockID && password === mockPassword) {
        // إخفاء صفحة تسجيل الدخول وفتح لوحة خدمات البروتوتايب بالكامل فوراً
        document.getElementById("loginPage").style.display = "none";
        document.getElementById("dashboardPage").style.display = "flex";
        document.body.style.backgroundColor = "#f4f6f8"; // تغيير الخلفية لنمط لوحة التحكم المعماري
    } else {
        // تنبيه في حال إدخال بيانات خاطئة للطلاب ليعرفوا الحساب الصحيح
        alert("❌ عذراً، رقم الهوية أو كلمة المرور غير صحيحة.\nتلميح للمحاكاة:\nرقم الهوية: 12345678910\nكلمة المرور: 1234");
    }
    return false;
}

// دالة التنقل الفوري والمرن بين الخدمات والقائمة الجانبية في البروتوتايب
function switchTab(tabId) {
    // إخفاء جميع تبويبات الخدمات المفتوحة أولاً
    let tabs = document.getElementsByClassName("tab-content");
    for (let i = 0; i < tabs.length; i++) {
        tabs[i].style.display = "none";
    }

    // إزالة اللون النشط من كافة خيارات القائمة الجانبية
    let menuItems = document.querySelectorAll(".sidebar-menu li");
    menuItems.forEach(item => item.classList.remove("active"));

    // إظهار تبويب الخدمة التي تم النقر عليها
    document.getElementById("tab-" + tabId).style.display = "block";

    // تفعيل وإضافة التنسيق الأخضر للخيار النشط حالياً في القائمة الجانبية
    document.getElementById("menu-" + tabId).classList.add("active");
}

// دالة تسجيل الخروج والعودة الفورية لواجهة تسجيل الدخول مجدداً
function logout() {
    document.getElementById("dashboardPage").style.display = "none";
    document.getElementById("loginPage").style.display = "flex";
    document.body.style.backgroundColor = "#DFF5E1"; // إعادة الخلفية الأصلية
    document.getElementById("loginForm").reset(); // مسح الخانات
}
