<form method="GET">
    <label>Choisir une date:</label>
    <input type="date" name="date" value="{{ $date }}" min="{{ date('Y-m-d') }}">
    <button type="submit">Voir les créneaux</button>
</form>
@if($date)

<form action="/reservations" method="POST">
    @csrf

    <input type="hidden" name="terrain_id" value="{{ $terrain->id }}">
    <input type="hidden" name="date" value="{{ $date }}">
    <input type="hidden" name="start_time" id="start_time">
    <input type="hidden" name="end_time" id="end_time">

    <label>Choisir un créneau:</label>

    <div style="display:flex; flex-wrap:wrap; gap:10px;">

        @foreach($slots as $slot)

            @php
                $isBooked = !in_array($slot, $availableSlots, true);

                $isPast = false;

                if($date == date('Y-m-d') && $slot <= $currentTime){
                    $isPast = true;
                }
            @endphp

            <button type="button"
                onclick="selectSlot('{{ $slot }}')"
                style="
                    padding:10px 15px;
                    border:none;
                    border-radius:8px;
                    cursor:pointer;
                    background-color:
                        {{ $isBooked ? '#FF0000' : ($isPast ? '#999' : '#22c55e') }};
                    color:white;
                "
                {{ ($isBooked || $isPast) ? 'disabled' : '' }}
            >
                {{ $slot }} - {{ date('H:i', strtotime($slot.' +1 hour')) }}
            </button>

        @endforeach

    </div>

    <br>
    <button type="submit">Réserver</button>

</form>

@endif
<script>
function selectSlot(slot) {

    // start_time
    document.getElementById('start_time').value = slot;

    // end_time
    let [h, m] = slot.split(':');
    let endHour = parseInt(h) + 1;

    let endTime =
        (endHour < 10 ? '0' + endHour : endHour) + ':00';

    document.getElementById('end_time').value = endTime;

    // highlight selection (optional)
    document.querySelectorAll('button').forEach(btn => {
        btn.style.outline = "none";
    });

    event.target.style.outline = "3px solid black";
}
</script>
