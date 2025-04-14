@extends('layouts.master')

@section('admincontent')
    <div class="container-fluid p-4">
        <div class="row">
            <div class="col-lg-12">


                <div class="card shadow">
                    <div class="card-header  d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Doctors</h5>
                        <a href="{{ route('doctors.create') }}" class="btn btn-primary btn-sm px-3 float-end">
                            Add Doctor
                        </a>

                    </div>

                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle text-nowrap">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" style="width: 5%;">#</th>
                                        <th>Name</th>
                                        <th>Department</th>
                                        <th>Qualification</th>
                                        <th>Mobile</th>
                                        <th>Schedule</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody">
                                    @forelse ($doctors as $doctor)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if ($doctor->photo)
                                                    <img src="{{ Storage::url('doctors/' . $doctor->photo) }}"
                                                        alt="Doctor Photo" width="40" height="40"
                                                        class="rounded-circle border">
                                                @else
                                                    <img src="{{ asset('assets/image/default.png') }}" alt="No Photo"
                                                        width="40" height="40" class="rounded-circle border">
                                                @endif
                                                <span>{{ $doctor->name }}</span>
                                            </td>
                                            <td>{{ $doctor->department->name }}</td>
                                            <td>{{ $doctor->qualification }}</td>
                                            <td>{{ $doctor->phone }}</td>
                                            <td>
                                                <a href="{{ route('doctors.availability', $doctor->id) }}"
                                                    class="btn btn-outline-primary btn-sm">Set Schedule</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">No data found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-end mt-4">
                            {{ $doctors->links() }}
                        </div>
                    </div>
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
