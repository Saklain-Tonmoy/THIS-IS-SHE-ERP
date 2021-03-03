@extends('layouts.master')

@section('css')
<link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
<link href="{{asset('assets/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet" />
@endsection

@section('content')

<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <h6 class="mb-0 text-uppercase">DataTable Import</h6>
        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example2" class="table table-striped table-bordered">
                        @csrf
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Photo</th>
                                <th>Is Parent</th>
                                <th>Parents</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $item)
                                <tr>
                                    <td>{{$item->name}}</td>
                                    <td><img src="{{$item->photo}}" alt="category image" style="max-height: 100px; max-width: 120px;"></td>
                                    <td>{{$item->is_parent === 1 ? 'YES':'NO'}}</td>
                                    <td>{{\App\Models\Category::where('category_id', $item->parent_id)->value('category_name')}}</td>
                                    <td>{{$item->status}}</td>
                                    <td>
                                        <a href="{{route('category.edit', $item->category_id)}}" class="float-left m-2 btn btn-sm btn-outline-warning" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="bx bx-edit"></i></a>
                                        <form class="float-left" action="{{route('category.destroy', $item->category_id)}}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <a href="" class="m-2 btn btn-sm btn-outline-danger" data-toggle="tooltip" data-id="{{$item->id}}" title="delete" data-placement="bottom"><i class="bx bx-trash"></i></a>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Photo</th>
                                <th>Is Parent</th>
                                <th>Parents</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end page wrapper -->

@endsection

@section('script')
<script src="{{asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js')}}"></script>
<script src="{{asset('assets/plugins/sweetalert/sweetalert.min.js')}}"></script>

<script>
    $(document).ready(function() {
        var table = $('#example2').DataTable({
            lengthChange: false,
            buttons: ['copy', 'excel', 'pdf', 'print']
        });

        table.buttons().container()
            .appendTo('#example2_wrapper .col-md-6:eq(0)');
    });
</script>
@endsection