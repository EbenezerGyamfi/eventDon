import "./event-questions";
import "./event-ticketing";

$(document).ready(function () {
    // enable ticketing
    const enableTicketingBtn = $("#enable_ticketing");

    enableTicketingBtn.on("change", function (event) {
        const element = event.target;

        if (element.checked) {
            $(".ticketing-enabled input, .ticketing-enabled button").removeAttr(
                "disabled"
            );
        } else {
            $(".ticketing-enabled input, .ticketing-enabled button").attr(
                "disabled",
                "disabled"
            );
        }
    });

    // enable pre-registration
    let preRegistrationQuestionsCount = -1;
    let enablePreRequestionQuestions = $("#enable_preregistration_questions");
    let preRegistrationQuestionsWrapper = $(
        ".pre-registration-questions-wrapper"
    );
    $("#enable_preregistration").on("change", function (event) {
        const element = event.target;
        if (element.checked) {
            $(".preregistration-enabled").removeClass("d-none");
        } else {
            $(".preregistration-enabled").addClass("d-none");
            enablePreRequestionQuestions[0].checked = false;
            preRegistrationQuestionsCount = -1;
            $(".preregistration-container")
                .addClass("d-none")
                .find(".pre-registration-questions-wrapper")
                .html("");
        }
    });

    enablePreRequestionQuestions.on("change", function (event) {
        const element = event.target;

        if (element.checked) {
            $(".preregistration-container").removeClass("d-none");
        } else {
            preRegistrationQuestionsCount = -1;
            $(".preregistration-container")
                .addClass("d-none")
                .find(".pre-registration-questions-wrapper")
                .html("");
        }
    });

    // add questions only for pre-registration
    const addPreRegistrationQuestionBtn = $(
        "#add-preregistration-question-btn"
    );
    addPreRegistrationQuestionBtn.on("click", function (event) {
        event.preventDefault();
        preRegistrationQuestionsCount += 1;
        const html = `
        <div class="form-row" id="preregistration-questions-${preRegistrationQuestionsCount}">
            <div class="col-sm-5 form-group">
                <label for="preregistraion-title-${preRegistrationQuestionsCount}">Title</label>
                <input class="form-control py-3" name="pre_registration_questions[${preRegistrationQuestionsCount}][title]"
                    id="preregistration-title-${preRegistrationQuestionsCount}" placeholder="Enter question title" required/>
                <span class="invalid-feedback">error</span>
            </div>

            <div class="col-sm-5 form-group">
                <label for="preregistration-question-${preRegistrationQuestionsCount}">Question</label>
                <input name="pre_registration_questions[${preRegistrationQuestionsCount}][question]" id="preregistration-questions-${preRegistrationQuestionsCount}" class="form-control py-3"
                    placeholder="Enter question" required/>
                <span class="invalid-feedback">error</span>
            </div>

            <div class="col-sm-1 form-group question-order">
                <label for="order">Order</label>
                <input type="number" class="form-control py-3" name="pre_registration_questions[${preRegistrationQuestionsCount}][order]" value="${preRegistrationQuestionsCount + 1
            }" required>
                <span class="invalid-feedback">error</span>
            </div>

            <div class="col-sm-1 text-center align-self-end">
                <button class="btn btn-danger" type="button" data-item-id="${preRegistrationQuestionsCount}">Remove</button>
            </div>

        </div>
        `;
        preRegistrationQuestionsWrapper.append(html);
    });

    // create a question for an event
    const addQuestionBtn = $("#add-question-btn");
    let numberOfQuestions = 0;

    addQuestionBtn.on("click", function (event) {
        event.preventDefault();
        numberOfQuestions += 1;
        //     const html = `
        //     <div class="form-row border p-2 mt-5" id="questions-${numberOfQuestions}">
        //         <div class="col-sm-3 form-group">
        //             <label for="title-${numberOfQuestions}">Title</label>
        //             <input class="form-control py-3" name="questions[${numberOfQuestions}][title]"
        //                 id="title-${numberOfQuestions}" placeholder="Enter question title" required/>
        //             <span class="invalid-feedback">error</span>
        //         </div>

        //         <div class="col-sm-4 form-group">
        //             <label for="question-${numberOfQuestions}">Question</label>
        //             <input name="questions[${numberOfQuestions}][question]" id="${numberOfQuestions}" class="form-control py-3"
        //                 placeholder="Enter question" required/>
        //             <span class="invalid-feedback">error</span>
        //         </div>

        //  <div class="col-sm-2 form-group">
        //                         <label for="type">Select Event Type</label>
        //                         <select name="type" class="form-control py-3" id="type"  onchange="showOptions(this.value,'options-text-${numberOfQuestions}')">
        //                             <option value="text">Text</option>
        //                             <option value="options">Options</option>
        //                         </select>
        //                         <span class="invalid-feedback">error</span>
        //                     </div>

        //         <div class="col-sm-1 form-group question-order">
        //             <label for="order">Order</label>
        //             <input type="number" class="form-control py-3" name="questions[${numberOfQuestions}][order]" value="${
        //         numberOfQuestions + 1
        //     }" required>
        //             <span class="invalid-feedback">error</span>
        //         </div>

        //         <div class="col-sm-1 text-center align-self-end">
        //             <button class="btn btn-danger" type="button" data-item-id="${numberOfQuestions}">Remove</button>
        //         </div>

        //             <div class="row p-2 d-none" id="options-text-${numberOfQuestions}">

        //                         <div class="col-sm-6 form-group pt-3">
        //                             <label for="question-0">Enter Options Text</label>
        //                             <input name="questions[0][question]" id="question-0" class="form-control py-3"
        //                                 placeholder="Enter question" />
        //                             <span class="invalid-feedback">error</span>
        //                         </div>
        //                         <div class="col-sm-6 form-group pt-3">
        //                             <label for="question-0">Enter Options Text</label>
        //                             <input name="questions[0][question]" id="question-0" class="form-control py-3"
        //                                 placeholder="Enter question" />
        //                             <span class="invalid-feedback">error</span>
        //                         </div>
        //                         <div class="col-sm-6 form-group pt-3">
        //                             <label for="question-0">Enter Options Text</label>
        //                             <input name="questions[0][question]" id="question-0" class="form-control py-3"
        //                                 placeholder="Enter question" />
        //                             <span class="invalid-feedback">error</span>
        //                         </div>
        //                         <div class="col-sm-6 form-group pt-3">
        //                             <label for="question-0">Enter Options Text</label>
        //                             <input name="questions[0][question]" id="question-0" class="form-control py-3"
        //                                 placeholder="Enter question" />
        //                             <span class="invalid-feedback">error</span>
        //                         </div>
        //                     </div>

        //     </div>
        //     `;
        const html = `
        <div class="form-row" id="questions-${numberOfQuestions}">
            <div class="col-sm-5 form-group">
                <label for="title-${numberOfQuestions}">Title</label>
                <input class="form-control py-3" name="questions[${numberOfQuestions}][title]"
                    id="title-${numberOfQuestions}" placeholder="Enter question title" required/>
                <span class="invalid-feedback">error</span>
            </div>
            <div class="col-sm-5 form-group">
                <label for="question-${numberOfQuestions}">Question</label>
                <input name="questions[${numberOfQuestions}][question]" id="${numberOfQuestions}" class="form-control py-3"
                    placeholder="Enter question" required/>
                <span class="invalid-feedback">error</span>
            </div>
            <div class="col-sm-1 form-group question-order">
                <label for="order">Order</label>
                <input type="number" class="form-control py-3" name="questions[${numberOfQuestions}][order]" value="${numberOfQuestions + 1
            }" required>
                <span class="invalid-feedback">error</span>
            </div>
            <div class="col-sm-1 text-center align-self-end">
                <button class="btn btn-danger" type="button" data-item-id="${numberOfQuestions}">Remove</button>
            </div>
        </div>
        `;
        $(".questions-wrapper").append(html);
    });

    // enable or disable the `Name` question
    const enableNameQuestionBtn = $("#enable-name-question");
    enableNameQuestionBtn.on("click", (event) => {
        let isDisabled =
            enableNameQuestionBtn.attr("data-item-enabled") !== "true";
        if (isDisabled) {
            $("#questions-0").find("input").removeAttr("disabled", "disabled");
            enableNameQuestionBtn.attr("data-item-enabled", "true");
            enableNameQuestionBtn.text("Disable");
        } else {
            $("#questions-0").find("input").attr("disabled", "disabled");
            enableNameQuestionBtn.attr("data-item-enabled", "false");
            enableNameQuestionBtn.text("Enable");
        }
    });

    // remove a question
    const questionWrapper = $(".questions-wrapper");

    questionWrapper.on("click", (event) => {
        const element = $(event.target);
        if (element.hasClass("btn")) {
            $(`#questions-${element.attr("data-item-id")}`).remove();
            numberOfQuestions -= 1;

            let questions = Array.from(questionWrapper.children());

            questions.shift(); // remove the `Name` question

            questions.forEach((question, index) => {
                // we increase the index by 2 because the `Name` question would be the first
                $(question)
                    .find(".question-order input")
                    .val(index + 2);
            });
        }
    });

    // remove pre-registration questions
    preRegistrationQuestionsWrapper.on("click", function (event) {
        const element = $(event.target);
        if (element.hasClass("btn")) {
            $(
                `#preregistration-questions-${element.attr("data-item-id")}`
            ).remove();
            preRegistrationQuestionsCount -= 1;

            if (preRegistrationQuestionsCount > 0) {
                preRegistrationQuestionsWrapper
                    .children()
                    .each(function (index, question) {
                        $(question)
                            .find(".question-order input")
                            .val(index + 1);
                    });
            }
        }
    });

    // program-lineup input
    $("#program_lineup").on("change", function (event) {
        let files = event.target.files;

        if (files.length) {
            $(".file-label").html(`File : ${files[0].name}`);
        }
    });

    // create an event
    const createEventForm = $("#create-event-form");
    createEventForm.on("submit", function (event) {
        event.preventDefault();

        $("#save-btn").attr("disabled", "disabled");
        $(".loader").removeClass("d-none");
        $(".is-invalid").removeClass("is-invalid");

        $.ajax({
            url: route("events.store"),
            method: "POST",
            cache: false,
            contentType: false,
            processData: false,
            data: new FormData(createEventForm[0]),
        })
            .done(function (data) {
                if (data.message) {
                    Swal.fire({
                        title: data.message,
                        icon: "success",
                        toast: true,
                        position: "top-end",
                        showCloseButton: true,
                        showConfirmButton: false,
                    });
                }

                window.location.href = route("events.index");
            })
            .fail(function (xhr) {
                let response = xhr.responseJSON;

                if (response.errors) {
                    displayErrors(response.errors);
                }

                if (response.error) {
                    Swal.fire({
                        title: "An error occurred",
                        text: response.error,
                        icon: "error",
                        toast: true,
                        position: "top-end",
                        showCloseButton: true,
                        showConfirmButton: false,
                    });
                }
            })
            .always(function () {
                $("#save-btn").removeAttr("disabled");
                $(".loader").addClass("d-none");
            });
    });

    const errorToast = (message) => {
        Swal.fire({
            title: message,
            icon: "error",
            toast: true,
            position: "top-end",
            showCloseButton: true,
            showConfirmButton: false,
        });
    };

    const getFieldSelector = (field) => {
        let selector = "";
        let fieldDetails = [];
        let fieldName = "";
        let fieldId = "";

        if (field.indexOf("questions") > -1) {
            if (field === "questions") {
                errorToast("Please add at least one question to your event");
                return;
            }

            if (field === "pre_registration_questions") {
                errorToast("Please add at least one pre-registration question");
                return;
            }

            fieldDetails = field.split(".");
            fieldName = fieldDetails[2];
            fieldId = fieldDetails[1];

            if (field.indexOf("pre_registration") > -1) {
                selector = `[name='pre_registration_questions[${fieldId}][${fieldName}]']`;
            } else {
                selector = `[name='questions[${fieldId}][${fieldName}]']`;
            }
        } else if (field.indexOf("selected_users.") > -1) {
            selector = ".select2";
        } else if (field.indexOf("tickets") > -1) {
            if (field === "tickets") {
                errorToast("Please add at least one ticket type");
                return;
            }

            fieldDetails = field.split(".");
            fieldName = fieldDetails[2];
            fieldId = fieldDetails[1];

            selector = `[name='tickets[${fieldId}][${fieldName}]']`;
        } else {
            selector = `[name='${field}']`;
        }

        return selector;
    };

    const displayErrors = (errors) => {
        let fields = Object.keys(errors);

        fields.forEach((field) => {
            let input = null;
            let selector = getFieldSelector(field);
            input = createEventForm.find(selector);
            input.addClass("is-invalid");
            input.next().html(errors[field][0]);
        });
    };

    // toggle event details tabs
    $(".events-details > ul.nav a.nav-link").each(function (index, element) {
        const url = window.location.href.split("?")[0];
        if (url === $(element).attr("href")) {
            $(element).addClass("active");
        }
    });

    $('#enable_guest_list').on('change', function(event){
        const element = event.target;

        if (element.checked) {
            $('.file-uploader').removeClass('disabled');
            $(".guest-list-enabled input, .guest-list-enabled button").prop("disabled", false);
            $('.guest-list-enabled a').removeAttr('disabled');
        } else {
            $('.file-uploader').addClass('disabled');
            $(".guest-list-enabled input, .guest-list-enabled button").prop("disabled", true);
            $('.guest-list-enabled a').attr('disabled', 'disabled');
        }
    });

    $('#enable_invitation_messages').on('change', function(event){
        const element = event.target;

        if (element.checked) {
            $(".invitation-messages-enabled input, .invitation-messages-enabled textarea, .invitation-messages-enabled button").removeAttr("disabled");
        } else {
            $(".invitation-messages-enabled input, .invitation-messages-enabled textarea, .invitation-messages-enabled button").attr("disabled", "disabled");
        }
    });

    $('#assign_table_numbers').on('change', function(event){
        const element = event.target;

        if (element.checked) {
            $(".assign-table-numbers-enabled input, .assign-table-numbers-enabled textarea, .assign-table-numbers-enabled button").removeAttr("disabled");
        } else {
            $(".assign-table-numbers-enabled input, .assign-table-numbers-enabled textarea, .assign-table-numbers-enabled button").attr("disabled", "disabled");
        }
    });

    $(document).on('change', '#guest-list-uploader', function(e){
        let file = this.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function(e) {
                let data = new Uint8Array(e.target.result);
                let workbook = XLSX.read(data, {type: 'array'});
                let worksheet = workbook.Sheets[workbook.SheetNames[0]];
                let jsonData = XLSX.utils.sheet_to_json(worksheet, {header: 1});
                renderPreview(jsonData);
            };
            reader.readAsArrayBuffer(file);
        }
    });

    function renderPreview(data) {
        let previewContainer = $('.guest-list-preview-container .table tbody');
        previewContainer.empty();

        // let table = $('<table>', {class: "table table-sm table-hover table-striped table-bordered"});
        // let headers = data[0];
        // let thead = $('<thead>', {class: "thead-dark"})
        // let tableHeaders = $('<tr>');
        // tableHeaders.append($('<th>').text('S/N'));
        // for (let i = 0; i < headers.length; i++) {
        //     tableHeaders.append($('<th>').text(headers[i]));
        // }
        // thead.append(tableHeaders)
        // table.append(thead);

        let tbody = $('<tbody>');
        let table = $.fn.dataTable.tables( { api: true } );
        table.clear().draw();

        for (let j = 1; j < data.length; j++) {
            let tableRow = $('<tr scope="row">');
            tableRow.append($('<th>').text(j));
            let rowData = data[j];
            for (let k = 0; k < rowData.length; k++) {
                tableRow.append($('<td>').text(rowData[k]));
            }
            table.row.add(tableRow[0]).draw();
            // tbody.append(tableRow);
        }
        // previewContainer.html(tbody);
        $('#guest-list-preview-modal').modal('show');
    }
});
