@extends('layouts.master')

@section('admincontent')
    <div class="container-fluid p-4">
        <div class="row">
            <div class="col-lg-12">


                <div class="card shadow">
                    <div class="card-header  d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Appointments</h5>


                    </div>

                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle text-nowrap">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" style="width: 5%;">#</th>
                                        <th>Patient Name</th>
                                        <th>Mobile</th>
                                        <th>Doctor</th>
                                        <th>Appointment Date</th>
                                        <th>Slot</th>
                                        <th>Booked on</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody">
                                    @forelse ($appointments as $appointment)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                {{ $appointment->patient_name }}
                                            </td>
                                            <td>{{ $appointment->phone }}</td>
                                            <td>{{ $appointment->doctor->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d-m-Y') }}
                                            </td>
                                            <td>{{ $appointment->slot }}</td>
                                            <td>{{ \Carbon\Carbon::parse($appointment->created_at)->format('d-m-Y') }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">No data found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-end mt-4">
                            {{ $appointments->links() }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
