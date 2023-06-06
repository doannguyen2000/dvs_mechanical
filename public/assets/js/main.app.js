let logoutTimer;

function startLogoutTimer() {
    // Đặt thời gian timeout (theo giây) tại đây
    const timeoutSeconds = 600; // 10 phút

    // Hủy bỏ bất kỳ bộ đếm logout hiện tại nếu có
    clearTimeout(logoutTimer);

    // Bắt đầu đếm ngược đến đăng xuất tự động
    logoutTimer = setTimeout(logout, timeoutSeconds * 1000);
}

function logout() {
    $("#logout-form").submit();
}

// Bắt đầu đếm ngược khi có hoạt động từ người dùng
$(document).on("mousemove keydown scroll click", startLogoutTimer);

const toastBootstrap = bootstrap.Toast.getOrCreateInstance(
    document.getElementById("liveToast")
);
toastBootstrap.show();

// Delete item
function deleteItem(boxCheckboxId, checkBoxId, inputId, formId) {
    var checkboxes = $(
        "#" + boxCheckboxId + " input[type='checkbox']:not(#" + checkBoxId + ")"
    );
    var checkedValues = [];

    checkboxes.each(function () {
        if ($(this).prop("checked")) {
            checkedValues.push($(this).val());
        }
    });

    if (checkedValues.length != 0) {
        $("#" + inputId).val(checkedValues.join(","));
        $("#" + formId).submit();
    } else {
        alert("null values");
    }
}

// Toggle all checkboxes
function toggleAllCheckboxes(checkboxAllId, boxCheckboxId) {
    var checkboxAll = $("#" + checkboxAllId);
    var checkboxes = $(
        "#" +
            boxCheckboxId +
            " input[type='checkbox']:not(#" +
            checkboxAllId +
            ")"
    );

    checkboxes.prop("checked", checkboxAll.prop("checked"));
}

// Submit form action
function submitFormAction(form, action = "", method = "get") {
    form.action = action;
    form.setAttribute("method", method);
    form.submit();
}

// Submit form
function submitForm(
    formId,
    action = "",
    method = "",
    inputId = "",
    value = ""
) {
    var form = $("#" + formId);
    if (form.length === 0) {
        console.error("Form not found in the DOM");
        return;
    }
    if (action != "") form.attr("action", action);
    if (inputId != "") $("#" + inputId).val(value);
    if (method != "") form.attr("method", method);
    if (formId != "") form.submit();
}

// Submit form and set input values
function submitFormSetInputValues(formDeleteId, inputId, value) {
    $("#" + inputId).val(value);
    $("#" + formDeleteId).submit();
}

// Event handlers
$("#" + checkboxAllId).change(function () {
    toggleAllCheckboxes(checkboxAllId, boxCheckboxId);
});

$("#" + formId).submit(function (event) {
    event.preventDefault();
    submitForm(formId, action, method, inputId, value);
});

// Show image
function showImage(imgShow, inputImg) {
    var file = $("#" + inputImg)[0].files[0];
    var reader = new FileReader();

    reader.onload = function (event) {
        var imageUrl = event.target.result;
        $("#" + imgShow).attr("src", imageUrl);
    };
    reader.readAsDataURL(file);
}

// change HTML
function changeHTML(element, input) {
    element.html(input.val());
}

function getJsonFileAddress(
    provinceCode = "",
    districtCode = "",
    wardCode = "",
    fileJson
) {
    console.log(provinceCode + districtCode + wardCode);
    return new Promise(function (resolve, reject) {
        $.ajax({
            url: fileJson,
            dataType: "json",
            success: function (data) {
                var jsonData = data;
                if (provinceCode !== "") {
                    jsonData = $.grep(jsonData, function (item) {
                        return item.codename === provinceCode;
                    });
                    if (districtCode !== "") {
                        jsonData = $.grep(
                            jsonData[0].districts,
                            function (item) {
                                return item.codename === districtCode;
                            }
                        );
                        if (wardCode !== "") {
                            jsonData = $.grep(
                                jsonData[0].wards,
                                function (item) {
                                    return item.codename === wardCode;
                                }
                            );
                        } else {
                            jsonData = jsonData[0].wards;
                        }
                    } else {
                        jsonData = jsonData[0].districts;
                    }
                }
                resolve(jsonData);
            },
            error: function (xhr, status, error) {
                console.log("File JSON does not exist or cannot be accessed.");
                reject(error);
            },
        });
    });
}

function renderOption(selectID, data, dataSelected = "") {
    var selectElement = $("#" + selectID);

    selectElement.empty();

    data.forEach(function (item, index) {
        var option = $("<option></option>");
        if (dataSelected === "") {
            if (index === 0) option.prop("selected", true);
        } else {
            if (dataSelected.indexOf(item.codename) !== -1) {
                option.prop("selected", true);
                console.log(dataSelected);
            }
        }

        option.val(item.codename);
        option.text(item.name);

        selectElement.append(option);
    });
}
