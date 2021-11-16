<!-- Edit Employee Modal -->
<div class="modal" id="EditScheduleModal">
    {{ csrf_field() }}
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Schedule Edit</h4>
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
                    <strong>Success!</strong> Schedule was updated successfully.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="EditScheduleModalBody">
                    <div class="form-group">
                        <label for="Name">Name:</label>
                        <input type="text" class="form-control" value="{{$schedule->name}}" name="name" id="edit-name">
                    </div>
                    <div class="form-group">
                        <label for="Name">Task :</label>
                        <select class="js-example-placeholder-single js-states form-control" value="{{$schedule->task}}"
                            name="task" id="edit-task">
                            <option>Fixing</option>
                            <option>Testing</option>
                            <option>Checking</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Name">Date:</label>
                        <input type="date" class="form-control" value="{{$schedule->date}}" name="date" id="edit-date">
                    </div>
                    <div class="form-group">
                        <label for="Name">Time:</label>
                        <input type="time" class="form-control" value="{{$schedule->time}}" name="time" id="edit-time">
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="SubmitEditScheduleForm">Update</button>
                <button type="button" class="btn btn-danger modelClose" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
    <script>
        // Update product Ajax request.
            $('#SubmitEditScheduleForm').click(function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                id = '{{$schedule->id}}';
                var url = '{{route('schedule.update', ':id')}}';
                url = url.replace(':id', id);
                $.ajax({
                    url: "schedule/"+id,
                    method: 'PUT',
                    data: {
                        name: $('#edit-name').val(),
                        task: $('#edit-task').val(),
                        date: $('#edit-date').val(),
                        time: $('#edit-time').val(),
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
$('#EditScheduleModal').modal('hide');
}, 2000);
}
}
});
});

// Get single product in EditModel
$('.modelClose').on('click', function(){
$('#EditScheduleModal').hide();
});
var id;
$('body').on('click', '#getEditScheduleData', function(e) {
e.preventDefault();
$('.alert-danger').html('');
$('.alert-danger').hide();
id = $(this).data('id');
$.ajax({
url: "schedule/"+id+"/edit",
method: 'GET',
// data: {
// id: id,
// },
success: function(result) {
console.log(result);
$('#EditScheduleModalBody').html(result.html);
$('#EditScheduleModal').show();
}
});
});
    </script>
</div>