//components
//table
function deleteItem(boxCheckboxId, checkBoxId, inputId, formId) {
    inputFormDelete = document.getElementById(inputId);
    formDelete = document.getElementById(formId);
    var checkboxes = document.querySelectorAll(
        "#" + boxCheckboxId + " input[type='checkbox']:not(#" + checkBoxId + ")"
    );

    var checkedValues = [];

    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            checkedValues.push(checkboxes[i].value);
        }
    }

    if (checkedValues.length != 0) {
        inputFormDelete.value = checkedValues.join(",");
        formDelete.submit();
    } else {
        alert("null values");
    }
}
//--table
//

function toggleAllCheckboxes(checkboxAllId, boxCheckboxId) {
    var checkboxAll = document.getElementById(checkboxAllId);
    var checkboxes = document.querySelectorAll(
        "#" +
            boxCheckboxId +
            " input[type='checkbox']:not(#" +
            checkboxAllId +
            ")"
    );
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = checkboxAll.checked;
    }
}

function submitFormAction(form, action, method = "get") {
    form.action = action;
    form.setAttribute("method", method);
    form.submit();
}
