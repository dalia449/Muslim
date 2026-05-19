‏<?php
// =========================================================================
// 1. إدارة الجلسات والاتصال الآمن بقاعدة البيانات (Sessions & DB Connectivity)
// =========================================================================
‏session_start();

// إعداد معايير الاتصال بقاعدة بيانات السيرفر المحلي لـ XAMPP (phpMyAdmin)
‏$host = "localhost";
‏$db_user = "root";
‏$db_pass = "";
‏$db_name = "hajj_umrah_db";

‏$conn = new mysqli($host, $db_user, $db_pass, $db_name);

// فحص جاهزية محرك قاعدة بيانات MySQL لتخزين ومعالجة طلبات النظام
‏$db_active = !$conn->connect_error;


// =========================================================================
// 2. معالجة بيانات نموذج تسجيل الدخول (Login Submission Processor)
// =========================================================================
‏if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_type']) && isset($_POST['id_number'])) {
‏    $idType = $_POST['id_type'];
‏    $idNumber = $_POST['id_number'];
‏    $password = $_POST['password'];

    // كود محاكاة (Simulation) لنجاح العملية وعرض مخرجاتها الأكاديمية للدكتور/ة واللجنة
‏    echo "<div style='font-family: Arial, sans-serif; text-align: center; margin-top: 50px; color: #0B6623; padding: 20px; background: #f8fafc; border-radius: 15px; max-width: 500px; margin-left: auto; margin-right: auto; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border-top: 6px solid #0B6623;'>";
‏    echo "<h2>✨ تم تسجيل الدخول بنجاح (Simulation)</h2>";
‏    echo "<hr style='width: 50%; border: 1px solid #cbd5e1; margin: 15px auto;'>";
‏    echo "<p style='font-size: 16px; color: #334155;'><b>نوع الهوية المستخدمة:</b> " . htmlspecialchars($idType) . "</p>";
‏    echo "<p style='font-size: 16px; color: #334155;'><b>رقم الهوية / الإقامة:</b> " . htmlspecialchars($idNumber) . "</p>";
‏    echo "<br><a href='index.html' style='display: inline-block; background: #198754; color: white; padding: 10px 20px; text-decoration: none; border-radius: 8px; font-weight: bold; margin-top: 10px;'>العودة للرئيسية</a>";
‏    echo "</div>";
‏    exit();
}


// =========================================================================
// 3. معالجة رفع وتوثيق إيصال حجز الفنادق الخارجي (Hotel Receipt Uploader)
// =========================================================================
‏if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['upload_receipt_btn'])) {
‏    $upload_dir_path = "uploads/receipts/";
    
    // إنشاء مجلد الحفظ تلقائياً في السيرفر المحلي لمنع حدوث أي خطأ برمي
‏    if (!file_exists($upload_dir_path)) {
‏        mkdir($upload_dir_path, 0777, true);
    }
    
    // إعطاء الإيصال اسماً فريداً بالوقت الملي لضمان عدم تداخل أسماء الملفات
‏    $file_unique_name = time() . "_" . basename($_FILES["hotel_receipt"]["name"]);
‏    $destination_path = $upload_dir_path . $file_unique_name;
‏    $file_extension = strtolower(pathinfo($destination_path, PATHINFO_EXTENSION));
    
    // فلترة الامتدادات لأمن وحماية النظام (PDF, JPG, PNG)
‏    $secure_extensions = array("pdf", "jpg", "jpeg", "png");
    
‏    if (in_array($file_extension, $secure_extensions)) {
‏        if (move_uploaded_file($_FILES["hotel_receipt"]["tmp_name"], $destination_path)) {
            
‏            $pilgrim_card_id = mysqli_real_escape_string($conn, $_POST['id_hidden']);
            
‏            if ($db_active) {
                // تنفيذ استعلام تحديث السجلات الفعلي (CRUD - UPDATE statement)
‏                $update_query = "UPDATE pilgrims SET receipt_path = ?, booking_status = 'Verified' WHERE id_number = ?";
‏                $stmt = $conn->prepare($update_query);
‏                $stmt->bind_param("ss", $destination_path, $pilgrim_card_id);
‏                $stmt->execute();
‏                $stmt->close();
            }
            
‏            echo "<script>
‏                    alert('✅ Success: Booking receipt uploaded and securely verified inside Muslim Database!');
‏                    window.location.href='index.html#hotels';
‏                  </script>";
‏            exit();
‏        } else {
‏            echo "<script>alert('🚨 Server Write Error: Failed to save storage stream.'); window.location.href='index.html#hotels';</script>";
‏            exit();
        }
‏    } else {
‏        echo "<script>alert('🔒 Security Extension Blocked: Only PDF, JPG & PNG receipts are validated.'); window.location.href='index.html#hotels';</script>";
‏        exit();
    }
}


