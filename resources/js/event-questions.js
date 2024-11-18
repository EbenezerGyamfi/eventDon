
// deleting a question
$('.event-questions-table').on('click', (event) => {
    event.preventDefault();
    let element = event.target;
    if($(element).attr('data-item-id')) {
        Swal.fire({
            title: 'Are you sure you want to delete this question ?',
            icon : 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            confirmButtonColor: '#e79d0f'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = route('events.questions.destroy', {
                    event : $(element).attr('data-event-id'),
                    question: $(element).attr('data-item-id')
                })
            }
        })
    }
})

let questionModal = $('#edit-question-modal');
let question = null;
questionModal.on('show.bs.modal', function (event) {
    let element = event.relatedTarget;
    question = JSON.parse(element.getAttribute('data-item'));
    let form = questionModal.find('form')[0];
    form.action = route('events.questions.update', {
        event: question.event_id,
        question: question.id
    });
    form.title.value = question.title;
    form.question.value = question.question;

    if(question.title.toLowerCase() == 'name') {
        form.title.setAttribute('readonly', 'readonly');
    } else {
        $(form.title).removeAttr('readonly');
    }
    
})