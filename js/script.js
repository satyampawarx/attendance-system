function filterNameChars(input) {
    // Fakt alphabets allow kara Name field madhe
    input.value = input.value.replace(/[^a-zA-Z\s]/g, '');
}

function filterMobileChars(input) {
    // Fakt numbers, max 10 digits
    input.value = input.value.replace(/[^0-9]/g, '').slice(0, 10);
}

// ---------- Custom autocomplete (datalist peksha jast reliable mobile var) ----------

function showSuggestions(input, listId) {
    var box = input.parentElement.querySelector('.ac-list');
    if (!box) return;

    var val = input.value.trim().toLowerCase();
    box.innerHTML = '';

    if (val.length < 2) {
        box.style.display = 'none';
        return;
    }

    var datalist = document.getElementById(listId);
    if (!datalist) return;

    var matches = [];
    datalist.querySelectorAll('option').forEach(function (opt) {
        var v = opt.value;
        if (v.toLowerCase().indexOf(val) !== -1 && v.toLowerCase() !== val) {
            matches.push(v);
        }
    });

    matches = matches.slice(0, 6); // fakt top 6 dakhva

    if (matches.length === 0) {
        box.style.display = 'none';
        return;
    }

    matches.forEach(function (m) {
        var item = document.createElement('div');
        item.className = 'ac-item';
        item.textContent = m;
        item.onclick = function () {
            input.value = m;
            box.style.display = 'none';
            input.focus();
        };
        box.appendChild(item);
    });

    box.style.display = 'block';
}

function hideSuggestionsDelayed(input) {
    var box = input.parentElement.querySelector('.ac-list');
    // Thoda delay dila ahe jene karun item cha click event register houn jaईल
    setTimeout(function () {
        if (box) box.style.display = 'none';
    }, 150);
}

function handleNameInput(input) {
    filterNameChars(input);
    showSuggestions(input, 'khojiNames');
}

function handleBatchInput(input) {
    showSuggestions(input, 'khojiBatches');
}

function handleMobileInput(input) {
    filterMobileChars(input);
    showSuggestions(input, 'khojiMobiles');
}

function addRow() {
    var table = document.getElementById("table");
    var row = table.insertRow();

    var timeValue = typeof defaultSessionTime !== 'undefined' ? defaultSessionTime : '';

    row.innerHTML = `
        <td class="ac-wrap">
            <input type="text" name="name[]"
                   placeholder="Name (English)"
                   oninput="handleNameInput(this)"
                   onblur="hideSuggestionsDelayed(this)"
                   autocomplete="off" required>
            <div class="ac-list"></div>
        </td>
        <td class="ac-wrap">
            <input type="text" name="batch[]" placeholder="Batch"
                   oninput="handleBatchInput(this)"
                   onblur="hideSuggestionsDelayed(this)"
                   autocomplete="off">
            <div class="ac-list"></div>
        </td>
        <td class="ac-wrap">
            <input type="tel" name="mobile[]" inputmode="numeric" pattern="[0-9]*" maxlength="10"
                   placeholder="Mobile"
                   oninput="handleMobileInput(this)"
                   onblur="hideSuggestionsDelayed(this)"
                   autocomplete="off">
            <div class="ac-list"></div>
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

    genders.forEach(function (g) {
        if (g.value == "Male") male++;
        else female++;
    });

    document.getElementById("maleCount").innerText = male;
    document.getElementById("femaleCount").innerText = female;
    document.getElementById("totalCount").innerText = male + female;
}

function disableBtn(btn) {
    btn.disabled = true;
    btn.value = "Saving...";
    btn.form.submit();
}
