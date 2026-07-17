function handleSuggestion(input, listId) {
    // Jar Name field asel, tar fakt alphabets allow kara
    if(listId === 'khojiNames') {
        input.value = input.value.replace(/[^a-zA-Z\s]/g, '');
    }

    // Jar 3 kiwa tyahun jast letters astil, tarach datalist attach kara
    if (input.value.length >= 3) {
        input.setAttribute('list', listId);
    } else {
        // 3 peksha kami astil tar suggestions kadhun taka
        input.removeAttribute('list');
    }
}


function addRow() {
    var table = document.getElementById("table");
    var row = table.insertRow();
    
    var timeValue = typeof defaultSessionTime !== 'undefined' ? defaultSessionTime : '';

    // Fakt name sathi oninput function thevla ahe, baki donhi la direct 'list' attribute dila ahe
    row.innerHTML = `
        <td>
            <input type="text" name="name[]" 
                   placeholder="Name (English)" 
                   oninput="handleSuggestion(this, 'khojiNames')" autocomplete="off" required>
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