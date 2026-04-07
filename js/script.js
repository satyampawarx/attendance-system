function addRow() {
    var table = document.getElementById("table");
    var row = table.insertRow();

    row.innerHTML = `
        <td><input name="name[]"></td>
        <td><input name="batch[]"></td>
        <td><input name="mobile[]"></td>
        <td><input name="time[]"></td>
        <td>
            <select name="gender[]" onchange="countGender()">
                <option>Male</option>
                <option>Female</option>
            </select>
        </td>
    `;
}

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