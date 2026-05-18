// دالة التحقق من الحساب وفتح البروتوتايب الشامل
function handleLogin(event) {
    event.preventDefault(); // منع الصفحة من إعادة التحميل

    let idNumber = document.getElementById("idNumber").value.trim();
    let password = document.getElementById("password").value;

    // الحساب المحاكي المعتمد والمطلوب للمشروع
    const mockID = "12345678910";
    const mockPassword = "1234";

    if (idNumber === mockID && password === mockPassword) {
        // إخفاء تسجيل الدخول وإظهار واجهة البروتوتايب العربي المتكاملة فوراً
        document.getElementById("loginPage").style.display = "none";
        document.getElementById("dashboardPage").style.display = "flex";
        document.body.style.backgroundColor = "#f4f6f8"; // تبديل خلفية النظام
    } else {
        alert("❌ عذراً، رقم الهوية أو كلمة المرور غير صحيحة المحاكاة مخصصة للهوية: 12345678910 والباسورد: 1234");
    }
    return false;
}

// دالة التنقل التفاعلي بين كافة تبويبات خدمات المخطط
function switchTab(tabId) {
    // إخفاء جميع الواجهات الداخلية
    let tabs = document.getElementsByClassName("tab-content");
    for (let i = 0; i < tabs.length; i++) {
        tabs[i].style.display = "none";
    }

    // إزالة الصف واللون النشط من القائمة الجانبية الملونة
    let menuItems = document.querySelectorAll(".sidebar-menu li");
    menuItems.forEach(item => item.classList.remove("active"));

    // إظهار واجهة الخدمة المطلوبة والمطابقة للمخطط بالملي
    document.getElementById("tab-" + tabId).style.display = "block";

    // تفعيل وتلوين زر القائمة المختار باللون الزمردي
    document.getElementById("menu-" + tabId).classList.add("active");
}

// دالة إظهار كرت تصريح العمرة المحاكي المعتمد بالـ QR
function showPermitSim() {
    document.getElementById("permitDisplay").style.visibility = "visible";
    alert("✨ تم توليد وإصدار تصريح الطواف المحاكي بنظام مٌسلم الموحد بنجاح!");
}

// تسجيل الخروج والعودة للواجهة الخضراء الرئيسية
function logout() {
    document.getElementById("dashboardPage").style.display = "none";
    document.getElementById("loginPage").style.display = "flex";
    document.body.style.backgroundColor = "#DFF5E1";
    document.getElementById("loginForm").reset();
    document.getElementById("permitDisplay").style.visibility = "hidden"; // إعادة إخفاء التصريح
}
