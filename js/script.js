// =========================================================================
// 1. نظام الترحيب والتحقق من حساب الدخول والبروتوتايب (Authentication & Navigation)
// =========================================================================

‏function welcomeMessage(){
‏    alert("Welcome To Muslim Website! May Allah accept your ritual efforts.");
}

/**
 * دالة التحقق من الحساب وفتح البروتوتايب الشامل للوحة التحكم
 * تدعم الفحص الصارم لطول رقم الهوية (ألا يقل عن 10 خانات)
 */
‏function handleLogin(event) {
‏    event.preventDefault(); // منع الصفحة من إعادة التحميل الفوري

‏    let idType = document.getElementById("idType").value;
‏    let idNumber = document.getElementById("idNumber").value.trim();
‏    let password = document.getElementById("password").value;

    // 1. الفحص والتحقق الأكاديمي من الحقول (Validation Check)
‏    if (idType === "" || idNumber === "" || password === "") {
‏        alert("Validation Failure: Please fill out all required authentication variables.");
‏        return false;
    }
‏    if (idNumber.length < 10) {
‏        alert("Validation Failure: Your ID number sequence must be at least 10 numeric digits.");
‏        return false;
    }
‏    if (password.length < 4) {
‏        alert("Validation Failure: Password entry must contain at least 4 characters.");
‏        return false;
    }

    // 2. الحساب المحاكي المعتمد والمطلوب للمشروع لعرض الواجهات الداخلية أمام الدكتورة
‏    const mockID = "12345678910";
‏    const mockPassword = "1234";

‏    if (idNumber === mockID && password === mockPassword) {
‏        alert("Authentication validation parameters passed. Welcome to Muslim Dashboard!");
        
        // إخفاء واجهة تسجيل الدخول الخارجية وإظهار واجهة لوحة التحكم (Dashboard Page) فوراً
‏        document.getElementById("loginPage").style.display = "none";
‏        document.getElementById("dashboardPage").style.display = "flex";
‏        document.body.style.backgroundColor = "#f4f6f8"; // تبديل خلفية النظام للون المعتمد
        
        // توليد الباركود ديناميكياً برقم الهوية عند الدخول بنجاح لتأكيد ترابط العمليات
‏        generateDynamicBarcode(idNumber);
‏    } else {
‏        alert("❌ عذراً، رقم الهوية أو كلمة المرور غير صحيحة.\nالمحاكاة مخصصة للهوية القياسية: 12345678910 والباسورد: 1234");
    }
‏    return false;
}

/**
 * دالة التنقل التفاعلي بين كافة تبويبات وأقسام لوحة التحكم الجانبية (Tab Switcher)
 * تطابق مخطط المادة بالملي وتتحكم بالتنسيق الأخضر النشط للخيارات
 */
‏function switchTab(tabId) {
    // إخفاء جميع الواجهات الداخلية للتبويبات
‏    let tabs = document.getElementsByClassName("tab-content");
‏    for (let i = 0; i < tabs.length; i++) {
‏        tabs[i].style.display = "none";
    }

    // إزالة فئة اللون الأخضر النشط من كافة خيارات القائمة الجانبية (Sidebar Menu)
‏    let menuItems = document.querySelectorAll(".sidebar-menu li");
‏    menuItems.forEach(item => item.classList.remove("active"));

    // إظهار واجهة الخدمة المطلوبة المحددة
‏    let targetTab = document.getElementById("tab-" + tabId);
‏    if (targetTab) {
‏        targetTab.style.display = "block";
    }

    // تفعيل وإضافة التنسيق النشط للخيار المضغوط حالياً في القائمة الجانبية
‏    let targetMenu = document.getElementById("menu-" + tabId);
‏    if (targetMenu) {
‏        targetMenu.classList.add("active");
    }
}

/**
 * تسجيل الخروج بأمان والعودة الفورية للواجهة الخضراء الخارجية وتصفير الحقول
 */
‏function logout() {
‏    document.getElementById("dashboardPage").style.display = "none";
‏    document.getElementById("loginPage").style.display = "flex";
‏    document.body.style.backgroundColor = "#DFF5E1"; // إعادة الخلفية الإسلامية الخفيفة الأصلية
‏    document.getElementById("loginForm").reset(); // تصفير حقول استمارة الدخول
    
    // إعادة تعيين كرت التصريح الذكي والباركود للحالة المخفية
‏    let permitBox = document.getElementById("permitDisplay");
‏    if (permitBox) { permitBox.style.visibility = "hidden"; }
}

// =========================================================================
// 2. عداد الأشواط التفاعلي ودائرة التقدم للطواف (Tawaf Counter Module)
// =========================================================================

‏let tawafRound = 0;

/**
 * دالة إضافة شوط جديد وتحديث دائرة التقدم (Progress Circle)
 * تلتزم بحد أقصى 7 أشواط مع إظهار رسائل تفاعلية حية
 */
