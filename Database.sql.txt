-- إنشاء قاعدة البيانات الخاصة بتطبيق مسلم
CREATE DATABASE IF NOT EXISTS muslim;
USE muslim;

-- إنشاء جدول المستخدمين لحفظ بيانات الهوية والإقامة والمحاكاة
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_type VARCHAR(50) NOT NULL,          -- نوع الهوية (وطنية، إقامة، زائر)
    id_number VARCHAR(50) NOT NULL UNIQUE, -- رقم الهوية (مفتاح فريد ومنع التكرار)
    password VARCHAR(255) NOT NULL         -- كلمة المرور المحمية
);
