// 1. Sagle names save thevnyasathi ek empty array banvla
let allKhojiNames = [];

// Page load zalyavar PHP ne taklele sagle names array madhe gheu aani list rikami karu
document.addEventListener("DOMContentLoaded", function() {
    let datalist = document.getElementById("khojiNames");
    if(datalist) {
        for (let i = 0; i < datalist.options.length; i++) {
            allKhojiNames.push(datalist.options[i].value);
        }
        datalist.innerHTML = ""; // List rikami kela, mhanje click kelyavar default blank disel
    }
});

// 2. Navin Function (Fakt 3 letters nantar suggestions add karnyasaathi)
function filterNames(input) {
    // Special characters restrict karne
    input.value = input.value.replace(/[^a-zA-Z\s]/g, '');
    
    let datalist = document.getElementById("khojiNames");
    datalist.innerHTML = ""; // Junya suggestions clear karne
    
    let typed = input.value.toLowerCase();
    
    // Jar 3 kiwa jast letters astil tarach matching options add karne
    if (typed.length >= 3) {
        allKhojiNames.forEach(function(name) {
            if(name.toLowerCase().includes(typed)) {
                let option = document.createElement("option");
                option.value = name;
                datalist.appendChild(option);
            }
        });
    }
}

// 3. addRow() madhye Name input la fix list="khojiNames" dyaycha aani oninput function change karyacha
function addRow() {
    var table = document.getElementById("table");
    var row = table.insertRow();
    
    var timeValue = typeof defaultSessionTime !== 'undefined' ? defaultSessionTime : '';

    row.innerHTML = `
        <td>
            <input type="text" name="name[]" list="khojiNames" 
                   placeholder="Name (English)" 
                   oninput="filterNames(this)" autocomplete="off" required>
        </td>
        <td>
            <input type="text" name="batch[]" list="khojiBatches" placeholder="Batch" autocomplete="off">
        </td>
        <td>
            <input type="text" name="mobile[]" list="khojiMobiles" placeholder="Mobile" autocomplete="off">
        </td>
        <td><input type="text" name="time[]" value="${timeValue}"></td>
        <td>
            <select name="gender[]" onchange="countGender()">
                <option>Male</option>
                <option>Female</option>
            </select>
        </td>
    `;
}

// (Tujhe countGender aani disableBtn functions jasache tase thev)
function countGender() {
    var genders = document.querySelectorAll("select[name='gender[]']");
    var male = 0;
    var female = 0;

    genders.forEach(function(g){
        if(g.value == "Male") male++;
        else female++;
    });

    document.getElementById("maleCount").innerText = male;
    document.getElementById("femaleCount").innerText = female;
    document.getElementById("totalCount").innerText = male + female;
}

function disableBtn(btn){
    btn.disabled = true;
    btn.value = "Saving...";
    btn.form.submit();
}