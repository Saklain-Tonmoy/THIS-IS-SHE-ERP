@extends('layouts.master')

@section('css')
<link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
<link href="{{asset('assets/plugins/datetimepicker/css/classic.css')}}" rel="stylesheet" />
<link href="{{asset('assets/plugins/datetimepicker/css/classic.time.css')}}" rel="stylesheet" />
<link href="{{asset('assets/plugins/datetimepicker/css/classic.date.css')}}" rel="stylesheet" />
<link href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.min.css')}}" rel="stylesheet" />
@endsection

@section('content')

<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <h6 class="mb-0 text-uppercase">DataTable Import</h6>
        <hr />
        <div class="card">
            <div class="card-body">
                <h6 class="mb-3 text-uppercase">Category List</h6>
                <!-- Button trigger modal -->
                <div class="col">
                    <button type="button" class="btn btn-success" px-5 data-bs-toggle="modal" data-bs-target="#exampleScrollableModal"><i class="bx bx-plus-medical mr-1"></i>Add Category</button>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="exampleScrollableModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable">
                        <form method="POST" action="{{route('category.store')}}">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add New Category</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="border p-4 rounded">
                                        <div class="card-title d-flex align-items-center">
                                            <div><i class="bx bxs-user me-1 font-22 text-white"></i>
                                            </div>
                                            <h5 class="mb-0 text-white">Category Information</h5>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label for="name" class="col-form-label">Category Name <span class="text-danger">*</span></label>
                                            <input id="name" type="text" name="name" placeholder="Enter Category Name" value="{{old('name')}}" class="form-control @error('name') is-invalid @enderror">
                                            @error('category_name')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="photo" class="col-form-label">Photo <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-light">
                                                        <i class=""></i> Choose
                                                    </a>
                                                </span>
                                                <input id="thumbnail" class="form-control" type="text" name="photo" value="{{old('photo')}}">
                                            </div>
                                            <div id="holder" style="margin-top: 15px; max-height: 100px;"></div>
                                            @error('category_photo')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="is_parent" class="col-form-label">Is Parent : <span class="text-danger">*</span></label>
                                            <input type="checkbox" id="is_parent" name="is_parent" value="1" checked> Yes
                                            @error('is_parent')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group d-none" id="parent_cat_div">
                                            <label for="parent_id" class="col-form-label">Parent Category <span class="text-danger">*</span></label>
                                            <select name="parent_id" class="form-control">
                                                <option value="">-- Parent Category --</option>
                                                @foreach($parent_category as $item)
                                                <option value="{{$item->id}}" {{old('parent_id') == $item->id ? 'selected' : ''}}>{{$item->title}}</option>
                                                @endforeach
                                            </select>
                                            @error('status')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPhoto" class="col-form-label">Photo <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-info">
                                                        <i class="fas fa-picture-o"></i> Choose
                                                    </a>
                                                </span>
                                                <input id="thumbnail" class="form-control" type="text" name="photo" value="{{old('photo')}}">
                                            </div>
                                            <div id="holder" style="margin-top:15px; max-height:100px;"></div>
                                            @error('photo')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
                                            <select name="status" class="form-control">
                                                <option value="">-- Status --</option>
                                                <option value="active" {{old('status') == 'active' ? 'selected':''}}>Active</option>
                                                <option value="inactive" {{old('status') == 'inactive' ? 'selected':''}}>Inactive</option>
                                            </select>
                                            @error('status')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success">Save changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="col-lg-12">
                @include('layouts.notification')
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example2" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Photo</th>
                                <th>Is Parent</th>
                                <th>Parent</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $item)
                            <tr>
                                <td>{{$item->category_name}}</td>
                                <td><img src="{{$item->photo}}" alt="category image" style="max-height: 100px; max-width: 120px;"></td>
                                <td>{{$item->is_parent === 1 ? 'YES':'NO'}}</td>
                                <td>{{\App\Models\Category::where('category_id', $item->parent_id)->value('category_name')}}</td>
                                <td>{{$item->status}}</td>
                                <td>
                                    <a href="{{route('category.edit', $item->category_id)}}" class="btn btn-sm btn-outline-success m-2 float-start" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="bx bx-edit"></i></a>
                                    <form class="float-start" action="{{route('category.destroy', $item->category_id)}}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <a href="" class="dltBtn btn btn-sm btn-outline-danger m-2" data-toggle="tooltip" data-id="{{$item->category_id}}" title="delete" data-placement="bottom"><i class="bx bx-trash"></i></a>
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
                                <th>Parent</th>
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
<script src="{{asset('assets/plugins/datetimepicker/js/legacy.js')}}"></script>
<script src="{{asset('assets/plugins/datetimepicker/js/picker.js')}}"></script>
<script src="{{asset('assets/plugins/datetimepicker/js/picker.time.js')}}"></script>
<script src="{{asset('assets/plugins/datetimepicker/js/picker.date.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/moment.min.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.min.js')}}"></script>

<script>
    $(document).ready(function() {
        var table = $('#example2').DataTable({
            lengthChange: false,
            buttons: ['copy', 'excel', 'pdf', 'print'],
            initComplete: function() {
                // Apply the search
                this.api().columns().every(function() {
                    var that = this;

                    $('input', this.footer()).on('keyup change clear', function() {
                        if (that.search() !== this.value) {
                            that
                                .search(this.value)
                                .draw();
                        }
                    });
                });
            }
        });
        table.buttons().container()
            .appendTo('#example2_wrapper .col-md-6:eq(0)');
        $('#example tfoot th').each(function() {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="Search ' + title + '" />');
        });


    });
</script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.dltBtn').click(function(e) {
        var form = $(this).closest('form');
        var dataId = $(this).data('category_id');
        e.preventDefault();
        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this file!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    form.submit();
                    swal("Done! Your file has been deleted!", {
                        icon: "success",
                    });
                } else {
                    swal("Your imaginary file is safe!");
                }
            });
    });
</script>


<script src="{{asset('assets/plugins/laravel-filemanager/js/stand-alone-button.js')}}"></script>
<script>
    $('#lfm').filemanager('image');
</script>
<script>
    $('#is_parent').change(function(e) {
        e.preventDefault();
        var is_checked = $('#is_parent').prop('checked');
        //alert(is_checked);

        if (is_checked) {
            $('#parent_cat_div').addClass('d-none');
            $('#parent_cat_div').val('');
        } else {
            $('#parent_cat_div').removeClass('d-none');
        }
    })
</script>

@endsection