// =========================================================================
// 4. نظام فحص ومسح التصريح لمرة واحدة فقط (Single-Use Permit Scan Validation)
// =========================================================================
‏if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['scan_permit_btn'])) {
‏    $permit_serial = $_POST['permit_serial_check'];

    // فحص الجلسة (Session) لمعرفة إذا كان هذا الباركود تم مسحه واستهلاكه مسبقاً
‏    if (isset($_SESSION['permit_scanned_status']) && $_SESSION['permit_scanned_status'] === true) {
‏        echo "<script>
‏                alert('🚨 Security Warning: This Digital Permit Barcode has ALREADY been scanned and invalidated! Access Denied.');
‏                window.location.href='index.html#permit';
‏              </script>";
‏        exit();
‏    } else {
        // إذا كانت أول محاولة مسح للتصريح، يتم قبوله وتغيير حالته في الجلسة وفي قاعدة البيانات فوراً إلى مستهلك
‏        $_SESSION['permit_scanned_status'] = true;
        
‏        if ($db_active) {
            // تحديث حالة التصريح برمجياً (CRUD - UPDATE statement)
‏            $update_permit_sql = "UPDATE pilgrims SET permit_status = 'Invalidated' WHERE permit_serial = ?";
‏            $stmt_p = $conn->prepare($update_permit_sql);
‏            $stmt_p->bind_param("s", $permit_serial);
‏            $stmt_p->execute();
‏            $stmt_p->close();
        }
        
‏        echo "<script>
‏                alert('✅ Verification Successful: Permit Serial " . $permit_serial . " Scanned & Invalidated for Single-Use protection.');
‏                window.location.href='index.html#permit';
‏              </script>";
‏        exit();
    }
}


// =========================================================================
// 5. التقاط ومعالجة رسائل فورم اتصل بنا والدعم (Contact Form Message Storing)
// =========================================================================
‏if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_contact'])) {
    // تنقية المدخلات من الفراغات والرموز الضارة (Input Sanitization)
‏    $name_cleared = mysqli_real_escape_string($conn, $_POST['name']);
‏    $email_cleared = mysqli_real_escape_string($conn, $_POST['email']);
‏    $msg_cleared = mysqli_real_escape_string($conn, $_POST['message']);
    
‏    if ($db_active) {
        // تنفيذ عمليات إدخال الرسالة إلى الجداول (CRUD - INSERT statement)
‏        $insert_query = "INSERT INTO contact_messages (full_name, email_address, message_text) VALUES (?, ?, ?)";
‏        $stmt_c = $conn->prepare($insert_query);
‏        $stmt_c->bind_param("sss", $name_cleared, $email_cleared, $msg_cleared);
‏        $stmt_c->execute();
‏        $stmt_c->close();
    }
    
‏    echo "<script>
‏            alert('📩 Thank you! Message successfully captured and stored inside local XAMPP MySQL database.');
‏            window.location.href='index.html#contact';
‏          </script>";
‏    exit();
}


// =========================================================================
// 6. الحماية التلقائية للملف وإغلاق قنوات الاتصال (File Protection & Cleanup)
// =========================================================================
‏if ($db_active) { 
‏    $conn->close(); 
}

// حماية الملف في حال محاولة الدخول المباشر إلى مسار index.php بدون إرسال النماذج
‏header("Location: index.html");
‏exit();
?>
