$(document).ready(function () {

    // $('.selectpicker').selectpicker();



    /*

        UI Policies

    */


    /*

        Modals

    */


    $('#image-modal-container').load('../includes/model/modals/image_modal.html');
    $('#assignment-modal-container').load('../includes/model/modals/assignment_modal.html');
    $('#work-completed-modal-container').load('../includes/model/modals/work_completed_modal.html');
    $('#work-rejected-modal-container').load('../includes/model/modals/work_rejected_modal.html');
    $('#history-modal-container').load('../includes/model/modals/history_modal.html');
    $('#arrival-modal-container').load('../includes/model/modals/arrival_modal.html');
    $('#change-arrival-modal-container').load('../includes/model/modals/change_arrival_modal.html');
    $('#work-acceptance-modal-container').load('../includes/model/modals/work_acceptance_modal.html');
    $('#request-denied-modal-container').load('../includes/model/modals/request_denied_modal.html');

    /*
        
        Select2
    
        */

    $('#basic-addon-select-podmiot').select2({
        theme: 'bootstrap-5'
    });
    
    $('#basic-addon-select-project').select2({
        theme: 'bootstrap-5'
    });

    $('#basic-addon-select-cost').select2({
        theme: 'bootstrap-5'
    });
    
    /* 
        Data Tables
                        */

    let mainTable = new DataTable('#mainTable', {
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "order": [[1, 'desc']],
        "language": {
            "lengthMenu": "Pokaż _MENU_ zgłoszeń na stronie",
            "zeroRecords": "Brak zgłoszeń",
            "info": "Strona _PAGE_ z _PAGES_",
            "infoEmpty": "Brak zgłoszeń",
            "infoFiltered": "(filtrowane z _MAX_ wszystkich zgłoszeń)",
            "search": "Wyszukaj"
        },
        "ajax": {
            url: "../server/server_compact_rows.php",
            type: "POST"
        },
        "columns": [
            { data: 'id' },
            { data: 'czas_wprowadzenie' },
            { data: 'createdByDisplayName' },
            { data: 'syntetyka' },
            { data: 'mpk' },
            { data: 'podmiotDisplayValue' },
            { data: 'cost' },
            { data: 'project' },
            { data: 'link' },
            { data: 'amount' },
            { data: 'amount_value'},
            { data: 'statusDisplayValue' }
        ]
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
                        "<div class='col-sm-3 text-center my-auto'>";

                    // FIRST COLUMN

                    response += "<div class='btn-group-vertical'>";

                    // alert(resultObj['attachment_uri']);

                    if (resultObj['attachment_uri'] == null)
                        response += "<button class='btn btn-primary' disabled>Wyświetl PDF</button>";
                    else
                        response += "<button class='btn btn-primary' onclick=\"window.open('" + resultObj['attachment_uri'] + "')\">Wyświetl PDF</button>";

                    response += "<button class='btn btn-primary mt-1' onclick=\"showHistory()\">Wyświetl historię</button>";

                    response += "</div>";

                    response += "</div>";

                    response += "<div class='col-sm-5 text-left my-auto'>"

                    // // SECOND COLUMN

                    response += "<div style='float: left;'>"

                    let mpkDisplayValue = (resultObj['mpkDisplayValue']) ? resultObj['mpkDisplayValue'] : '-';
                    let costDisplayValue = (resultObj['costDisplayValue']) ? resultObj['costDisplayValue'] : '-';
                    let syntetykaDisplayValue = (resultObj['syntetykaDisplayValue']) ? resultObj['syntetykaDisplayValue'] : '-';
                    let projectDisplayValue = (resultObj['projectDisplayValue']) ? resultObj['projectDisplayValue'] : '-';

                    // const createDate = new Date(resultObj['czas_wprowadzenie']);

                    let uniqueNumberValue = resultObj['sygnatura']; //resultObj['id'] + '/' + (createDate.getMonth() + 1) + '/' + createDate.getFullYear() + '/RN';

                    response += "<p><b>Sygnatura</b>: " + uniqueNumberValue + "</p>";
                    response += "<p><b>Dział</b>: " + resultObj['assignedDepartmentDisplayValue'] + "</p>";
                    response += "<p><b>Syntetyka</b>: " + syntetykaDisplayValue + "</p>";
                    response += "<p><b>MPK</b>: " + mpkDisplayValue + "</p>";
                    response += "<p><b>Koszt rodzajowy</b>: " + costDisplayValue + "</p>";
                    response += "<p><b>Projekt</b>: " + projectDisplayValue + "</p>";

                    response += "</div>";

                    response += "<div style='overflow: hidden; position: relative; left: 20px; word-wrap: break-word;'><p><b>Komentarz:</b></p>";
                    response += "<p>" + resultObj['comment'] + "</p>";

                    response += "</div>";

                    // if (resultObj[0]['status'] == 'new')
                    //     response += "<button class='btn btn-primary' onclick=\"showAssignmentModal('" + rowId + "')\">Przypisz</button>";

                    // if (resultObj[0]['status'] == 'assigned' || resultObj[0]['status'] == 'rejected')
                    //     response += "<button class='btn btn-primary' onclick=\"startWork('" + rowId + "')\">Rozpocznij pracę</button>";

                    // if (resultObj[0]['status'] == 'in_progress')
                    //     response += "<button class='btn btn-primary' onclick=\"completeWork('" + rowId + "')\">Zakończ pracę</button>";

                    // if (resultObj[0]['status'] == 'completed' || resultObj[0]['status'] == 'verified'|| resultObj[0]['status'] == 'closed')
                    //     response += "<button class='btn btn-primary' onclick=\"showWorkPreview('" + resultObj[0]['work_image_url'] + "')\">Wyświetl zdjęcie wykonania</button>";

                    response +=
                        "</div>" +
                        "<div class='col-sm-4 text-center my-auto'>" +
                        "<div class='btn-group-vertical'>";

                    // // THIRD COLUMN

                    // ACTIONS
                    resultObj['validTransitions'].forEach(($validTransition) => {

                        switch ($validTransition['target_status']) {

                            case '3': // AKCEPTACJA

                                if(resultObj['mpkDisplayValue'] && resultObj['costDisplayValue'])
                                    response += "<button class='btn btn-success m-1' onclick=\"changeState('" + $validTransition['target_status'] + "')\">" + $validTransition['action_name'] + "</button>";
                                else
                                    response += "<button class='btn btn-success m-1' onclick=\"acceptWork(" + (resultObj['mpkDisplayValue'] != false) + ", " + (resultObj['costDisplayValue'] != false) + ", " + (resultObj['syntetykaDisplayValue'] != false) + ", " + (resultObj['projectDisplayValue'] != false) + ")\">" + $validTransition['action_name'] + "</button>";
                                break;

                            case '4': // ZATWIERDZANIE
                                response += "<button class='btn btn-success m-1' onclick=\"changeState('" + $validTransition['target_status'] + "')\">" + $validTransition['action_name'] + "</button>";
                                break;

                            case '2': // ODRZUCENIE
                                response += "<button class='btn btn-danger m-1' onclick=\"rejectWork()\">" + $validTransition['action_name'] + "</button>";
                                break;

                            case '7': // ODMAWIANIE
                                response += "<button class='btn btn-danger m-1' onclick=\"denyRequest()\">" + $validTransition['action_name'] + "</button>";
                                break;

                            case '5': // ZAMAWIANIE
                                let isOrdered = resultObj['status'] == 5;

                                // alert(isOrdered);

                                if(isOrdered) 
                                    response += "<p><b>Przybliżona data dostawy</b>: " + resultObj['data_dostawy'] + "</p>";
    
                                response += "<button class='btn btn-success m-1' onclick=\"showArrivalModal(" + isOrdered + ")\">" + $validTransition['action_name'] + "</button>";

                                break;

                            case '1': // POPRAWIANIE
                                response += "<button class='btn btn-success m-1' onclick=\"processFromExisting()\">" + $validTransition['action_name'] + "</button>";
                                break;


                        }

                    });
                    

                    response += "</div>";

                    // }

                    // PROCESSING SCRIPT

                    response +=
                        "</div>" +
                        "<script>" +
                        "function post(path, parameters) { var form = $('<form></form>'); form.attr('method', 'post'); form.attr('action', path); $.each(parameters, function (key, value) { var field = $('<input></input>'); field.attr('type', 'hidden'); field.attr('name', key); field.attr('value', value); form.append(field); }); $(document.body).append(form); form.submit(); }" +
                        "function populateSelectOptions(selectId, optionsArr) { $.each(optionsArr, function(key, value) { $(selectId).append($('<option></option>').attr('value', value.value).text(value.label)); }); }" +
                        "function showArrivalModal(isOrdered) { if(isOrdered) { $('#change_arrival_case_id').val('" + rowId + "'); $('#change-arrival-modal').modal('show'); } else { $('#arrival_case_id').val('" + rowId + "'); $('#arrival-modal').modal('show'); } }" +
                        "function acceptWork(hasMPK, hasCost, hasSyntetyka, hasProject) { $.ajax({ type: 'GET', url: '../server/server_get_missing_details.php', success: (result) => { $('#accepted_case_id').val('" + rowId + "'); let resultObj = JSON.parse(result); populateSelectOptions('#modal-input-mpk', resultObj[0]); populateSelectOptions('#modal-input-cost', resultObj[1]); populateSelectOptions('#modal-input-syntetyka', resultObj[2]); populateSelectOptions('#modal-input-project', resultObj[3]); if(hasMPK) { $('#input-group-mpk').remove(); } if(hasCost) { $('#input-group-cost').remove(); } if(hasSyntetyka) { $('#input-group-syntetyka').remove(); } if(hasProject) { $('#input-group-project').remove(); } $('#work-acceptance-modal').modal('show'); } }); }" +
                        "function changeState(targetStatus) { $.ajax({ type: 'GET', url: '../server/server_set_status.php', data: ({rowId: " + rowId + ", status: targetStatus}), success: (result) => { new DataTable('#mainTable').ajax.reload(); } }); }" +
                        "function processFromExisting() { post('../index.php', {load_case_id: " + rowId + "}); }" +
                        "function rejectWork() { $('#work_rejected_case_id').val('" + rowId + "'); $('#work-rejected-modal').modal('show'); }" +
                        "function denyRequest() { $('#request_denied_case_id').val('" + rowId + "'); $('#request-denied-modal').modal('show'); }" +
                        "function showHistory() { $.ajax({ type: 'GET', url: '../server/server_get_history.php', data: ({rowId: " + rowId + "}), success: (result) => { $('#history-modal-body').html(result); $('#history-modal').modal('show'); } }); }" +
                        "</script>";

                    resolve(response);

                },
                error: (err) => {

                    reject('getRowInfo Error: ' + JSON.stringify(err));
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
            getRowInfo(row.data()['id']).then((info) => {

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