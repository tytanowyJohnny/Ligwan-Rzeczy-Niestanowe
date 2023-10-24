$(document).ready(function () {


    /*

        UI Policies

    */

    $('#basic-addon-select-usterka').on('change', (e) => {

        let usterkaValue = $('#basic-addon-select-usterka').val();

        if(usterkaValue == '0') {
            $('#input-group-usterka-freetext').removeClass('invisible');
            $('#input-usterka-freetext').prop('required', true);
        } else {
            $('#input-group-usterka-freetext').addClass('invisible');
            $('#input-usterka-freetext').prop('required', false);
        } 
            

    });


    /*

        Modals

    */


    $('#image-modal-container').load('../includes/model/modals/image_modal.html');
    $('#assignment-modal-container').load('../includes/model/modals/assignment_modal.html');
    $('#work-completed-modal-container').load('../includes/model/modals/work_completed_modal.html');
    $('#work-rejected-modal-container').load('../includes/model/modals/work_rejected_modal.html');
    $('#history-modal-container').load('../includes/model/modals/history_modal.html');

    /* 
        Data Tables
                        */

    let mainTable = new DataTable('#mainTable', {
        "order": [[1, 'desc']],
        "language": {
            "lengthMenu": "Pokaż _MENU_ zgłoszeń na stronie",
            "zeroRecords": "Brak zgłoszeń",
            "info": "Strona _PAGE_ z _PAGES_",
            "infoEmpty": "Brak zgłoszeń",
            "infoFiltered": "(filtrowane z _MAX_ wszystkich zgłoszeń)",
            "search": "Wyszukaj"
        }
    });

    function getRowInfo(rowId) {

        return new Promise((resolve, reject) => {

            $.ajax({

                type: "GET",
                url: "../server/server_rows.php",
                data: ({ rowId: rowId }),
                success: (result) => {

                    var resultObj = JSON.parse(result);

                    let response = "<div class='row'>" +
                        "<div class='col-sm-4 text-center my-auto'>";
                    
                    // FIRST COLUMN

                    response += "<div class='btn-group-vertical'>";

                    if(resultObj[0]['damage_image_url'] == null)
                        response += "<button class='btn btn-primary' disabled>Wyświetl zdjęcie usterki</button>";
                    else
                        response += "<button class='btn btn-primary' onclick=\"showDamagePreview('" + resultObj[0]['damage_image_url'] + "')\">Wyświetl zdjęcie usterki</button>";

                    response += "<button class='btn btn-primary mt-1' onclick=\"showHistory('" + rowId + "')\">Wyświetl historię zgłoszenia</button>";

                    response += "</div>";
                    
                    response += "</div>" +
                                "<div class='col-sm-4 text-center my-auto'>"

                    // SECOND COLUMN
                    
                    response += "<p><b>Wykonawca</b>: " + resultObj[0]['wykonawca'] + "</p>";

                    if (resultObj[0]['status'] == 'new')
                        response += "<button class='btn btn-primary' onclick=\"showAssignmentModal('" + rowId + "')\">Przypisz</button>";

                    if (resultObj[0]['status'] == 'assigned' || resultObj[0]['status'] == 'rejected')
                        response += "<button class='btn btn-primary' onclick=\"startWork('" + rowId + "')\">Rozpocznij pracę</button>";

                    if (resultObj[0]['status'] == 'in_progress')
                        response += "<button class='btn btn-primary' onclick=\"completeWork('" + rowId + "')\">Zakończ pracę</button>";

                    if (resultObj[0]['status'] == 'completed' || resultObj[0]['status'] == 'verified'|| resultObj[0]['status'] == 'closed')
                        response += "<button class='btn btn-primary' onclick=\"showWorkPreview('" + resultObj[0]['work_image_url'] + "')\">Wyświetl zdjęcie wykonania</button>";

                    response +=
                        "</div>" +
                        "<div class='col-sm-4 text-center my-auto'>";

                    // THIRD COLUMN
                    
                    if (resultObj[0]['status'] == 'completed') {
                        response += "<div class='btn-group-vertical'>";
                        response += "<button class='btn btn-success mb-1' onclick=\"confirmWork('" + rowId + "')\">Zatwierdź</button>";
                        response += "<button class='btn btn-danger' onclick=\"rejectWork('" + rowId + "')\">Przekaż / Zwróć</button>";
                        response += "</div>";
                    }

                    if(resultObj[0]['status'] == 'rejected')
                        response += "<p class='text-break'><b>Powód</b>: " + resultObj[0]['rejected_reason'] + "</p>";

                    if (resultObj[0]['status'] == 'verified') {
                        response += "<button class='btn btn-danger' onclick=\"closeWorkOrder('" + rowId + "')\">Zamknij</button>";
                    }

                    // PROCESSING SCRIPT

                    response +=
                        "</div>" +
                        // "<script>" +
                        // "function showDamagePreview() { $('#image-preview').attr('src', '" + resultObj[0]['damage_image_url'] + "'); $('#image-modal').modal('show'); }" +
                        // "function showAssignmentModal() { $('#assignment_case_id').val('" + rowId + "'); $('#assign-modal').modal('show'); }" +
                        // "function startWork() { $.ajax({ type: 'GET', url: '../server/server_set_status.php', data: ({rowId: " + rowId + ", status: 'in_progress'}), success: " +
                        //     "(result) => { location.reload(); } }); };" +
                        // "function completeWork() { $('#work_completed_case_id').val('" + rowId + "'); $('#work-completed-modal').modal('show'); }" +
                        // "function showWorkPreview() { $('#image-preview').attr('src', '" + resultObj[0]['work_image_url'] + "'); $('#image-modal').modal('show'); }" +
                        // "function confirmWork() { $.ajax({ type: 'GET', url: '../server/server_set_status.php', data: ({rowId: " + rowId + ", status: 'verified'}), success: (result) => { location.reload(); } }); }" +
                        // "function rejectWork() { $('#work_rejected_case_id').val('" + rowId + "'); $('#work-rejected-modal').modal('show'); }" +
                        // "function closeWorkOrder() { $.ajax({ type: 'GET', url: '../server/server_set_status.php', data: ({rowId: " + rowId + ", status: 'closed'}), success: " +
                        //     "(result) => { location.reload(); } }); };" +
                        // "function showHistory() { " +
                        //     "$('#input-timestamp').html('" + resultObj[0]['input_timestamp'] + "'); " +
                        //     "$('#history-modal').modal('show'); }" +
                        // "</script>";

                    resolve(response);

                },
                error: (err) => {

                    reject('getRowInfo Error: ' + err);
                }

            })

        });

    }

    mainTable.on('click', 'tbody tr[id^="main-row"]', function (e) {

        var tr = $(this).closest('tr');
        var row = mainTable.row(tr);

        let classList = e.currentTarget.classList;

        if (classList.contains('selected')) {
            classList.remove('selected');
        }
        else {
            mainTable.rows('.selected').nodes().each((row) => row.classList.remove('selected'));
            classList.add('selected');
        }

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
        }
        else {
            // Close all rows before
            mainTable.rows().every(function () {
                var row = this;
                if (row.child.isShown()) {
                    row.child.hide();
                    $(this.node()).removeClass('shown');
                }
            });
            // Open this row
            // Wait for db
            getRowInfo(row.data()[0]).then((info) => {

                row.child(info).show();

            }).catch((err) => {

                alert(err);
            })
        }

    });


    // Login form validation
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        });


    // Population of drop-downs based on previously selected values
    $('#basic-addon-select-dzial').on('change', () => {

        $('#basic-addon-select-poziom')
            .find('option')
            .remove()
            .end()
            .append($('<option>', {
                value: '-',
                text: '-- Wybierz --'
            }));

        $('#basic-addon-select-pomieszczenie')
            .find('option')
            .remove()
            .end()
            .append($('<option>', {
                value: '-',
                text: '-- Wybierz --'
            }));

        $('#basic-addon-select-device')
            .find('option')
            .remove()
            .end()
            .append($('<option>', {
                value: '-',
                text: '-- Wybierz --'
            }));

        loadPoziomy($('#basic-addon-select-dzial option:selected').text());

    });

    $('#basic-addon-select-poziom').on('change', () => {

        $('#basic-addon-select-pomieszczenie')
            .find('option')
            .remove()
            .end()
            .append($('<option>', {
                value: '-',
                text: '-- Wybierz --'
            }));

        loadPomieszczenia($('#basic-addon-select-dzial option:selected').text(), $('#basic-addon-select-poziom').val());

    });

    $('#basic-addon-select-pomieszczenie').on('change', () => {

        $('#basic-addon-select-device')
            .find('option')
            .remove()
            .end()
            .append($('<option>', {
                value: '-',
                text: '-- Wybierz --'
            }));

        loadDevices($('#basic-addon-select-dzial').val(), $('#basic-addon-select-pomieszczenie').val());

    });


});

