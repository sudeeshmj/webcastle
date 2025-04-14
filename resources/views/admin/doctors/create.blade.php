@extends('layouts.master')

@section('admincontent')
    <div class="container-fluid p-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-header">
                        <h5 class="mb-0">Add Doctor</h5>
                    </div>

                    <form action="{{ route('doctors.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body row g-3 p-4">
                            <div class="col-md-6">
                                <label class="form-label" for="name">Name *</label>
                                <input type="text" name="name" id="name"
                                    class="form-control form-control-sm  @error('name')is-invalid @enderror" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="gender">Gender *</label>
                                <select name="gender" id="gender"
                                    class="form-select form-select-sm @error('gender')is-invalid @enderror" required>
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="doctor_department_id">Department *</label>
                                <select name="doctor_department_id" id="doctor_department_id"
                                    class="form-select form-select-sm  @error('doctor_department_id')is-invalid @enderror"
                                    required>
                                    <option value="">Select Department</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                                @error('doctor_department_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="qualification">Qualification</label>
                                <input type="text" name="qualification" id="qualification"
                                    class=" form-control  form-control-sm @error('email')is-invalid @enderror">
                                @error('qualification')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" name="email" id="email"
                                    class="form-control form-control-sm @error('email')is-invalid @enderror">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="phone">Phone *</label>
                                <input type="tel" name="phone" id="phone"
                                    class="form-control form-control-sm  @error('phone')
                                    is-invalid
                                @enderror"
                                    pattern="[0-9]{10}" maxlength="10" minlength="10" title="Phone number must be 10 digits"
                                    required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="formFile" class="form-label">Image</label>
                                <input class="form-control form-control-sm" name="photo" type="file" id="formFile"
                                    accept="image/*">
                            </div>
                        </div>

                        <div class="card-footer d-flex justify-content-end px-4 py-3">
                            <a href="{{ route('doctors.index') }}" class="btn btn-secondary btn-sm me-2">Back</a>
                            <button type="submit" class="btn btn-primary btn-sm">Save Doctor</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
