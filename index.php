<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "hajj_umrah_db";

$conn = mysqli_connect(
$host,
$user,
$password,
$database
);

if(!$conn){

die("Database Connection Failed");

}

/* CONTACT FORM */

if(isset($_POST['sendMessage'])){

    $name =
    mysqli_real_escape_string(
    $conn,
    $_POST['name']
    );

    $email =
    mysqli_real_escape_string(
    $conn,
    $_POST['email']
    );

    $message =
    mysqli_real_escape_string(
    $conn,
    $_POST['message']
    );

    $sql = "

    INSERT INTO contact_messages

    (
    name,
    email,
    message
    )

    VALUES

    (
    '$name',
    '$email',
    '$message'
    )

    ";

    mysqli_query($conn, $sql);

    $success =
‎    "تم إرسال الرسالة بنجاح";

}

/* RECEIPT UPLOAD */

if(isset($_POST['uploadReceipt'])){

    $identity =
    $_POST['identity_number'];

    $file =
    $_FILES['receipt'];

    $allowed =
    ['jpg','jpeg','png','pdf'];

    $filename =
    $file['name'];

    $ext =
    strtolower(
    pathinfo(
    $filename,
    PATHINFO_EXTENSION
    )
    );

    if(in_array($ext, $allowed)){

        $newName =
        time() . "." . $ext;

        move_uploaded_file(

        $file['tmp_name'],

        "uploads/receipts/" . $newName

        );

        $update = "

        UPDATE pilgrims

        SET

        receipt_file='$newName',
        permit_status='Verified'

        WHERE identity_number='$identity'

        ";

        mysqli_query($conn, $update);

        $uploadSuccess =
‎        "تم رفع الإيصال وتأكيد الحجز";

    }else{

        $uploadError =
‎        "صيغة الملف غير مدعومة";

    }

}

?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Muslim Platform</title>

<link rel="stylesheet" href="css/style.css">

</head>

<body>

<!-- CONTACT FORM -->

<div class="payment-box">

    <h1>اتصل بنا</h1>

    <?php

    if(isset($success)){

        echo "

        <p style='color:green'>

        $success

        </p>

        ";

    }

    ?>

    <form method="POST">

        <input
        type="text"
        name="name"
        placeholder="الاسم"
        required>

        <input
        type="email"
        name="email"
        placeholder="البريد الإلكتروني"
        required>

        <textarea
        name="message"
        placeholder="رسالتك"
        style="width:100%;height:150px;padding:15px;margin-top:15px;">
        </textarea>

        <button
        type="submit"
        name="sendMessage">

‎        إرسال الرسالة

        </button>

    </form>

</div>

<!-- RECEIPT UPLOAD -->

<div class="payment-box">

    <h1>رفع إيصال الحجز</h1>

    <?php

    if(isset($uploadSuccess)){

        echo "

        <p style='color:green'>

        $uploadSuccess

        </p>

        ";

    }

    if(isset($uploadError)){

        echo "

        <p style='color:red'>

        $uploadError

        </p>

        ";

    }

    ?>

    <form
    method="POST"
    enctype="multipart/form-data">

        <input
        type="text"
        name="identity_number"
        placeholder="رقم الهوية"
        required>

        <input
        type="file"
        name="receipt"
        required>

        <button
        type="submit"
        name="uploadReceipt">

‎        رفع الإيصال

        </button>

    </form>

</div>

</body>
</html>
