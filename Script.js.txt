// دالة التحقق من صحة المدخلات قبل إرسالها للسيرفر
function validateLogin() {
    let idNumber = document.getElementById("idNumber").value.trim();
    let password = document.getElementById("password").value;

    // التأكد من أن الحقول ليست فارغة
    if (idNumber === "" || password === "") {
        alert("فضلاً، املأ جميع الحقول المطلوبة.");
        return false;
    }

    // التأكد من طول كلمة المرور لأمان الحساب
    if (password.length < 6) {
        alert("يجب أن تكون كلمة المرور مكونة من 6 خانات أو أكثر.");
        return false;
    }

    return true; // إذا كانت البيانات سليمة يتم الانتقال لصفحة PHP
}
