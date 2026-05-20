CREATE DATABASE hajj_umrah_db;

USE hajj_umrah_db;

‎-- جدول الحجاج

CREATE TABLE pilgrims (

    id INT AUTO_INCREMENT PRIMARY KEY,

    full_name VARCHAR(100),

    identity_number VARCHAR(20) UNIQUE,

    nationality VARCHAR(50),

    package_type VARCHAR(50),

    hotel_name VARCHAR(100),

    permit_status VARCHAR(50) DEFAULT 'Valid',

    qr_token VARCHAR(255),

    receipt_file VARCHAR(255),

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);

‎-- جدول الرسائل

CREATE TABLE contact_messages (

    id INT AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(100),

    email VARCHAR(100),

    message TEXT,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);

‎-- جدول المدفوعات

CREATE TABLE payments (

    id INT AUTO_INCREMENT PRIMARY KEY,

    pilgrim_id INT,

    amount DECIMAL(10,2),

    payment_method VARCHAR(50),

    payment_status VARCHAR(50),

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);

‎-- جدول النقل

CREATE TABLE transport_buses (

    id INT AUTO_INCREMENT PRIMARY KEY,

    bus_name VARCHAR(50),

    driver_name VARCHAR(100),

    status VARCHAR(50),

    current_location VARCHAR(255),

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);

‎-- جدول الفنادق

CREATE TABLE hotels (

    id INT AUTO_INCREMENT PRIMARY KEY,

    hotel_name VARCHAR(100),

    available_rooms INT,

    discount_percentage INT,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);

‎-- بيانات تجريبية للحجاج

INSERT INTO pilgrims (

full_name,
identity_number,
nationality,
package_type,
hotel_name,
permit_status,
qr_token

)

VALUES

(
'Dalia Alghamdi',
'12345678910',
'Saudi',
'Gold Package',
'Al Safwah Hotel',
'Valid',
'QR123456'
),

(
'Nojood Alghamdi',
'99887766554',
'Saudi',
'Emerald Package',
'Zamzam Hotel',
'Valid',
'QR998877'
);

‎-- بيانات تجريبية للباصات

INSERT INTO transport_buses (

bus_name,
driver_name,
status,
current_location

)

VALUES

(
'Bus 1',
'Ahmed',
'Active',
'Makkah Road'
),

(
'Bus 2',
'Mohammed',
'In Transit',
'Madinah Highway'
),

(
'Bus 3',
'Khalid',
'Delayed',
'Checkpoint'
);

‎-- بيانات الفنادق

INSERT INTO hotels (

hotel_name,
available_rooms,
discount_percentage

)

VALUES

(
'Al Safwah Hotel',
14,
15
),

(
'Zamzam Hotel',
7,
15
);

‎-- بيانات المدفوعات

INSERT INTO payments (

pilgrim_id,
amount,
payment_method,
payment_status

)

VALUES

(
1,
15000.00,
'Visa',
'Confirmed'
),

(
2,
8000.00,
'Mada',
'Pending'
);
