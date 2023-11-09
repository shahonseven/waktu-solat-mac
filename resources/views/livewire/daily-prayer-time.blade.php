<div>
    <h3 class="d-flex justify-content-between mb-3">
        {{ __('Prayer Time') }}
        <small class="text-body-secondary">
            {{ $this->prayerTimeLocation }}
        
            <button class="btn btn-outline-light text-body-secondary" type="button">
                <i class="bi bi-sliders2"></i>
            </button>
        </small>
    </h3>

    <div wire:poll>
        <ul class="list-group">
            @foreach ($this->prayerNames as $i => $prayerName)
                <li @class([
                    'list-group-item',
                    'd-flex',
                    'justify-content-between',
                    'align-items-start',
                    'active' => $this->currentPrayerName == $prayerName->value,
                ])>
                    <div class="ms-2 me-auto fs-2">
                        {{ \Carbon\Carbon::createFromTimestamp($prayerTimes->{$prayerName->value})->format('h:i a') }}
                    </div>
                    <span @class([
                        'fs-5',
                        'text-light' => $this->currentPrayerName == $prayerName->value,
                    ])>{{ $prayerName->label() }}</span>
                </li>
            @endforeach
        </ul>
    </div>
</div>
