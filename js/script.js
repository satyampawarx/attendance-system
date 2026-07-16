function addRow() {
    var table = document.getElementById("table");
    var row = table.insertRow();
    
    // PHP kadun aalela time
    var timeValue = typeof defaultSessionTime !== 'undefined' ? defaultSessionTime : '';

    // name input madhe placeholder update kela ahe ani oninput validation lavla ahe
    row.innerHTML = `
        <td>
            <input type="text" name="name[]" list="khojiNames" autocomplete="off" 
                   placeholder="Name (English)" 
                   oninput="this.value = this.value.replace(/[^a-zA-Z\\s]/g, '')" required>
        </td>
        <td><input type="text" name="batch[]" list="khojiBatches" autocomplete="off" placeholder="Batch"></td>
        <td><input type="text" name="mobile[]" list="khojiMobiles" autocomplete="off" placeholder="Mobile"></td>
        <td><input type="text" name="time[]" value="${timeValue}"></td>
        <td>
            <select name="gender[]" onchange="countGender()">
                <option>Male</option>
                <option>Female</option>
            </select>
        </td>
    `;
}

// Baki khalcha countGender() aani disableBtn() function same rahil...

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