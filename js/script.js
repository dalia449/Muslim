/* LOADER */

window.onload = ()=>{

    let loader =
    document.getElementById("loader");

    if(loader){
        loader.style.display = "none";
    }

};

/* LOGIN VALIDATION */

document.getElementById("loginForm")
?.addEventListener("submit", function(e){

    let identity =
    document.getElementById("identity").value;

    if(identity.length < 10){

        e.preventDefault();

        document.getElementById("loginError")
        .innerText = "رقم الهوية غير صحيح";

    }

});

/* DARK MODE */

function toggleTheme(){

    document.body.classList.toggle("dark");

}

/* QR */

let scanned = false;

function scanPermit(){

    let status =
    document.getElementById("permitStatus");

    if(scanned == false){

        status.innerHTML =
‎        "✅ تم قبول التصريح";

        status.style.color = "green";

        scanned = true;

    }else{

        status.innerHTML =
‎        "❌ التصريح مستخدم مسبقاً";

        status.style.color = "red";

    }

}

/* CHART */

const chartCanvas =
document.getElementById("myChart");

if(chartCanvas){

new Chart(chartCanvas, {

type:'bar',

data:{

labels:[
‎'يناير',
‎'فبراير',
‎'مارس',
‎'أبريل'
],

datasets:[{

label:'عدد الحجاج',

data:[120,190,300,500]

}]

}

});

}
