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
                <h4>Create New Employee</h4>
              </div>
              <div class="card-body">
                <form action="{{route('employees.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                      {{-- <div class="form-group">
                        <label>Profile Picture</label>
                        <input type="file" class="form-control" name="emp_profile_pic" value="{{old('emp_profile_pic')}}">
                      </div> --}}
                      <div class="form-group">
                        <label>Employee Number</label>
                        <input type="text" class="form-control" name="emp_no" value="{{old('emp_no')}}">
                      </div>
                    <div class="form-group">
                        <label>Employee Name</label>
                        <input type="text" class="form-control" name="emp_name" value="{{old('emp_name')}}">
                      </div>
                      <div class="form-group">
                        <label>Employee address</label>
                        <input type="text" class="form-control" name="emp_address" value="{{old('emp_address')}}">
                      </div>
                      <div class="form-group">
                        <label>Base Salary</label>
                        <input type="text" class="form-control" name="emp_base_salary" value="{{old('emp_base_salary')}}">
                      </div>
                      <div class="form-group">
                        <label for="inputState">Employee Status</label>
                        <select id="inputState" class="form-control" name="emp_status">
                          <option value="1">Active</option>
                          <option value="0">Inactive</option>
                        </select>
                      </div>
                      <button type="submit" class="btn btn-primary">Add Employee</button>
                </form>
              </div>
             
             
            </div>
          </div>
         
        </div>
       
      </div>
    </section>
  </div>
@endsection