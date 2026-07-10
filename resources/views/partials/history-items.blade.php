@forelse($history as $item)
    <div class="card">
        <div class="card-header-actions">
            <div class="number">
                {{ number_format($item->number, 2) }}
            </div>
            <input type="checkbox" class="checkbox-custom" onchange="mapBulkSelection(this, {{ $item->id }})">
        </div>

        <div class="card-meta">
            <span class="meta-badge">{{ $item->locale }}</span>
            <span class="meta-badge">{{ $item->mode }}</span>
            @if($item->currency)
                <span class="meta-badge" style="color: #60a5fa;">{{ $item->currency }}</span>
            @endif
        </div>

        <div class="words">
            {{ $item->words }}
        </div>

        <div class="card-footer-actions">
            <button class="icon-btn {{ $item->is_favorite ? 'active' : '' }}" onclick="invertFavoriteState({{ $item->id }}, this)">
                <i class="ti ti-star-filled fs-3"></i>
            </button>
            <button class="icon-btn" onclick="copyDataString('{{ addslashes($item->words) }}')">
                <i class="ti ti-copy fs-3"></i>
            </button>
            <button class="icon-btn" style="margin-left: auto; color: #fca5a5;" onclick="triggerSingleDeletion('{{ route('delete.number', $item->id) }}')">
                <i class="ti ti-trash fs-3"></i>
            </button>
        </div>
    </div>
@empty
    <div class="text-center w-full py-5" style="color: var(--text-muted); grid-column: 1 / -1;">
        <i class="ti ti-database-off fs-1 d-block mb-2" style="opacity: 0.3;"></i>
        <p class="font-medium">No system conversion metrics match the current filters.</p>
    </div>
@endforelse