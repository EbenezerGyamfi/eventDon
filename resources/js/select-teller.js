
var url = route('user-management.available-tellers');
$('#assigned_users').select2({
    multiple: true,
    ajax: {
        url: url,
        dataType: 'json',
        processResults: function (data) {
            var results = data.data.map(function (result) {
                return {
                    id: result.id,
                    text: result.name,
                }
            });
            return {
                results: results
            }
        }
    }
});

$('#assigned_users').on('select2:select', function (event) {
    const userID = event.params.data.id;
    const html = `<input type="hidden"
                 id="selected-user-${userID}" 
                 name="selected_users[]"
                 value="${userID}">`;

    $('#tellers').append(html);    
});

$('#assigned_users').on('select2:unselect', function (event) {
    const userID = event.params.data.id;
    $(`#selected-user-${userID}`).remove();
});