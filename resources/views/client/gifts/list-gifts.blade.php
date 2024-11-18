@extends('layout.client')
@section('script')
@endsection
@section('content')
    @include('partials.toast')
    <section>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex flex-row justify-content-between align-items-center">
                        <h6>{{ $data['page_title'] }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped dataTable">
                                <thead>
                                    <tr>
                                        <th>Time Received</th>
                                        <th>Code</th>
                                        <th>Gift Type</th>
                                        <th>Item</th>
                                        <th>Quantity</th>
                                        <th>Donor Name</th>
                                        <th>Donor Phone</th>
                                        <th>Received By</th>
                                        <th>Updated By</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($gifts as $gift)
                                    <tr>
                                        <td>{{ $gift->created_at }}</td>
                                        <td>{{ $gift->code }}</td>
                                        <td>{{ ucwords ($gift->type) }}</td>
                                        <td>{{ $gift->name }}</td>
                                        <td>{{ $gift->quantity }}</td>
                                        <td>{{ !empty($gift->donor->getName ()) ? $gift->donor->getName () : $gift->donor->phone }}</td>
                                        <td>{{ $gift->donor->phone }}</td>
                                        <td>{{ $gift->teller?->name }}</td>
                                        <td>{{ $gift->updatedTeller?->name }}</td>
                                        <td>
                                            <a style="width: 100%" href="{{ route ('gifts.edit', $gift) }}" class="btn btn-info btn-sm">Update <span class="fa fa-edit"></span></a>
                                            @if(auth ()->user ()->role !== 'teller')
                                                <form method="POST" action="{{ route ('gifts.destroy', $gift) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button style="width: 100%" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete the selected gift?')" type="submit" name="delete-gift">
                                                        <span class="fa fa-times"></span> Delete
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
