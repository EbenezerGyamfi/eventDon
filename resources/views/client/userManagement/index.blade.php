@extends('layout.client')

@section('content')
    @include('partials.toast')
    <div class="row">
        <div class="col-12">
            <div class="card user-management">
                <div class="card-header d-flex flex-row justify-content-between">
                    <h4 class="card-title"> User Management</h4>


                    <a href="{{ route('user-management.create') }}"
                        class="btn btn-outline-primary d-flex flex-row justify-content-center align-items-center account-actions">Add
                        A Teller
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            class="bi bi-person-plus" viewBox="0 0 16 16">
                            <path
                                d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                            <path fill-rule="evenodd"
                                d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z" />
                        </svg>
                    </a>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    @endif
                    <div class="table-responsive overflow-auto">
                        <table class="table" id="users-table">
                            <thead class=" text-primary">
                                <tr>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>email</th>
                                    <th>role</th>
                                    <th>Created At</th>
                                    <th class="td-actions text-center" style="" data-field="actions">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->role == 'client_admin' ? 'admin' : $user->role }}</td>
                                        <td>{{ $user->created_at }}</td>
                                        <td class="td-actions text center">
                                            <a href="#" rel="tooltip" title="manage"
                                                class="btn btn-info btn-simple btn-sm btn-xs"
                                                data-original-title="Manage User">
                                                <i class="fa fa-user" aria-hidden="true"></i>
                                            </a>
                                            <a href="#" rel="tooltip" title="edit"
                                                class="btn btn-success btn-simple btn-sm btn-xs" data-bs-toggle="modal"
                                                data-id="{{ $user->id }}" data-bs-target="#edit_{{ $user->id }}"
                                                data-original-title="Edit Profile">
                                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                            </a>
                                            {{-- <a href="#" rel="tooltip" title="remove"
                                                class="btn btn-danger btn-simple btn-sm btn-xs" data-bs-toggle="modal"
                                                data-id="{{ $user->id }}" data-bs-target="#delete_{{ $user->id }}">
                                                <i class="fa fa-window-close" aria-hidden="true"></i>
                                            </a> --}}
                                        </td>
                                    </tr>
                                    {{-- delete modal --}}
                                    <div class="modal fade" id="delete_{{ $user->id }}" tabindex="-1"
                                        aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h6 class="modal-title" id="deleteModalLabel">Delete </h6>
                                                    <a href="#" type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"> <i class="fa fa-times"
                                                            aria-hidden="true"></i></a>
                                                </div>
                                                <form action="{{ route('user-management.destroy', $user->id) }}"
                                                    method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <p> <b>Are you sure you want to delete {{ $user->name }}?</b>
                                                            </p>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary btn-sm"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary btn-sm">Yes <i
                                                                    class="fa fa-check" aria-hidden="true"></i></button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- edit modal --}}
                                    <div class="modal fade" id="edit_{{ $user->id }}" tabindex="-1"
                                        aria-labelledby="editModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <p class="modal-title" id="editModalLabel">Edit {{ $user->name }}
                                                        Contact
                                                        Details</p>
                                                    <a href="#" type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"> <i class="fa fa-times"
                                                            aria-hidden="true"></i></a>
                                                </div>
                                                <form action="{{ route('user-management.update', $user->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>Name</label>
                                                            <input type="text" class="form-control" name="name"
                                                                value="{{ $user->name }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Phone</label>
                                                            <input type="text" class="form-control" name="phone"
                                                                value="{{ $user->phone }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Email</label>
                                                            <input type="text" class="form-control" name="email"
                                                                value="{{ $user->email }}">
                                                        </div>
                                                        <div class="input-group mb-4 col-12 ">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <i class="nc-icon nc-single-02"></i> </span>
                                                            </div>
                                                            <select class="form-select form-control" name="role"
                                                                aria-label="Default select example">
                                                                <option value="client_admin"
                                                                    {{ $user->role == 'client_admin' ? 'selected' : '' }}>
                                                                    admin</option>
                                                                <option value="teller"
                                                                    {{ $user->role == 'teller' ? 'selected' : '' }}>
                                                                    teller</option>
                                                            </select>

                                                        </div>
                                                        {{-- <input type="hidden" name="id" value="{{ $user->id }}"> --}}
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary btn-sm"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary btn-sm">Save <i
                                                                    class="fa fa-check" aria-hidden="true"></i></button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
