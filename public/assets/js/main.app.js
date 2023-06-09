function startLogoutTimer(logoutTimer) {
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

$(document).ready(function () {
    let logoutTimer;
    $("#liveToast").toast("show");
    $(document).on(
        "mousemove keydown scroll click",
        startLogoutTimer(logoutTimer)
    );
});

// Delete item
function sentItemChecked(boxCheckboxId, checkBoxId, inputId, formId) {
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
            }
        }

        option.val(item.codename);
        option.text(item.name);

        selectElement.append(option);
    });
}

function showItemModel(elementId, action, method = "GET") {
    var spinnerHtml = `
    <div class="spinner-grow text-primary" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
    <div class="spinner-grow text-secondary" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
    <div class="spinner-grow text-success" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
    <div class="spinner-grow text-danger" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
    <div class="spinner-grow text-warning" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
    <div class="spinner-grow text-info" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
    <div class="spinner-grow text-light" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
    <div class="spinner-grow text-dark" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
  `;
    $("#" + elementId).addClass("hidden");
    $("#" + elementId).html(spinnerHtml);
    $("#" + elementId).addClass("visible");
    $.ajax({
        url: action,
        data: {
            show_modal: 1,
        },
        type: method,
        dataType: "html",
        success: function (response) {
            // alert(response);
            $("#" + elementId).addClass("hidden");
            $("#" + elementId).html(response);
            $("#" + elementId).addClass("visible");
        },
        error: function (xhr, status, error) {
            console.log(error);
        },
    });
}

//updateInputValue

function updateInputValue(inputId, value) {
    $("#" + inputId).val(value);
}

// Sự kiện khi checkbox 'all' được chọn/hủy chọn

function CheckCheckBoxAll(parentId) {
    var isChecked = $("#" + parentId + " .checkbox-all").prop("checked");
    $("#" + parentId + " .checkbox-item").prop("checked", isChecked);
}

// Sự kiện khi checkbox 'item' được chọn/hủy chọn
function CheckCheckBoxItem(parentId) {
    var allChecked =
        $("#" + parentId + " .checkbox-item:checked").length ===
        $("#" + parentId + " .checkbox-item").length;
    $("#" + parentId + " .checkbox-all").prop("checked", allChecked);
}

// Sự kiện lấy giá trị checkbox 'item' được chọn
function getSelectedCheckboxValues(parentId, inputId) {
    var selectedValues = [];
    $("#" + parentId + " .checkbox-item:checked").each(function () {
        selectedValues.push($(this).val());
    });
    $("#" + inputId).val(selectedValues.join(","));
}

// Sự kiện lấy show modal 'notification' được chọn
function showModal(modalId, message = null) {
    $("#" + modalId + " .modal-message").text(message);
    $("#" + modalId).modal("show");
}

//Hàm lấy mảng address theo chuỗi mã

function extractArrayFromString(str) {
    // Chia chuỗi thành mảng các phần tử dựa trên dấu gạch dưới và gạch ngang
    var arr = str.split("_").map(function (item) {
        // Chuyển đổi chữ hoa đầu tiên và các chữ cái còn lại thành chữ thường
        var words = item.split("-").map(function (word) {
            return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
        });
        // Ghép các từ lại thành chuỗi và trả về
        return words.join(" ");
    });

    // Đảo ngược mảng để có thứ tự đúng
    arr.reverse();

    return arr;
}