function loadDevices(dzial_code, pomieszczenie) {

    $.ajax({

        type: "GET",
        url: "../server/server_devices.php",
        // dataType: 'json',
        data: ({ dzial_code: dzial_code, pomieszczenie: pomieszczenie }),
        success: function (result) {

            if (result != '') {

                var resultObj = JSON.parse(result);

                resultObj.forEach((device) => {

                    $('#basic-addon-select-device').append($('<option>', {
                        value: device,
                        text: device
                    }));

                });
            }

        }

    })


}

function loadPomieszczenia(dzial, poziom) {

    $.ajax({

        type: "GET",
        url: "../server/server_pomieszczenia.php",
        // dataType: 'json',
        data: ({ dzial: dzial, poziom: poziom }),
        success: function (result) {

            if (result != '') {

                var resultObj = JSON.parse(result);

                resultObj.forEach((pomieszczenie) => {

                    $('#basic-addon-select-pomieszczenie').append($('<option>', {
                        value: pomieszczenie,
                        text: pomieszczenie
                    }));

                });

            }

        }

    })

}

function loadPoziomy(dzial) {

    $.ajax({

        type: "GET",
        url: "../server/server_poziomy.php",
        data: "dzial=" + dzial,
        success: function (result) {

            if (result != '') {

                var resultObj = JSON.parse(result);

                $('#basic-addon-select-poziom').prop('disabled', resultObj[0] == '-');
                if (resultObj[0] == '-')
                    loadPomieszczenia(dzial, resultObj[0]);

                resultObj.forEach((poziom) => {

                    $('#basic-addon-select-poziom').append($('<option>', {
                        value: poziom,
                        text: poziom
                    }));

                });

            }

        }

    })

}