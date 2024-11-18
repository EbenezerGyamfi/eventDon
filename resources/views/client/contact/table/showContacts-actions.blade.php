<div class="d-flex flex-row justify-content-center align-items-center account-actions">

    <div class="d-flex justify-content-center align-items-center rounded bg-primary p-2 pointer" title="edit">
        <a href="#" class="text-body" data-bs-toggle="modal" data-id="{{$query->id}}"
            data-bs-target="#edit_{{$query->id}}">
            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
        </a>
    </div>
    <div class="d-flex justify-content-center align-items-center rounded bg-danger p-2 pointer" title="delete">
        <a href="#" class="text-body" data-bs-toggle="modal" data-id="{{$query->id}}"
            data-bs-target="#delete_{{$query->id}}">
            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="currentColor" class="bi bi-trash"
                viewBox="0 0 16 16">
                <path
                    d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                <path fill-rule="evenodd"
                    d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
            </svg>
        </a>
    </div>
</div>

{{-- edit modal --}}
<div class="modal fade" id="edit_{{$query->id}}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title" id="editModalLabel">Edit {{$query->name}} Contact Details</p>
                <a href="#" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> <i
                        class="fa fa-times" aria-hidden="true"></i></a>
            </div>
            <form action="{{ route('edit.contact', $query->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" value="{{$query->name}}">
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" class="form-control" name="phone" value="{{$query->phone}}">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" name="email" value="{{$query->email}}">
                    </div>
                    <input type="hidden" name="id" value="{{ $query->id }}">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Save <i class="fa fa-check"
                                aria-hidden="true"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



{{-- delete modal --}}
<div class="modal fade" id="delete_{{$query->id}}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="deleteModalLabel">Delete </h6>
                <a href="#" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> <i
                        class="fa fa-times" aria-hidden="true"></i></a>
            </div>
            <form action="{{ route('delete.contact', $query->id) }}" method="get">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <p> <b>Are you sure you want to delete {{$query->name}}'s contact?</b></p>
                    </div>
                    {{-- <input type="hidden" name="contact_group_id" value="{{ $query->id }}"> --}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Yes <i class="fa fa-check"
                                aria-hidden="true"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
