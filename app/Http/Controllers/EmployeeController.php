<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;


class EmployeeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->Employee = new Employee;

        $this->title = 'Employee';
        $this->path = 'admin.';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view($this->path . 'employee.index');
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
    public function getEmployee(Request $request)
    {
        $data = $this->Employee->getData();
        return DataTables::of($data)
            ->addColumn('Actions', function ($data) {
                return '<a href="#" onclick="editEmployee(' . $data->id . ')" class="badge badge-success"><i class="fas fa-edit"></i> Edit</a>
                <a href="#" onclick="deleteEmployee(' . $data->id . ')" class="badge badge-danger"><i class="fas fa-edit"></i> Delete</a>';
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
            'email' => 'required',
            'password' => 'required',
            'departement' => 'required',
            'country' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $this->Employee->storeData($request->all());

        return response()->json(['success' => 'Employee added successfully']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = $this->Employee->find($id);
        return view("admin.employee.edit", compact('employee'));
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
            'email' => 'required',
            'password' => 'nullable',
            'departement' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $input = $request->except(['password']);
        if ($request->filled('password')) {
            $input['password'] = Hash::make($request->password);
        }

        $this->Employee->updateData($id, $input);

        return response()->json(['success' => 'Employee updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->Employee->deleteData($id);

        return response()->json(['success' => 'Employee deleted successfully']);
    }
}
