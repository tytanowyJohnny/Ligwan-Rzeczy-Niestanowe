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

                    var accessType = $('#access_type').text();

                    // alert(accessType);


                    // let response = "";
                    
                    // response += `<tr id='main-row-${resultObj['id']}'>`;
                    // response +=  `<th scope='col'>${resultObj['id']}</th>`;
                    // response +=  `<td>${resultObj['czas_wprowadzenie']}</td>`;
                    // response +=  `<td>${resultObj['czas_wprowadzenie']}</td>`;
                    // response +=  `<td>${resultObj['czas_wprowadzenie']}</td>`;
                    // response +=  `<td>${resultObj['czas_wprowadzenie']}</td>`;
                    // response +=  `<td>${resultObj['czas_wprowadzenie']}</td>`;
                    // response +=  `<td>${resultObj['czas_wprowadzenie']}</td>`;
                    // response +=  `<td>${resultObj['czas_wprowadzenie']}</td>`;
                    // response +=  `<td>${resultObj['czas_wprowadzenie']}</td>`;
                    // response +=  `<td>${resultObj['czas_wprowadzenie']}</td>`;
                    // response +=  `<td>${resultObj['czas_wprowadzenie']}</td>`;
                    // response +=  `</tr>`;

                    // let response = "<div class='row'><div class='col-sm-12 text-center my-auto'>Szczegółowe informacje</div></div>";
                    
                    let response = "<div class='row'>" +
                        "<div class='col-sm-4 text-center my-auto'>";
                    
                    // FIRST COLUMN


                    response += "<span><b>SZCZEGÓŁOWE INFORMACJE:</b></span>";

                    response += "</div>";
                    
                    response += "<div class='col-sm-4 text-left my-auto'>"

                    // // SECOND COLUMN
                    
                    response += "<div style='float: left;'>"

                    response += "<p><b>Zamówienie</b>: " + resultObj['orderDisplayValue'] + "</p>";
                    response += "<p><b>Syntetyka</b>: " + resultObj['syntetykaDisplayValue'] + "</p>";
                    response += "<p><b>MPK</b>: " + resultObj['mpkDisplayValue'] + "</p>";
                    response += "<p><b>Koszt rodzajowy</b>: " + resultObj['costDisplayValue'] + "</p>";
                    response += "<p><b>Projekt</b>: " + resultObj['projectDisplayValue'] + "</p>";

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
                        "<div class='col-sm-4 text-center my-auto'>";

                    // // THIRD COLUMN

                        if (resultObj['status'] == 1 && accessType == 'ZAT')
                            response += "<button class='btn btn-success' onclick=\"confirmWork('" + rowId + "')\">Zatwierdź</button>";

                        if (resultObj['status'] == 2) {
                            if(accessType == 'ZAM')
                                response += "<p><button class='btn btn-success' onclick=\"showArrivalModal('" + rowId + "')\">Zamów</button></p>";
                            response += "<p><b>Zatwierdził:</b>: " + resultObj['zatwierdzajacyDisplayName'] + "</p>";
                            response += "<p><b>Czas zatwierdzenia:</b>: " + resultObj['czas_zatwierdzenia'] + "</p>";
                        }

                        if (resultObj['status'] == 3) {
                            response += "<p><b>Zamówił:</b>: " + resultObj['zamawiajacyDisplayName'] + "</p>";
                            response += "<p><b>Czas zamówienia:</b>: " + resultObj['czas_zamowienia'] + "</p>";
                            response += "<p><b>Przybliżona data dostawy:</b>: " + resultObj['data_dostawy'] + "</p>";
                        }
                        
                    
                    // if (resultObj[0]['status'] == 'completed') {
                    //     response += "<div class='btn-group-vertical'>";
                    //     response += "<button class='btn btn-success mb-1' onclick=\"confirmWork('" + rowId + "')\">Zatwierdź</button>";
                    //     response += "<button class='btn btn-danger' onclick=\"rejectWork('" + rowId + "')\">Przekaż / Zwróć</button>";
                    //     response += "</div>";
                    // }

                    // if(resultObj[0]['status'] == 'rejected')
                    //     response += "<p class='text-break'><b>Powód</b>: " + resultObj[0]['rejected_reason'] + "</p>";

                    // if (resultObj[0]['status'] == 'verified') {
                    //     response += "<button class='btn btn-danger' onclick=\"closeWorkOrder('" + rowId + "')\">Zamknij</button>";
                    // }

                    // PROCESSING SCRIPT

                    let confirmStatus = 2; // NIE DZIAŁA ? CZEMU ?

                    response +=
                        "</div>" +
                        "<script>" +
                        // "function showDamagePreview() { $('#image-preview').attr('src', '" + resultObj[0]['damage_image_url'] + "'); $('#image-modal').modal('show'); }" +
                        "function showArrivalModal() { $('#arrival_case_id').val('" + rowId + "'); $('#arrival-modal').modal('show'); }" +
                        // "function startWork() { $.ajax({ type: 'GET', url: '../server/server_set_status.php', data: ({rowId: " + rowId + ", status: 'in_progress'}), success: " +
                        //     "(result) => { location.reload(); } }); };" +
                        // "function completeWork() { $('#work_completed_case_id').val('" + rowId + "'); $('#work-completed-modal').modal('show'); }" +
                        // "function showWorkPreview() { $('#image-preview').attr('src', '" + resultObj[0]['work_image_url'] + "'); $('#image-modal').modal('show'); }" +
                        "function confirmWork() { $.ajax({ type: 'GET', url: '../server/server_set_status.php', data: ({rowId: " + rowId + ", status: " + confirmStatus + "}), success: (result) => { location.reload(); } }); }" +
                        // "function rejectWork() { $('#work_rejected_case_id').val('" + rowId + "'); $('#work-rejected-modal').modal('show'); }" +
                        // "function closeWorkOrder() { $.ajax({ type: 'GET', url: '../server/server_set_status.php', data: ({rowId: " + rowId + ", status: 'closed'}), success: " +
                        //     "(result) => { location.reload(); } }); };" +
                        // "function showHistory() { " +
                        //     "$('#input-timestamp').html('" + resultObj[0]['input_timestamp'] + "'); " +
                        //     "$('#history-modal').modal('show'); }" +
                        "</script>";

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