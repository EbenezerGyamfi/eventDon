<div class="d-flex justify-content-center align-items-center actions-btn view  p-2 pointer">
    <a href="{{ route('contacts.groups.show', $query->id) }}" class="text-body">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye view-icon"
            viewBox="0 0 16 16">
            <path
                d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
        </svg>
    </a>
</div>
<div class="d-flex justify-content-center align-items-center  p-2 pointer" title="edit">
    <a href="#" class="text-body" data-bs-toggle="modal" data-id="{{ $query->id }}"
        data-bs-target="#edit_{{ $query->id }}">
        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
    </a>
</div>
<div class="d-flex justify-content-center align-items-center actions-btn delete p-2 pointer">
    <a href="#" class="text-body" data-bs-toggle="modal" data-id="{{ $query->id }}"
        data-bs-target="#delete_{{ $query->id }}">
        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="currentColor"
            class="bi bi-trash delete-icon" viewBox="0 0 16 16">
            <path
                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
            <path fill-rule="evenodd"
                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
        </svg>
    </a>
</div>


{{-- <div class="dropdown open">
    <button href="#" class="btn btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        Action
    </button>
    <ul class="dropdown-menu">
        <li><a href="#">View Contacts</a></li>
        <li><a href="#">Add Contacts</a></li>
        <li><a href="#">Import Contacts</a></li>
        <li class="divider"></li>
        <li><a href="#">Edit </a></li>
        <li class="divider"></li>
        <li><a href="#">Delete</a></li>
    </ul>
</div> --}}

{{-- edit modal --}}
<div class="modal fade" id="edit_{{ $query->id }}" tabindex="-1" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Group - {{ $query->name }} Details</h5>
                <a href="#" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> <i
                        class="fa fa-times" aria-hidden="true"></i></a>
            </div>
            <form action="{{ route('contacts.groups.update', [$query->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" value="{{ $query->name }}">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea type="text" class="form-control" name="description">{{ $query->description }}
                        </textarea>
                    </div>
                    <input type="hidden" name="contact_group_id" value="{{ $query->id }}">
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
<div class="modal fade" id="delete_{{ $query->id }}" tabindex="-1" aria-labelledby="deleteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="deleteModalLabel">Delete {{ $query->name }}</h6>
                <a href="#" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> <i
                        class="fa fa-times" aria-hidden="true"></i></a>
            </div>
            <form action="{{ route('contacts.groups.delete', [$query->id]) }}" method="get">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <p> <b>Are you sure you want to delete ?</b></p>
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
