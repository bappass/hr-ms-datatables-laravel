<?php

namespace App\Http\Controllers;

use App\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;


class ScheduleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->Schedule = new Schedule;

        $this->title = 'Schedule';
        $this->path = 'admin.';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view($this->path . 'schedule.index');
    }

    public function show($id)
    {
    }

    /**
     * Get the data for listing in yajra.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getSchedule(Request $request)
    {
        $data = $this->Schedule->getData();
        return DataTables::of($data)
            ->addColumn('Actions', function ($data) {
                return '<a href="#" onclick="editSchedule(' . $data->id . ')" class="badge badge-success"><i class="fas fa-edit"></i> Edit</a>
                <a href="#" onclick="deleteSchedule(' . $data->id . ')" class="badge badge-danger"><i class="fas fa-edit"></i> Delete</a>';
                // return '<button type="button" class="btn btn-success btn-sm" id="getEditEmployeeData" data-id="' . $data->id . '">Edit</button>
                //     <button type="button" data-id="' . $data->id . '" data-toggle="modal" data-target="#DeleteEmployeeModal" class="btn btn-danger btn-sm" id="getDeleteId">Delete</button>';
            })
            ->rawColumns(['Actions'])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'task' => 'required',
            'date' => 'required',
            'time' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $this->Schedule->storeData($request->all());

        return response()->json(['success' => 'Schedule added successfully']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $schedule = $this->Schedule->find($id);
        return view("admin.schedule.edit", compact('schedule'));
        // $data = $this->Employee->findData($id);

        // $html = '<div class="form-group">
        //             <label for="Name">Name:</label>
        //             <input type="text" class="form-control" name="name" id="editName" value="' . $data->name . '">
        //         </div>
        //         <div class="form-group">
        //             <label for="Name">Price:</label>
        //             <input type="text" class="form-control" name="price" id="editPrice" value="' . $data->price . '">
        //         </div>
        //         <div class="form-group">
        //             <label for="Name">Description:</label>
        //             <textarea class="form-control" name="description" id="editDescription">' . $data->description . '                        
        //             </textarea>
        //         </div>';

        // return response()->json(['html' => $html]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'task' => 'required',
            'date' => 'required',
            'time' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $input = $request->except(['password']);
        if ($request->filled('password')) {
            $input['password'] = Hash::make($request->password);
        }

        $this->Schedule->updateData($id, $input);

        return response()->json(['success' => 'Schedule updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->Schedule->deleteData($id);

        return response()->json(['success' => 'Employee deleted successfully']);
    }

    public function getIndexData()
    {
        $arrStart = explode("/", Input::get('start'));
        $arrEnd = explode("/", Input::get('end'));
        $start = Carbon::create($arrStart[2], $arrStart[0], $arrStart[1], 0, 0, 0);
        $end = Carbon::create($arrEnd[2], $arrEnd[0], $arrEnd[1], 23, 59, 59);

        $orders = Schedule::between($start, $end);

        return Datatables::of($orders)
            ->addColumn(
                'action',
                function ($orders) {
                    return '<a href="schedule/' . $orders->id . '" class="btn btn-xs btn-primary"><i class="fa fa-truck"></i></a>';
                }
            )
            ->make(TRUE);
    }
}
