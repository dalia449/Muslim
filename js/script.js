‏function welcomeMessage(){
‏    alert("Welcome To Muslim Website");
}
‏function validateLogin(){
‏    let idNumber = document.getElementById("idNumber").value;
‏    let password = document.getElementById("password").value;
‏    if(idNumber === "" || password === ""){
‏        alert("Please fill all fields");
‏        return false;
    }
‏    if(idNumber.length < 10){
‏        alert("ID Number must be at least 10 digits");
‏        return false;
    }
‏    if(password.length < 6){
‏        alert("Password must be at least 6 characters");
‏        return false;
    }
‏    alert("Login Successful");
‏    return true;
}
