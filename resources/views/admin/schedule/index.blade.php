@extends('adminlte::page')
@section('title', 'Schedule')

@section('content_header')
Schedules
@stop

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <form action="" method="POST" class="form-inline">
                        <input type="date" name="start_date" class="form-control">
                        <input type="date" name="end_date" class="form-control ml-2">
                        <button type="submit" name="filter_date" class="btn btn-info ml-2 ">Search</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('Schedule List') }}
                    {{ csrf_field() }}
                    <button style="float: right; font-weight: 900;" class="btn btn-success btn-sm" type="button"
                        data-toggle="modal" data-target="#CreateScheduleModal">
                        Add Schedule
                    </button>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered datatable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Task</th>
                                    <th>Date</th>
                                    <th>Time</th>
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

<!-- Create> Schedule Modal -->
<div class="modal" id="CreateScheduleModal">
    {{ csrf_field() }}
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"> Schedule Create</h4>
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
                    <strong>Success!</strong> Schedule was added successfully.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="form-group">
                    <label for="Name">Name :</label>
                    <input type="text" class="form-control" name="name" id="create-name">
                </div>
                <div class="form-group">
                    <label for="Name">Task :</label>
                    <select class="js-example-placeholder-single js-states form-control" name="task" id="create-task">
                        <option>Fixing</option>
                        <option>Testing</option>
                        <option>Checking</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="Name">Date</label>
                    <div class="cal-icon"><input class="form-control" type="date" id="create-date"></div>
                </div>
                <div class="form-group">
                    <label for="Name">Time:</label>
                    <input type="time" class="form-control" name="time" id="create-time">
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="SubmitCreateScheduleForm">Create</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div id="open-edit-modal"></div>
<!-- Delete> Schedule Modal -->
<div class="modal" id="DeleteScheduleModal">
    {{ csrf_field() }}
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"> Schedule Delete</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <h4>Are you sure want to delete this user?</h4>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="SubmitDeleteScheduleForm">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css"
    rel="stylesheet">
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css"
    integrity="sha256-b5ZKCi55IX+24Jqn638cP/q3Nb2nlx+MH/vMMqrId6k=" crossorigin="anonymous" />
@stop
@section('js')
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"
    integrity="sha256-5YmaxAwMjIpMrVlK84Y/+NjCpKnFYa8bWWBbUHSBGfU=" crossorigin="anonymous"></script>

<script type="text/javascript">
    function editSchedule(id){
        var url = '{{route('schedule.edit', ':id')}}';
        url = url.replace(':id', id);
        $('#open-edit-modal').load(url+"#EditScheduleModal",function(){
            $('#EditScheduleModal').modal();
        });
    }

    function deleteSchedule(id){
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.value) {
                var url = '{{ route('schedule.destroy', ':id')}}';
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
            ajax: '{{ route('get-schedule') }}',
            columns: [
                {data: 'name', name: 'name'},
                {data: 'task', name: 'task'},
                {data: 'date', name: 'date'},
                {data: 'time', name: 'time'},
                {data: 'Actions', name: 'Actions',orderable:false,serachable:false,sClass:'text-center'},
            ]
        });
        // Create product Ajax request.
        $('#SubmitCreateScheduleForm').click(function(e) {
            e.preventDefault();
            console.log('added');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('schedule.store') }}",
                method: 'post',
                data: {
                    name: $('#create-name').val(),
                    task: $('#create-task').val(),
                    date: $('#create-date').val(),
                    time: $('#create-time').val(),
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
                            $('#CreateScheduleModal').modal('hide');
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
        $('#SubmitDeleteScheduleForm').click(function(e) {
            e.preventDefault();
            var id = deleteID;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "schedule/"+id,
                method: 'DELETE',
                success: function(result) {
                    setInterval(function(){ 
                        $('.datatable').DataTable().ajax.reload();
                        $('#DeleteScheduleModal').modal('hide');
                    }, 1000);
                }
            });
        });
    });
</script>

{{-- <script>
    $(document).ready(function(){
     $('.input-daterange').datepicker({
      todayBtn:'linked',
      format:'yyyy-mm-dd',
      autoclose:true
     });
     
     load_data();
     
     function load_data(from_date = '', to_date = '')
     {
      $('#order_table').DataTable({
       processing: true,
       serverSide: true,
       ajax: {
        url:'{{ route("daterange.index") }}',
        data:{from_date:from_date, to_date:to_date}
       },
       columns: [
        {
         data:'name',
         name:'name'
        },
        {
         data:'task',
         name:'task'
        },
        {
         data:'date',
         name:'date'
        },
        {
         data:'time',
         name:'time'
        },
       ]
      });
     }
     
     $('#filter').click(function(){
      var from_date = $('#from_date').val();
      var to_date = $('#to_date').val();
      if(from_date != '' &&  to_date != '')
      {
       $('#order_table').DataTable().destroy();
       load_data(from_date, to_date);
      }
      else
      {
       alert('Both Date is required');
      }
     });
     
     $('#refresh').click(function(){
      $('#from_date').val('');
      $('#to_date').val('');
      $('#order_table').DataTable().destroy();
      load_data();
     });
     
    });
</script> --}}
@stop