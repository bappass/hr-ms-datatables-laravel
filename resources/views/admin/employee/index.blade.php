@extends('adminlte::page')
@section('title', 'Employee')

@section('content_header')
Employees
@stop

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('Employee List') }}
                    {{ csrf_field() }}
                    <button style="float: right; font-weight: 900;" class="btn btn-success btn-sm" type="button"
                        data-toggle="modal" data-target="#CreateEmployeeModal">
                        Add Employee
                    </button>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered datatable">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Departement</th>
                                    <th>Country</th>
                                    <th width="150" class="text-center">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Employee Modal -->
<div class="modal" id="CreateEmployeeModal">
    {{ csrf_field() }}
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Employee Create</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                    <strong>Success!</strong>Employee was added successfully.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="form-group">
                    <label for="Name">Name:</label>
                    <input type="text" class="form-control" name="name" id="create-name">
                </div>
                <div class="form-group">
                    <label for="Name">Email:</label>
                    <input type="email" class="form-control" name="email" id="create-email">
                </div>
                <div class="form-group">
                    <label for="Name">Password:</label>
                    <input type="password" class="form-control" name="password" id="create-password">
                </div>
                <div class="form-group">
                    <label for="Name">Departement:</label>
                    <select class="js-example-placeholder-single js-states form-control" name="departement"
                        id="create-departement">
                        <option>Designer</option>
                        <option>Developer</option>
                        <option>Product Manager</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="Name">Country:</label>
                    <input type="text" class="form-control" name="country" id="create-country">
                </div>

            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="SubmitCreateEmployeeForm">Create</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div id="open-edit-modal"></div>
<!-- Delete Employee Modal -->
<div class="modal" id="DeleteEmployeeModal">
    {{ csrf_field() }}
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Employee Delete</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <h4>Are you sure want to delete this user?</h4>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="SubmitDeleteEmployeeForm">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
@stop
@section('js')
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
    function editEmployee(id){
        var url = '{{route('employee.edit', ':id')}}';
        url = url.replace(':id', id);
        $('#open-edit-modal').load(url+"#EditEmployeeModal",function(){
            $('#EditEmployeeModal').modal();
        });
    }

    function deleteEmployee(id){
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.value) {
                var url = '{{ route('employee.destroy', ':id')}}';
                url = url.replace(':id', id);  
                var token = "{{ csrf_token() }}";
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {'_token': token, '_method': 'DELETE'},
                    success: function (response) {
                        Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                                )
                                $('.datatable').DataTable().ajax.reload();
                    }
                });
            }
        })
    }

    $(document).ready(function() {
        // init datatable.
        var dataTable = $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            pageLength: 5,
            // scrollX: true,
            "order": [[ 0, "desc" ]],
            ajax: '{{ route('get-employee') }}',
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'departement', name: 'departement'},
                {data: 'country', name: 'country'},
                {data: 'Actions', name: 'Actions',orderable:false,serachable:false,sClass:'text-center'},
            ]
        });
        // Create product Ajax request.
        $('#SubmitCreateEmployeeForm').click(function(e) {
            e.preventDefault();
            console.log('added');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('employee.store') }}",
                method: 'post',
                data: {
                    name: $('#create-name').val(),
                    email: $('#create-email').val(),
                    departement: $('#create-departement').val(),
                    password: $('#create-password').val(),
                    country: $('#create-country').val(),
                },
                success: function(result) {
                    if(result.errors) {
                        $('.alert-danger').html('');
                        $.each(result.errors, function(key, value) {
                            $('.alert-danger').show();
                            $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
                        });
                    } else {
                        $('.alert-danger').hide();
                        $('.alert-success').show();
                        $('.datatable').DataTable().ajax.reload();
                        setInterval(function(){ 
                            $('.alert-success').hide();
                            $('#CreateEmployeeModal').modal('hide');
                            location.reload();
                        }, 2000);
                    }
                }
            });
        });

        // Delete product Ajax request.
        var deleteID;
        $('body').on('click', '#getDeleteId', function(){
            deleteID = $(this).data('id');
        })
        $('#SubmitDeleteEmployeeForm').click(function(e) {
            e.preventDefault();
            var id = deleteID;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "employee/"+id,
                method: 'DELETE',
                success: function(result) {
                    setInterval(function(){ 
                        $('.datatable').DataTable().ajax.reload();
                        $('#DeleteEmployeeModal').modal('hide');
                    }, 1000);
                }
            });
        });
    });
</script>
@stop