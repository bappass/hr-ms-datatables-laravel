<!-- Edit Employee Modal -->
<div class="modal" id="EditEmployeeModal">
    {{ csrf_field() }}
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Employee Edit</h4>
                <button type="button" class="close modelClose" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                    <strong>Success!</strong> Employee was updated successfully.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="EditEmployeeModalBody">
                    <div class="form-group">
                        <label for="Name">Name:</label>
                        <input type="text" class="form-control" value="{{$employee->name}}" name="name" id="edit-name">
                    </div>
                    <div class="form-group">
                        <label for="Name">Email:</label>
                        <input type="email" class="form-control" value="{{$employee->email}}" name="email"
                            id="edit-email">
                    </div>
                    <div class="form-group">
                        <label for="Name">Password:</label>
                        <input type="password" class="form-control" name="password" id="edit-password">
                    </div>
                    <div class="form-group">
                        <label for="Name">Departement:</label>
                        <input type="text" class="form-control" value="{{$employee->departement}}" name="departement"
                            id="edit-departement">
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="SubmitEditEmployeeForm">Update</button>
                <button type="button" class="btn btn-danger modelClose" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
    <script>
        // Update product Ajax request.
            $('#SubmitEditEmployeeForm').click(function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                id = '{{$employee->id}}';
                var url = '{{route('employee.update', ':id')}}';
                url = url.replace(':id', id);
                $.ajax({
                    url: "employee/"+id,
                    method: 'PUT',
                    data: {
                        name: $('#edit-name').val(),
                        email: $('#edit-email').val(),
                        departement: $('#edit-departement').val(),
                        password: $('#edit-password').val(),
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
$('#EditEmployeeModal').modal('hide');
}, 2000);
}
}
});
});

// Get single product in EditModel
$('.modelClose').on('click', function(){
$('#EditEmployeeModal').hide();
});
var id;
$('body').on('click', '#getEditEmployeeData', function(e) {
e.preventDefault();
$('.alert-danger').html('');
$('.alert-danger').hide();
id = $(this).data('id');
$.ajax({
url: "employee/"+id+"/edit",
method: 'GET',
// data: {
// id: id,
// },
success: function(result) {
console.log(result);
$('#EditEmployeeModalBody').html(result.html);
$('#EditEmployeeModal').show();
}
});
});
    </script>
</div>