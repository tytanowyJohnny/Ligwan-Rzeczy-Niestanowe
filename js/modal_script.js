function showDamagePreview($imagePreviewURL) {
    $('#image-preview').attr('src', $imagePreviewURL);
    $('#image-modal').modal('show');
}

function showAssignmentModal($rowId) { $('#assignment_case_id').val($rowId); $('#assign-modal').modal('show'); }

function startWork($rowId) {
    $.ajax({
        type: 'GET', url: '../server/server_set_status.php', data: ({ rowId: $rowId, status: 'in_progress' }), success:
            (result) => { location.reload(); }
    });
}

function completeWork($rowId) { $('#work_completed_case_id').val($rowId); $('#work-completed-modal').modal('show'); }

function showWorkPreview($imagePreviewURL) { $('#image-preview').attr('src', $imagePreviewURL); $('#image-modal').modal('show'); }

function confirmWork($rowId) { $.ajax({ type: 'GET', url: '../server/server_set_status.php', data: ({ rowId: $rowId, status: 'verified' }), success: (result) => { location.reload(); } }); }

function rejectWork($rowId) { $('#work_rejected_case_id').val($rowId); $('#work-rejected-modal').modal('show'); }

function closeWorkOrder($rowId) { $.ajax({ type: 'GET', url: '../server/server_set_status.php', data: ({ rowId: $rowId, status: 'closed' }), success: (result) => { location.reload(); } }); }

function showHistory($rowId) {
    $.ajax({
        type: 'GET', url: '../server/server_get_history.php', data: ({ rowId: $rowId }), success: (result) => {
            
            let resultObj = JSON.parse(result);


            $('#input-timestamp').html(resultObj['czas_wprowadzenie']);

            if(resultObj['czas_przypisania']) {
                $('#assign-timestamp').html(resultObj['czas_przypisania']);
                $('#assign-timestamp-line').css('display', 'block');
            }

            if(resultObj['czas_rozpoczecia']) {
                $('#work-start-timestamp').html(resultObj['czas_rozpoczecia']);
                $('#work-start-timestamp-line').css('display', 'block');
            }

            if(resultObj['czas_zakonczenia']) {
                $('#work-end-timestamp').html(resultObj['czas_zakonczenia']);
                $('#work-end-timestamp-line').css('display', 'block');
            }

            if(resultObj['czas_zweryfikowania']) {
                $('#verification-timestamp').html(resultObj['czas_zweryfikowania']);
                $('#verification-timestamp-line').css('display', 'block');
            }

            if(resultObj['czas_zamkniecia']) {
                $('#closure-timestamp').html(resultObj['czas_zamkniecia']);
                $('#closure-timestamp-line').css('display', 'block');
            }


            $('#history-modal').modal('show');
            $('#history-modal').on('hide.bs.modal', (e) => {
                
                // Remove values
                

            });
        }
    });
}
