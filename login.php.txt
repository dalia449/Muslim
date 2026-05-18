<?php
// استقبال البيانات القادمة من نموذج تسجيل الدخول عبر طريقة POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idType = $_POST['id_type'];
    $idNumber = $_POST['id_number'];
    $password = $_POST['password'];

    // كود محاكاة (Simulation) لنجاح العملية وعرضها للدكتور/ة
    echo "<div style='font-family: Arial; text-align: center; margin-top: 50px; color: #0B6623;'>";
    echo "<h2>تم تسجيل الدخول بنجاح (Simulation)</h2>";
    echo "<hr style='width: 50%;'>";
    echo "<p><b>نوع الهوية المستخدمة:</b> " . htmlspecialchars($idType) . "</p>";
    echo "<p><b>رقم الهوية / الإقامة:</b> " . htmlspecialchars($idNumber) . "</p>";
    echo "<br><a href='../index.html' style='color: #198754;'>العودة للرئيسية</a>";
    echo "</div>";
} else {
    // حماية للملف في حال محاولة دخوله مباشرة بدون نموذج
    header("Location: ../index.html");
    exit();
}
?>
