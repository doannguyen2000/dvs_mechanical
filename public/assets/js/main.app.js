function toggleAllCheckboxes(checkboxALl, checkboxes) {
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = checkboxALl.checked;
    }
}

function deleteItem(tbody, formSubmit, input, inputName, action, method) {
    var checkboxes = tbody.querySelectorAll('input[type="checkbox"]');
    var values = [];
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            values.push(checkboxes[i].value);
        }
    }

    if (values.length != 0) {
        input.value = values.join(",");
        input.name = inputName;
        submitFormAction(formSubmit, action, method);
    } else {
        alert("null values");
    }
}

function paginateItem(form, paginateName, inputForm, select, action, method) {
    inputForm.value = select.value;
    inputForm.name = paginateName;

    submitFormAction(form, action, method);
}

function submitFormAction(form, action, method = "get") {
    form.action = action;
    form.setAttribute("method", method);
    form.submit();
}

function getSelectValues(selects, input) {
    var selectValues = [];
    selects.forEach(function (select) {
        var value = select.value;
        if (!selectValues.includes(value)) {
            selectValues.push(value);
        }
    });
    input.value = selectValues.join(",");
}

function deleteTrTable() {
    var row = event.target.closest('tr');
    row.remove();
}

function showIcon(box, icon) {
    box.innerHTML = icon.value;
}
