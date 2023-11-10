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
            <div class="d-flex justify-content-between mb-3">
                <h4>{{ __('Prayer Time') }}</h4>

                <div class="d-flex">
                    <small>
                        {{ $this->prayerTimeLocation }}<br>
                        {{ now()->toHijri()->format('d F Y') }}
                    </small>

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
                </div>
            </div>

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
                            <div class="ms-2 me-auto">
                                {{ \Carbon\Carbon::createFromTimestamp($prayerTimes->{$prayerName->value})
                                    ->format('h:i a') }}
                            </div>
                            <span @class([
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
            <div class="d-flex justify-content-between mb-3">
                <h4>{{ __('Prayer Time') }}</h4>

                <small>
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
            </div>

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

                <div class="row mb-5">
                    <div class="col">
                        <label for="locale" class="form-label">
                            {{ __('Language') }}
                        </label>
                        <select class="form-select" id="locale" wire:model="locale">
                            @foreach (['en' => __('English'), 'ms' => __('Malay')] as $code => $language)
                                <option
                                    value="{{ $code }}"
                                >
                                    {{ __($language) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col">
                        <label for="code" class="form-label">
                            {{ __('Theme') }}
                        </label>
                        <select class="form-select" id="code" wire:model="theme">
                            @foreach (['dark', 'light'] as $theme)
                                <option
                                    value="{{ $theme }}"
                                >
                                    {{ __(ucwords($theme)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3 text-end">
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
