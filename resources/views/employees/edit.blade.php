@extends('layouts.master')

@section('content')

    <section class="section">
      <div class="section-header">
        <h1>Employees</h1>
        
      </div>

      <div class="section-body">
      
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h4>Edit Employee</h4>
              </div>
              <div class="card-body">
                <form action="{{route('employees.update', $employee->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                      {{-- <div class="form-group">
                        <label>Preview</label>
                        <br>
                        <img width="200" src="{{asset($employee->emp_profile_pic)}}" alt="">
                      </div> --}}
                      {{-- <div class="form-group">
                        <label>Profile Picture</label>
                        <input type="file" class="form-control" name="emp_profile_pic">
                      </div> --}}
                      <div class="form-group">
                        <label>Employee Number</label>
                        <input type="text" class="form-control" name="emp_no" value="{{$employee->emp_no}}">
                      </div>
                    <div class="form-group">
                        <label>Employee Name</label>
                        <input type="text" class="form-control" name="emp_name" value="{{$employee->emp_name}}">
                      </div>
                      <div class="form-group">
                        <label>Employee address</label>
                        <input type="text" class="form-control" name="emp_address" value="{{$employee->emp_address}}">
                      </div>
                      <div class="form-group">
                        <label>Base Salary</label>
                        <input type="text" class="form-control" name="emp_base_salary" value="{{$employee->emp_base_salary}}">
                      </div>
                      <div class="form-group">
                        <label for="inputState">Employee Status</label>
                        <select id="inputState" class="form-control" name="emp_status">
                          <option {{$employee->emp_status== 1 ? 'selected': ''}} value="1">Active</option>
                          <option {{$employee->emp_status== 0 ? 'selected': ''}} value="0">Inactive</option>
                        </select>
                      </div>
                      <button type="submit" class="btn btn-primary">Update Employee</button>
                </form>
              </div>
             
             
            </div>
          </div>
         
        </div>
       
      </div>
    </section>
  </div>
@endsection