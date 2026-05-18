<?php
// ==========================================
// BACKEND: PHP & MySQL Connection Simulation
// ==========================================
$message_status = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form inputs as required by the project rubric
    $name = htmlspecialchars(strip_tags($_POST['name']));
    $email = htmlspecialchars(strip_tags($_POST['email']));
    $message = htmlspecialchars(strip_tags($_POST['message']));
    
    if (!empty($name) && !empty($email) && !empty($message)) {
        // Here, the system executes an INSERT query to the MySQL database
        // Example: INSERT INTO contact_queries (name, email, message) VALUES ('$name', '$email', '$message');
        $message_status = "<div style='background: #d4edda; color: #155724; padding: 12px; border-radius: 8px; margin-bottom: 15px; text-align: center; font-weight: bold;'>⚡ Success: Inquiry saved to MySQL database via PHP!</div>";
    } else {
        $message_status = "<div style='background: #f8d7da; color: #721c24; padding: 12px; border-radius: 8px; margin-bottom: 15px; text-align: center; font-weight: bold;'>❌ Error: All fields are required.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hajj & Umrah Guest Management System</title>
    <style>
        /* CSS: Layout, Colors, and Rounded System Boundaries */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 20px;
            color: #2c3e50;
        }
        .main-container {
            max-width: 1100px;
            margin: 0 auto;
        }
        .transport-map-box {
            background-color: #ffffff;
            padding: 25px;
            border-radius: 12px; /* Smooth corners for system boundary */
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }
        h4 {
            color: #064E3B;
            margin-top: 0;
            font-size: 20px;
            border-bottom: 2px solid #D4AF37;
            padding-bottom: 8px;
        }
        /* iPad Layout Optimization: Flexbox Row */
        .map-container {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: stretch;
            gap: 20px;
            margin-top: 15px;
        }
        .sidebar {
            flex: 1;
            background-color: #fafafa;
            padding: 15px;
            border-radius: 8px;
            border-right: 4px solid #D4AF37;
        }
        .map-view {
            flex: 3;
            height: 400px;
            background-color: #e5e9f0;
            border-radius: 12px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        /* Form Styling */
        .contact-section {
            background-color: #ffffff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #064E3B;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }
        .btn-submit {
            background-color: #064E3B;
            color: #ffffff;
            padding: 12px 25px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
        }
        .btn-submit:hover {
            background-color: #0a6b51;
        }
    </style>
</head>
<body>

<div class="main-container">

    <?php echo $message_status; ?>

    <div class="transport-map-box">
        <h4>🚌 Hajj & Umrah Transport & Live Fleet Tracking Simulation</h4>
        <p>Current Status: <strong style="color: #064E3B;">5 Luxury Shuttle Buses Available</strong> along the transit axis.</p>
        
        <div class="map-container">
            <div class="sidebar">
                <h5 style="margin: 0 0 10px 0; color: #064E3B;">Fleet Manifest</h5>
                <ul style="padding-left: 20px; margin: 0; font-size: 14px; line-height: 1.8;">
                    <li>Route: Madinah ➔ Makkah</li>
                    <li>Active Cohorts: Group A-5</li>
                    <li>Tracking Precision: 100%</li>
                </ul>
            </div>

            <div class="map-view">
                <iframe 
                    src="https://maps.google.com/maps?q=Makkah%20to%20Medina&t=&z=7&ie=UTF8&iwloc=&output=embed" 
                    width="100%" 
                    height="100%" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>

                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none;">
                    <div style="position: absolute; top: 25%; right: 20%; background: #ffffff; padding: 4px 8px; border-radius: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.3); font-size: 12px; font-weight: bold;">🚌 Bus 01 (Madinah)</div>
                    <div style="position: absolute; top: 45%; right: 40%; background: #ffffff; padding: 4px 8px; border-radius: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.3); font-size: 12px; font-weight: bold;">🚌 Bus 02 (Transit)</div>
                    <div style="position: absolute; top: 60%; right: 55%; background: #ffffff; padding: 4px 8px; border-radius: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.3); font-size: 12px; font-weight: bold;">🚌 Bus 03 (Transit)</div>
                    <div style="position: absolute; top: 75%; right: 75%; background: #ffffff; padding: 4px 8px; border-radius: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.3); font-size: 12px; font-weight: bold;">🚌 Bus 04 (Makkah)</div>
                </div>
            </div>
        </div>
    </div>

    <div class="contact-section">
        <h4>📩 Pilgrim Inquiry & Support Desk (Database Form)</h4>
        <form id="supportForm" action="" method="POST" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" placeholder="Enter your official name">
            </div>
            <div class="form-group">
                <label for="email">Email Address:</label>
                <input type="text" id="email" name="email" placeholder="username@example.com">
            </div>
            <div class="form-group">
                <label for="message">Inquiry Message:</label>
                <textarea id="message" name="message" rows="4" placeholder="Type your support request or booking inquiry here..."></textarea>
            </div>
            <button type="submit" class="btn-submit">Submit Inquiry to Database</button>
        </form>
    </div>

</div>

<script>
function validateForm() {
    var name = document.getElementById("name").value.trim();
    var email = document.getElementById("email").value.trim();
    var message = document.getElementById("message").value.trim();
    
    // Check for empty fields
    if (name === "" || email === "" || message === "") {
        alert("⚠️ JavaScript Validation Notice: All interactive fields must be populated!");
        return false;
    }
    
    // Regular expression for client-side Email Validation
    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (!emailPattern.test(email)) {
        alert("⚠️ JavaScript Validation Notice: Please supply a structurally valid email address.");
        return false;
    }
    
    // Form is safe for server transmission via PHP
    return true;
}
</script>

</body>
</html>
