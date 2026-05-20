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

<div class="transport-layout">

    <div class="bus-status">

        <h2>الحافلات</h2>

        <div class="bus-card active">
            Bus 1 - Active
        </div>

        <div class="bus-card transit">
            Bus 2 - In Transit
        </div>

        <div class="bus-card delayed">
            Bus 3 - Delayed
        </div>

        <div class="bus-card standby">
            Bus 4 - Standby
        </div>

        <div class="bus-card active">
            Bus 5 - Active
        </div>

    </div>

    <div class="map-box">

        <h2>مسار النقل</h2>

        <div class="road">

            <div class="bus">
                🚌
            </div>

        </div>

    </div>

</div>

</body>
</html>
