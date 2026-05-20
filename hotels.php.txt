<?php
session_start();

if(!isset($_SESSION['user'])){
    header("Location:index.html");
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

<meta charset="UTF-8">

<link rel="stylesheet" href="css/style.css">

</head>

<body>

<div class="hotel-grid">

    <div class="hotel-card">

        <img
        src="https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=1200">

        <h2>فندق الصفوة</h2>

        <p>14 غرفة متبقية</p>

        <a href="#">
            خصم 15%
        </a>

    </div>

    <div class="hotel-card">

        <img
        src="https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?q=80&w=1200">

        <h2>فندق زمزم</h2>

        <p>7 غرف متبقية</p>

        <a href="#">
            خصم 15%
        </a>

    </div>

</div>

</body>
</html>
