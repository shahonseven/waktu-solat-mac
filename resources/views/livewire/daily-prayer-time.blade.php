<div>
    <div class="tab-content">
        <div
            @class([
                'tab-pane',
                'fade',
                'show' => $activeTab == 'prayer-time',
                'active' => $activeTab == 'prayer-time',
            ])
            id="prayer-time"
            x-transition
        >
            <h3 class="d-flex justify-content-between mb-3">
                {{ __('Prayer Time') }}
                <small class="fs-6">
                    {{ $this->prayerTimeLocation }}
                
                    <button
                        @class([
                            'btn',
                            'btn-outline-light text-dark' => $theme == 'light',
                            'btn-outline-dark text-light' => $theme == 'dark',
                            'border-0',
                        ])
                        type="button"
                        wire:click="$set('activeTab', 'preference')"
                    >
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
                                'fs-6',
                                'text-light' => $this->currentPrayerName == $prayerName->value,
                            ])>{{ $prayerName->label() }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div
            @class([
                'tab-pane',
                'fade',
                'show' => $activeTab == 'preference',
                'active' => $activeTab == 'preference',
            ])
            id="preference"
        >
            <h3 class="d-flex justify-content-between mb-3">
                {{ __('Prayer Time') }}
                <small class="fs-6">
                    {{ __('Preference') }}
                
                    <button
                        @class([
                            'btn',
                            'btn-outline-light text-dark' => $theme == 'light',
                            'btn-outline-dark text-light' => $theme == 'dark',
                            'border-0',
                        ])
                        type="button"
                        wire:click="$set('activeTab', 'prayer-time')"
                    >
                        <i class="bi bi-x-circle"></i>
                    </button>
                </small>
            </h3>

            <form wire:submit="save">
                <div class="mb-3">
                    <label for="code" class="form-label">
                        {{ __('Location') }}
                    </label>
                    <select class="form-select" id="code" wire:model="code">
                        @foreach ($locationCodes as $i => $locations)
                            <optgroup label="{{ $i }}">
                                @foreach ($locations as $location)
                                    <option
                                        value="{{ $location['code'] }}"
                                    >
                                        {{ strtoupper($location['code']) }} - {{ $location['location'] }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="code" class="form-label">
                        {{ __('Theme') }}
                    </label>
                    <select class="form-select" id="code" wire:model="theme">
                        @foreach (['dark', 'light'] as $theme)
                            <option
                                value="{{ $theme }}"
                            >
                                {{ ucwords($theme) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="text-end">
                    <button
                        class="btn btn-primary"
                        type="submit"
                    >
                        {{ __('Update') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
