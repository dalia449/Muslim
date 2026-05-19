-- =========================================================================
-- 1. إنشاء قاعدة البيانات الموحدة وتفعيلها (Database Creation & Context)
-- =========================================================================
‏CREATE DATABASE IF NOT EXISTS hajj_umrah_db;
‏USE hajj_umrah_db;

-- =========================================================================
-- 2. جدول الحسابات والمستخدمين (Users Credentials Table for Login Validation)
-- =========================================================================
‏CREATE TABLE IF NOT EXISTS users (
‏    id INT AUTO_INCREMENT PRIMARY KEY,
‏    id_type VARCHAR(50) NOT NULL,          -- نوع الهوية (National ID, Iqama, Visitor Card)
‏    id_number VARCHAR(50) NOT NULL UNIQUE, -- رقم الهوية (مفتاح فريد يمنع التكرار)
‏    password VARCHAR(255) NOT NULL         -- كلمة المرور لتوثيق الجلسات الآمنة
);

-- إدراج الحساب القياسي المحاكي في الجدول لضمان عمل الواجهة مباشرة عند الاختبار محلياً
‏INSERT INTO users (id_type, id_number, password) VALUES 
‏('National ID', '12345678910', '1234')
‏ON DUPLICATE KEY UPDATE password='1234';


-- =========================================================================
-- 3. جدول سجلات الحجاج والإيصالات والتصاريح (Pilgrims Control Table for CRUD Tasks)
-- =========================================================================
‏CREATE TABLE IF NOT EXISTS pilgrims (
‏    id INT AUTO_INCREMENT PRIMARY KEY,
‏    name VARCHAR(120) NOT NULL,
‏    id_number VARCHAR(30) NOT NULL UNIQUE,
‏    package_tier VARCHAR(50) NOT NULL,
‏    receipt_path VARCHAR(255) DEFAULT NULL,    -- لحفظ مسار إيصال حجز الفندق المرفوع عبر PHP
‏    booking_status VARCHAR(50) DEFAULT 'Pending',
‏    permit_serial VARCHAR(100) DEFAULT 'MSLM-2026-992172',
‏    permit_status VARCHAR(50) DEFAULT 'Valid', -- يتغير برمجياً إلى Invalidated عند استهلاك مسح الباركود لمرة واحدة
‏    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- إدراج سجل تجريبي مطابق لبيانات الفريق الأكاديمي لعرض المحاكاة الحية أمام الدكتورة
‏INSERT INTO pilgrims (name, id_number, package_tier) VALUES 
‏('Bayan Misfer Al-Ghamdi', '446005010', 'Luxury VIP Tier')
‏ON DUPLICATE KEY UPDATE package_tier='Luxury VIP Tier';


-- =========================================================================
-- 4. جدول الرسائل والتعليقات (Contact Messages Table for CRUD - INSERT pipeline)
-- =========================================================================
‏CREATE TABLE IF NOT EXISTS contact_messages (
‏    id INT AUTO_INCREMENT PRIMARY KEY,
‏    full_name VARCHAR(150) NOT NULL,
‏    email_address VARCHAR(150) NOT NULL,
‏    message_text TEXT NOT NULL,
‏    received_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- =========================================================================
-- 5. جدول تتبع حركة أسطول الحافلات الخمسة (Bus Fleet Telemetry for SELECT Live Feed)
-- =========================================================================
‏CREATE TABLE IF NOT EXISTS transit_fleet (
‏    bus_id INT AUTO_INCREMENT PRIMARY KEY,
‏    shuttle_name VARCHAR(100) NOT NULL,
‏    fleet_status VARCHAR(50) NOT NULL
);

-- تصفير الجدول وإدخال الحافلات الخمسة المطلوبة لضمان مطابقتها للمخطط والواجهة بالملي
‏TRUNCATE TABLE transit_fleet;

‏INSERT INTO transit_fleet (shuttle_name, fleet_status) VALUES 
‏('Shuttle Bus #01', 'Active'),
‏('Shuttle Bus #02', 'Active'),
‏('Shuttle Bus #03', 'In Transit'),
‏('Shuttle Bus #04', 'Delayed'),
‏('Shuttle Bus #05', 'Standby');
