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

function handleMobileInput(input) {
    // Fakt numbers, max 10 digits
    input.value = input.value.replace(/[^0-9]/g, '').slice(0, 10);
    if (input.value.length >= 3) {
        input.setAttribute('list', 'khojiMobiles');
    } else {
        input.removeAttribute('list');
    }
}

function addRow() {
    var table = document.getElementById("table");
    var row = table.insertRow();

    var timeValue = typeof defaultSessionTime !== 'undefined' ? defaultSessionTime : '';

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
            <input type="tel" name="mobile[]" inputmode="numeric" pattern="[0-9]*" maxlength="10"
                   placeholder="Mobile" autocomplete="off"
                   oninput="handleMobileInput(this)">
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
