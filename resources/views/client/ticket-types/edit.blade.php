@push('modals')
    <!-- Modal -->
    <div class="modal fade" id="edit-ticket-type-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Ticket Type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="title">Name</label>
                            <input class="form-control py-3" name="name" id="name" placeholder="Enter ticket type"
                                value="" />
                            @error('name')
                                @php
                                    toast($message, 'error');
                                @endphp
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input class="form-control py-3" name="price" id="price"
                                placeholder="Enter price" value="" />
                            @error('price')
                                @php
                                    toast($message, 'error');
                                @endphp
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="no_of_available_tickets">Number of Available Tickets</label>
                            <input class="form-control py-3" type="number" name="no_of_available_tickets" id="no_of_available_tickets"
                                placeholder="Enter number of available tickets" value="" />
                            @error('no_of_available_tickets')
                                @php
                                    toast($message, 'error');
                                @endphp
                            @enderror
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
@endpush