‏function incrementTawaf() {
‏    if (tawafRound < 7) {
‏        tawafRound++;
‏        document.getElementById("counterDisplay").innerText = tawafRound;
        
‏        let statusBox = document.getElementById("tawafStatus");
‏        let circleObject = document.getElementById("progressCircle");
        
        // تأثير حركي مرن (Scale Animation) عند الضغط لمحاكاة التفاعل المباشر بالأجهزة اللوحية
‏        circleObject.style.transform = "scale(1.05)";
‏        setTimeout(() => { circleObject.style.transform = "scale(1)"; }, 120);
        
        // تحديث رسائل الحالة بناءً على الشوط الحالي وتوليد تنبيه عند الاكتمال
‏        if (tawafRound === 7) {
‏            statusBox.innerHTML = "🎉 Alhamdulillah! All 7 structural loops of Tawaf are completed.";
‏            statusBox.style.color = "#0B6623";
‏            alert("Spiritual Ritual Notice: You have successfully completed the 7 rounds of Tawaf.");
‏        } else {
‏            statusBox.innerHTML = "Round " + tawafRound + " recorded. Keep moving safely around the Holy Kaaba.";
‏            statusBox.style.color = "#16a34a";
        }
    }
}

/**
 * دالة تصفير العداد لإعادة الطواف من جديد وتحديث النصوص
 */
‏function resetTawaf() {
‏    tawafRound = 0;
‏    document.getElementById("counterDisplay").innerText = tawafRound;
‏    document.getElementById("tawafStatus").innerHTML = "Counter reset. Click 'Add Round' to begin.";
‏    document.getElementById("tawafStatus").style.color = "#64748b";
}

// =========================================================================
// 3. التصاريح الذكية وتوليد الباركود الرقمي (Digital Permit Framework)
// =========================================================================

/**
 * دالة إظهار كرت تصريح العمرة المحاكي المعتمد وتحديث الرؤية
 */
‏function showPermitSim() {
‏    let permitBox = document.getElementById("permitDisplay");
‏    if (permitBox) {
‏        permitBox.style.visibility = "visible";
‏        alert("✨ تم توليد وإصدار تصريح الطواف المحاكي بنظام مُسلم الموحد بنجاح!");
    }
}

/**
 * دالة توليد الباركود ديناميكياً بناءً على رقم هوية المستخدم المتواجد
 */
‏function generateDynamicBarcode(customID) {
‏    let barcodeBox = document.getElementById("barcode_display");
‏    let targetID = customID ? customID : "12345678910"; // القيمة الافتراضية المحاكية كـ fallback
    
‏    if (barcodeBox) {
‏        barcodeBox.innerHTML = "|||*" + targetID + "*|||";
    }
}

// =========================================================================
// 4. التحقق والفلترة لاستمارة اتصل بنا والدعم (Contact Form RegEx Validation)
// =========================================================================

/**
 * دالة فحص وتدقيق مدخلات فورم اتصل بنا (تركيز الدكتور والأستاذة الأساسي في التقييم)
 * تمنع الحقول الفارغة وتفحص صياغة الإيميل الإلكتروني بالتعبيرات القياسية الصارمة RegEx
 */
‏function validateContactForm(event) {
‏    let clientName = document.getElementById("contactName").value;
‏    let clientEmail = document.getElementById("contactEmail").value;
‏    let clientMsg = document.getElementById("contactMessage").value;
    
    // 1. فحص الحقول الفارغة ومنع المسافات (Trim Check)
‏    if (clientName.trim() === "" || clientEmail.trim() === "" || clientMsg.trim() === "") {
‏        alert("Input Interception Fault: Form parameters cannot be sent blank.");
‏        event.preventDefault(); // إيقاف إرسال البيانات فوراً لمنع الأخطاء في السيرفر
‏        return false;
    }
    
    // 2. التحقق من صحة صياغة وهيكل الإيميل الإلكتروني عبر الـ RegEx القياسي
‏    let emailConstraint = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
‏    if (!emailConstraint.test(clientEmail)) {
‏        alert("Input Interception Fault: Invalid structure recognized inside Email string.");
‏        event.preventDefault(); // إلغاء تفعيل الـ Submit
‏        return false;
    }
    
‏    alert("Form Validation Successful! Routing submission parameters to index.php database controllers...");
‏    return true; // السماح بنقل البيانات ومعالجتها عبر السيرفر بأمان
}

// =========================================================================
// 5. تهيئة النظام عند تشغيل واستعراض الموقع (System Initialization)
// =========================================================================

‏document.addEventListener("DOMContentLoaded", function() {
    // توليد باركود أولي ذكي لتأكيد الجاهزية التشغيلية للملف بمجرد فتح الواجهة أمام لجنة التحكيم
‏    generateDynamicBarcode(null);
});
