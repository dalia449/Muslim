// نظام الفحص والتحقق الأكاديمي والتحكم في الواجهات التبويبية للآيباد
‏function handleLogin(event) {
‏    event.preventDefault();

‏    let idType = document.getElementById("idType").value;
‏    let idNumber = document.getElementById("idNumber").value.trim();
‏    let password = document.getElementById("password").value;

‏    if (idType === "" || idNumber === "" || password === "") {
‏        alert("Validation Failure: Please fill all required fields.");
‏        return false;
    }
‏    if (idNumber.length < 10) {
‏        alert("Validation Failure: ID number must be at least 10 digits.");
‏        return false;
    }

    // بيانات الحساب المحاكي المعتمد للمشروع
‏    const mockID = "12345678910";
‏    const mockPassword = "1234";

‏    if (idNumber === mockID && password === mockPassword) {
        // إخفاء صفحة الدخول وإظهار لوحة التحكم الفخمة فوراً
‏        document.getElementById("loginPage").style.display = "none";
‏        document.getElementById("dashboardPage").style.display = "flex";
‏        document.body.style.backgroundColor = "#f4f6f8";
‏    } else {
‏        alert("❌ Error: Invalid ID or Password!\nHint: Use 12345678910 and 1234");
    }
‏    return false;
}

‏function switchTab(tabId) {
‏    let tabs = document.getElementsByClassName("tab-content");
‏    for (let i = 0; i < tabs.length; i++) {
‏        tabs[i].style.display = "none";
    }

‏    let menuItems = document.querySelectorAll(".sidebar-menu li");
‏    menuItems.forEach(item => item.classList.remove("active"));

‏    document.getElementById("tab-" + tabId).style.display = "block";
‏    document.getElementById("menu-" + tabId).classList.add("active");
}

‏function logout() {
‏    document.getElementById("dashboardPage").style.display = "none";
‏    document.getElementById("loginPage").style.display = "flex";
‏    document.body.style.backgroundColor = "#DFF5E1";
‏    document.getElementById("loginForm").reset();
}

‏// --- Tawaf Counter System ---
‏let tawafRound = 0;

‏function incrementTawaf() {
‏    if (tawafRound < 7) {
‏        tawafRound++;
‏        document.getElementById("counterDisplay").innerText = tawafRound;
‏        document.getElementById("overviewTawaf").innerText = tawafRound + " / 7 Completed";
        
‏        let statusBox = document.getElementById("tawafStatus");
‏        if (tawafRound === 7) {
‏            statusBox.innerHTML = "🎉 Completed all 7 rounds of Tawaf successfully!";
‏            statusBox.style.color = "#0B6623";
‏        } else {
‏            statusBox.innerHTML = "Round " + tawafRound + " logged. Continue walking safely.";
        }
    }
}

‏function resetTawaf() {
‏    tawafRound = 0;
‏    document.getElementById("counterDisplay").innerText = tawafRound;
‏    document.getElementById("overviewTawaf").innerText = "0 / 7 Completed";
‏    document.getElementById("tawafStatus").innerHTML = "Counter reset. Click Add Round.";
‏    document.getElementById("tawafStatus").style.color = "#64748b";
}

‏function validateContactForm(event) {
‏    let name = document.getElementById("contactName").value;
‏    let email = document.getElementById("contactEmail").value;
    
‏    let emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
‏    if (!emailPattern.test(email)) {
‏        alert("Verification Error: Please provide a valid email structure.");
‏        event.preventDefault();
‏        return false;
    }
‏    return true;
}
