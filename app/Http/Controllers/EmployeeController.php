<?php

namespace App\Http\Controllers;

use App\DataTables\EmployeeDataTable;
use App\Models\Employee;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Flasher\Prime\FlasherInterface;





class EmployeeController extends Controller
{
    use ImageUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(EmployeeDataTable $dataTable)
    {
       
       
        return $dataTable->render('employees.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        return view('employees.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


       $request->validate(
        [
           
           // 'emp_profile_pic' => ['required','image','max:2048'],
            'emp_no' => ['required','unique:employees', 'integer'],
            'emp_name' => ['required' ,'max:255'],
            'emp_address' => ['required','max:500'],
            'emp_base_salary' => ['required','min:0', 'numeric'],
            'emp_status' => ['required','boolean']
        ]);

        $employee = new Employee();
       
       $imagePath = $this->uploadImage($request, 'emp_profile_pic', 'uploads');

        $employee->emp_profile_pic = empty(!$imagePath) ? $imagePath : $employee->emp_profile_pic;

        $employee->emp_no = $request->emp_no; 
        $employee->emp_name = $request->emp_name; 
        $employee->emp_address = $request->emp_address; 
        $employee->emp_base_salary = $request->emp_base_salary;
        $employee->emp_status = $request->emp_status;
        $employee->save();

      //  Log::error('message before');

       // Flasher::addSuccess('Employee Created Successfully');

      flash()->success('Employee Created Successfully');
      
      return redirect()->route('employees.index');

    }

    public function search($query)
    {
        // Find the employee by number or name
        $employee = Employee::where('emp_no', $query)
        ->orWhere('emp_name', 'like', '%' . $query . '%')
        ->firstOrFail();

        // Return JSON response
        if ($employee) {
            return response()->json($employee);
        }

        return response()->json(['message' => 'Employee not found'], 404);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $employee = Employee::findOrFail($id);
        return view('employees.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
       $request->validate(
        [
           
            'emp_profile_pic' => ['nullable','image','max:2048'],
            'emp_no' => ['required','unique:employees', 'integer'],
            'emp_name' => ['required' ,'max:255'],
            'emp_address' => ['required','max:500'],
            'emp_base_salary' => ['required','min:0', 'numeric'],
            'emp_status' => ['required','boolean']
        ]);

        $employee = Employee::findOrFail($id);
       
       $imagePath = $this->updateImage($request, 'emp_profile_pic', 'uploads', $employee->emp_profile_pic);

        $employee->emp_profile_pic = $imagePath;

        $employee->emp_no = $request->emp_no; 
        $employee->emp_name = $request->emp_name; 
        $employee->emp_address = $request->emp_address; 
        $employee->emp_base_salary = $request->emp_base_salary;
        $employee->emp_status = $request->emp_status;
        $employee->save();

      //  Log::error('message before');

       // Flasher::addSuccess('Employee Created Successfully');

      flash('Employee Updated Successfully');
      
      return redirect()->route('employees.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = Employee::findOrFail($id);
      //  $this->deleteImage($employee->emp_profile_pic);
        $employee->delete();

        return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
    }
}
