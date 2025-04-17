@extends('layouts.app')
@section('content')

    <div class="container-fluid p-0">
        <div class="bg-white shadow-sm py-4 text-center">
            <h5 class="text-primary m-0">Doctor Appointment</h5>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger mt-3 container">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container my-3">
        <div class="mb-3">
            <a href="{{ url()->previous() }}" class="btn  btn-sm btn-outline-secondary">
                <i class="fa fa-arrow-left me-1"></i> Back
            </a>
        </div>
        {{-- Doctor Info --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <img src="{{ $doctor->photo ? Storage::url('doctors/' . $doctor->photo) : asset('assets/image/default.png') }}"
                        alt="Doctor Photo" width="60" height="60" class="rounded-circle border me-3">
                    <div>
                        <h6 class="mb-1">Dr. {{ $doctor->name }}</h6>
                        <small class="text-muted d-block">{{ $doctor->department->name }}</small>
                        <small class="text-muted d-block">{{ $doctor->qualification }}</small>
                    </div>
                </div>
                <div>
                    <h6 class="mb-2">Available Days:</h6>
                    @foreach ($doctorAvailableDays as $day)
                        <span class="badge bg-light text-dark border me-1">{{ $day }}</span>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Date Selector --}}
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0">Choose Date and Time</h6>
            </div>
            <div class="card-body">
                <div class="d-flex overflow-auto gap-2 flex-nowrap mb-3" id="date-buttons">
                    @for ($i = 0; $i < 30; $i++)
                        @php
                            $date = now()->addDays($i);
                            $dayName = $date->format('l');
                            if (!in_array($dayName, $doctorAvailableDays)) {
                                continue;
                            }

                        @endphp
                        <button style="min-width: 100px;"
                            class="btn btn-sm btn-outline-primary date-btn px-3 py-2 text-center"
                            data-date="{{ $date->format('Y-m-d') }}">
                            <div class="d-flex flex-column">
                                <p class="mb-0">{{ $date->format('D') }}</p>
                                <small>{{ $date->format('d M') }}</small>
                            </div>
                        </button>
                    @endfor
                </div>

                {{-- Slots --}}
                <div id="slots-container">
                    <p class="text-muted">Select a date to view available slots.</p>
                </div>

                {{-- Form --}}
                <div class="appointment-form mt-4 p-4 col-md-6 border rounded d-none" id="appointment-form">
                    <form action="{{ route('book.appointment') }}" method="POST">
                        @csrf
                        <input type="hidden" name="doctor_id" id="doctor_id" value="{{ $doctor->id }}">
                        <input type="hidden" name="appointment_date" id="appointment_date">
                        <input type="hidden" name="slot" id="slot">

                        <div class="mb-3">
                            <label for="patient_name" class="form-label">Patient Name *</label>
                            <input type="text" name="patient_name" class="form-control form-control-sm" required>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Contact Number *</label>
                            <input type="tel" name="phone" class="form-control form-control-sm" pattern="[0-9]{10}"
                                maxlength="10" minlength="10" required title="Phone number must be 10 digits">
                        </div>

                        <button type="submit" class="btn btn-sm btn-primary">Book Appointment</button>
                    </form>
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
