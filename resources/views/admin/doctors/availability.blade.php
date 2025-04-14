@extends('layouts.master')

@section('admincontent')
    <div class="container py-4">

        <h5 class="mb-4">Set Availability for Dr. {{ $doctor->name }}</h5>

        <form action="" method="POST">
            @csrf

            @foreach (['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                @php
                    $selectedSlots = $schedules[$day] ?? collect();
                    $selectedSlotValues = $selectedSlots
                        ->map(function ($item) {
                            return \Carbon\Carbon::parse($item->start_time)->format('H:i') .
                                ' - ' .
                                \Carbon\Carbon::parse($item->end_time)->format('H:i');
                        })
                        ->toArray();
                @endphp


                <div class="mb-3 border p-3 rounded">
                    <label class="form-check-label fw-bold d-block mb-2">
                        <input type="checkbox" class="form-check-input me-2 day-toggle" name="days[]"
                            value="{{ $day }}"{{ count($selectedSlots) > 0 ? 'checked' : '' }}>
                        {{ $day }}
                    </label>

                    <div class="row ms-3 slot-options"
                        style="{{ count($selectedSlots) > 0 ? 'display: flex;' : 'display: none;' }}">
                        @foreach ($slots as $slot)
                            <div class="col-md-3 mb-2">
                                <label class="form-check">
                                    <input type="checkbox" class="form-check-input" name="slots[{{ $day }}][]"
                                        value="{{ $slot }}"
                                        {{ in_array($slot, $selectedSlotValues) ? 'checked' : '' }}>
                                    {{ $slot }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach


            <button type="submit" class="btn btn-primary">Save Schedule</button>
        </form>

    </div>

    <script>
        document.querySelectorAll('.day-toggle').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const slotBox = this.closest('.mb-3').querySelector('.slot-options');
                slotBox.style.display = this.checked ? 'flex' : 'none';
            });
        });
        document.querySelector('form').addEventListener('submit', function(e) {
            let isValid = true;
            let selectedDays = document.querySelectorAll('.day-toggle:checked');

            selectedDays.forEach(dayCheckbox => {
                const slotContainer = dayCheckbox.closest('.mb-3').querySelector('.slot-options');
                const slotChecked = slotContainer.querySelectorAll('input[type="checkbox"]:checked');
                if (slotChecked.length === 0) {
                    alert(`Please select at least one time slot for ${dayCheckbox.value}.`);
                    isValid = false;
                }
            });

            if (!isValid) {
                e.preventDefault();
            }
        });
    </script>
@endsection
