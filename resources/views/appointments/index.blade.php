@extends('layouts.app')
@section('content')
    <div>
        <div class="container-fluid m-0 p-0">
            <div class="header shadow-sm p-4 bg-white">
                <h5 class="text-center text-primary">Doctor Appointment</h5>
            </div>
        </div>
        <div class="container my-5">
            <div class="filter-container mb-4">
                <form action="{{ route('doctor.list') }}" method="GET" class="row g-2 mb-4">
                    <div class="col-md-4">
                        <select class="form-select form-select-sm" name="department" onchange="this.form.submit()">
                            <option value="">All Departments</option>
                            @foreach ($departments as $id => $name)
                                <option value="{{ $id }}" {{ request('department') == $id ? 'selected' : '' }}>
                                    {{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="doctor-list-container   pb-5">
                <div class="row g-4">
                    @forelse ($doctors as $doctor)
                        <div class="col-md-4">
                            <div
                                class="doctor-profile border rounded shadow-sm p-3 h-100 d-flex flex-column justify-content-between bg-white">
                                <div class="doctor-profile-header d-flex align-items-center mb-3">

                                    @if ($doctor->photo)
                                        <img src="{{ Storage::url('doctors/' . $doctor->photo) }}" alt="Doctor Photo"
                                            width="50" height="50" class="rounded-circle border me-3">
                                    @else
                                        <img src="{{ asset('assets/image/default.png') }}" alt="No Photo" width="50"
                                            height="50" class="rounded-circle border me-3">
                                    @endif

                                    <div class="profile-content">
                                        <h6 class="mb-1">Dr. {{ $doctor->name }}</h6>
                                        <p class="text-muted mb-0" style="font-size: 13px;">{{ $doctor->department->name }}
                                        </p>
                                        <p class="text-muted mb-0" style="font-size: 13px;">{{ $doctor->qualification }}</p>
                                    </div>
                                </div>

                                <div class="text-end mt-auto">
                                    <a href="{{ route('appointment', $doctor->id) }}"
                                        class="btn btn-outline-primary btn-sm">
                                        Book Appointment
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted mt-4">No doctors found.</p>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
    <!-- Toastr messages -->
    @if (session()->has('success'))
        <script>
            toastr.success("{{ session('success') }}");
        </script>
    @endif

    @if (session()->has('error'))
        <script>
            toastr.error("{{ session('error') }}");
        </script>
    @endif
@endsection
