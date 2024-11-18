/*****
 * Add & Remove ticket types during
 * event creation
 */

let ticketTypeCount = -1;
const addTicketTypeButton = $('#add-ticket-type-btn');
const ticketTypeWrapper = $('.ticketing-type-wrapper');
const ticketTypeTemplate = $('.ticket-type-wrapper-template')

addTicketTypeButton.on("click", function (event) {
    event.preventDefault();
    ticketTypeCount += 1;
    let html = ticketTypeTemplate.clone();
    let id = `tickets-${ticketTypeCount}`;

    html = `
    <div class="form-row col-12 pt-3 ticketing-enabled" id="${id}">
        <div class="col-sm-4 form-group">
            <label for="venue">Ticket Type</label>
            <input type="text" class="form-control py-3" name="tickets[${ticketTypeCount}][name]"
                placeholder="Please enter ticket type">
            <span class="invalid-feedback">error</span>
        </div>

        <div class="col-sm-4 form-group">
            <label for="venue">Ticket Price</label>
            <input type="number" class="form-control py-3"
                placeholder="Ticket Price" name="tickets[${ticketTypeCount}][price]">
            <span class="invalid-feedback">error</span>

        </div>
        <div class="col-sm-2 form-group ticket-order">
            <label for="order">Number of available tickets</label>
            <input type="number" name="tickets[${ticketTypeCount}][no_of_available_tickets]" class="form-control py-3" >
            <span class="invalid-feedback">error</span>
        </div>

        <div class="col-sm-2 text-center align-self-end">
            <button class="btn btn-danger btn-remove my-3" data-item-id="${ticketTypeCount}"  type="button"
                >Remove</button>
        </div>

    </div>
    `;
    ticketTypeWrapper.append(html);
});

ticketTypeWrapper.on("click", (event) => {
    const element = $(event.target);
    if (element.hasClass("btn-remove")) {
        $(`#tickets-${element.attr("data-item-id")}`).remove();
    }
});

/*****
 * Edit ticket types details
 */

let editTicketTypeModal = $('#edit-ticket-type-modal');
let ticketType = null;
editTicketTypeModal.on('show.bs.modal', function (event) {
    let element = event.relatedTarget;
    ticketType = JSON.parse(element.getAttribute('data-item'));
    let form = editTicketTypeModal.find('form')[0];

    form.action = route('events.ticket-types.update', {
        event: ticketType.event_id,
        ticket_type: ticketType.id
    });

    form.name.value = ticketType.name;
    form.price.value = ticketType.price;
    form.no_of_available_tickets.value = ticketType.no_of_available_tickets;

})