<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spell Number Engine</title>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Space Grotesk', sans-serif; }
        :root { --glass-bg: rgba(255, 255, 255, 0.04); --glass-border: rgba(255, 255, 255, 0.08); --text-primary: #ffffff; --text-muted: #94a3b8; --bg-main: #020617; }
        body.light-theme { --glass-bg: rgba(15, 23, 42, 0.04); --glass-border: rgba(15, 23, 42, 0.08); --text-primary: #0f172a; --text-muted: #475569; --bg-main: #f8fafc; }
        body { min-height: 100vh; background: var(--bg-main); padding: 40px; color: var(--text-primary); transition: background 0.3s, color 0.3s; }
        .container { max-width: 1300px; margin: auto; }
        .hero { background: var(--glass-bg); border: 1px solid var(--glass-border); backdrop-filter: blur(20px); border-radius: 28px; padding: 35px; margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; gap: 30px; box-shadow: 0 20px 40px rgba(0,0,0,0.2); }
        .hero-left { flex: 1; }
        .hero-left h1 { font-size: 48px; margin-bottom: 12px; font-weight: 700; }
        .hero-left p { color: var(--text-muted); line-height: 1.7; max-width: 500px; }
        .hero-right { width: 420px; background: var(--glass-bg); border: 1px solid var(--glass-border); backdrop-filter: blur(30px); border-radius: 24px; padding: 35px; }
        .hero-right h2 { margin-bottom: 20px; font-size: 22px; }
        .form-control-custom { width: 100%; padding: 14px; border-radius: 12px; border: 1px solid var(--glass-border); background: rgba(0,0,0,0.1); color: var(--text-primary); outline: none; font-size: 15px; margin-bottom: 15px; }
        .theme-select { appearance: none; cursor: pointer; }
        .convert-btn { width: 100%; padding: 14px; border: none; border-radius: 12px; background: linear-gradient(135deg, #7c3aed, #2563eb); color: white; font-size: 15px; font-weight: 600; cursor: pointer; transition: 0.3s; }
        .convert-btn:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(37,99,235,0.2); }
        .live-preview-box { margin-top: 15px; padding: 14px; background: rgba(37,99,235,0.1); border-left: 4px solid #2563eb; border-radius: 8px; font-size: 14px; min-height: 48px; word-break: break-word; color: #60a5fa; }
        .toolbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; gap: 15px; flex-wrap: wrap; background: var(--glass-bg); padding: 15px; border-radius: 20px; border: 1px solid var(--glass-border); }
        .filter-group { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
        .action-bar { display: flex; gap: 10px; }
        .btn-action { padding: 10px 18px; border: none; border-radius: 10px; font-weight: 600; cursor: pointer; transition: 0.2s; display: flex; align-items: center; gap: 8px; font-size: 13px; }
        .btn-danger { background: rgba(239,68,68,0.2); color: #fca5a5; }
        .btn-danger:hover { background: #ef4444; color: white; }
        .btn-success { background: rgba(34,197,94,0.2); color: #86efac; }
        .btn-success:hover { background: #22c55e; color: white; }
        .btn-secondary { background: rgba(255,255,255,0.1); color: var(--text-primary); }
        .btn-secondary:hover { background: rgba(255,255,255,0.2); }
        .history-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 22px; }
        .card { position: relative; overflow: hidden; background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 24px; padding: 22px; transition: 0.4s; backdrop-filter: blur(10px); }
        .card:hover { transform: translateY(-6px); box-shadow: 0 20px 35px rgba(0, 0, 0, 0.25); }
        .card-header-actions { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; }
        .number { font-size: 30px; font-weight: 700; color: var(--text-primary); max-width: 80%; overflow: hidden; text-overflow: ellipsis; }
        .card-meta { display: flex; gap: 6px; margin-bottom: 10px; flex-wrap: wrap; }
        .meta-badge { font-size: 10px; text-transform: uppercase; font-weight: 700; padding: 2px 8px; border-radius: 6px; background: rgba(255,255,255,0.1); color: var(--text-muted); }
        .words { color: var(--text-muted); line-height: 1.6; font-size: 13px; min-height: 60px; word-break: break-word; }
        .card-footer-actions { display: flex; gap: 10px; margin-top: 15px; border-top: 1px solid var(--glass-border); pt: 12px; }
        .icon-btn { background: none; border: none; color: var(--text-muted); cursor: pointer; transition: 0.2s; padding: 6px; border-radius: 8px; }
        .icon-btn:hover { color: var(--text-primary); background: rgba(255,255,255,0.1); }
        .icon-btn.active { color: #eab308; }
        .pagination-wrapper { margin-top: 40px; display: flex; justify-content: center; }
        .theme-toggle-fixed { position: fixed; bottom: 30px; left: 30px; width: 56px; height: 56px; border-radius: 50%; background: linear-gradient(135deg, #7c3aed, #2563eb); border: none; color: white; cursor: pointer; display: flex; justify-content: center; align-items: center; box-shadow: 0 10px 25px rgba(0,0,0,0.3); z-index: 1000; }
        .toast-notification { position: fixed; top: 30px; right: 30px; background: rgba(15,23,42,0.9); border: 1px solid var(--glass-border); padding: 16px 24px; border-radius: 14px; box-shadow: 0 20px 40px rgba(0,0,0,0.4); display: flex; align-items: center; gap: 12px; transform: translateY(-100px); opacity: 0; transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); z-index: 10000; backdrop-filter: blur(10px); }
        .toast-notification.show { transform: translateY(0); opacity: 1; }
        .modal-overlay { position: fixed; id: overlay; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.6); backdrop-filter: blur(5px); z-index: 99999; display: flex; justify-content: center; align-items: center; opacity: 0; pointer-events: none; transition: 0.3s; }
        .modal-overlay.show { opacity: 1; pointer-events: auto; }
        .modal-container { background: #0f172a; border: 1px solid var(--glass-border); width: 400px; padding: 30px; border-radius: 20px; box-shadow: 0 25px 50px rgba(0,0,0,0.5); text-align: center; transform: scale(0.9); transition: 0.3s; color: white; }
        .modal-overlay.show .modal-container { transform: scale(1); }
        .modal-title { font-size: 20px; margin-bottom: 10px; font-weight: 600; }
        .modal-desc { color: #94a3b8; font-size: 14px; margin-bottom: 25px; line-height: 1.5; }
        .modal-buttons { display: flex; justify-content: center; gap: 12px; }
        .checkbox-custom { width: 18px; height: 18px; cursor: pointer; accent-color: #2563eb; }
    </style>
</head>
<body>

    <button class="theme-toggle-fixed" onclick="togglePlatformTheme()">
        <i class="ti ti-sun fs-2" id="theme-icon"></i>
    </button>

    <div id="toast" class="toast-notification">
        <i class="ti ti-info-circle text-primary fs-2"></i>
        <span id="toast-message" class="text-white font-medium">Notification event recorded</span>
    </div>

    <div id="confirm-modal" class="modal-overlay">
        <div class="modal-container">
            <div class="modal-title" id="modal-title-text">Confirm Action</div>
            <div class="modal-desc" id="modal-desc-text">Are you sure you want to perform this structural reset?</div>
            <div class="modal-buttons">
                <button class="btn-action btn-secondary" onclick="closeConfirmationModal()">Cancel</button>
                <button class="btn-action btn-danger" id="modal-confirm-btn">Confirm</button>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="hero">
            <div class="hero-left">
                <h1>🔢 Spell Number Engine</h1>
                <p>Convert numbers into semantic textual interpretations natively supporting currency configurations, internationalized localization protocols, and localized language translation trees.</p>
            </div>

            <div class="hero-right">
                <h2>Conversion Matrix</h2>
                <form id="conversion-form" method="POST" action="{{ route('convert.number') }}">
                    @csrf
                    <input type="number" step="any" name="number" id="input-number" class="form-control-custom" placeholder="Enter integer or decimal..." required>
                    
                    <select name="locale" id="input-locale" class="form-control-custom theme-select">
                        <option value="en">English (Global)</option>
                        <option value="es">Spanish (Castilian)</option>
                        <option value="fr">French (Standard)</option>
                        <option value="pt">Portuguese</option>
                        <option value="hi">Hindi (Devanagari)</option>
                    </select>

                    <select name="mode" id="input-mode" class="form-control-custom theme-select" onchange="toggleCurrencyDropdown(this.value)">
                        <option value="plain">Plain Text Representation</option>
                        <option value="currency">Financial Currency Spelling</option>
                    </select>

                    <div id="currency-wrapper" style="display: none;">
                        <select name="currency" id="input-currency" class="form-control-custom theme-select">
                            <option value="USD">USD (Dollars / Cents)</option>
                            <option value="EUR">EUR (Euros)</option>
                            <option value="GBP">GBP (Pounds)</option>
                            <option value="INR">INR (Rupees / Paisa)</option>
                        </select>
                    </div>

                    <button type="submit" class="convert-btn">Convert Parameters</button>
                </form>

                <div id="live-preview-display" class="live-preview-box" style="display: none;"></div>
            </div>
        </div>

        <div class="toolbar">
            <div class="filter-group">
                <input type="text" id="search-input" class="form-control-custom mb-0" style="width: 220px;" placeholder="Search catalog..." value="{{ $search }}">
                
                <select id="sort-select" class="form-control-custom theme-select mb-0" style="width: 160px;" onchange="executeServerFilter()">
                    <option value="newest" {{ $sort == 'newest' ? 'selected' : '' }}>Newest Entries</option>
                    <option value="oldest" {{ $sort == 'oldest' ? 'selected' : '' }}>Oldest Entries</option>
                    <option value="num_asc" {{ $sort == 'num_asc' ? 'selected' : '' }}>Value: Low to High</option>
                    <option value="num_desc" {{ $sort == 'num_desc' ? 'selected' : '' }}>Value: High to Low</option>
                </select>

                <select id="filter-select" class="form-control-custom theme-select mb-0" style="width: 150px;" onchange="executeServerFilter()">
                    <option value="all" {{ request('filter') == 'all' ? 'selected' : '' }}>Show All</option>
                    <option value="favorites" {{ request('filter') == 'favorites' ? 'selected' : '' }}>Pinned Items</option>
                </select>

                <input type="date" id="date-from" class="form-control-custom mb-0" style="width: 140px;" onchange="executeServerFilter()" value="{{ $date_from }}">
                <input type="date" id="date-to" class="form-control-custom mb-0" style="width: 140px;" onchange="executeServerFilter()" value="{{ $date_to }}">
            </div>

            <div class="action-bar">
                <button class="btn-action btn-secondary" onclick="handleBulkDelete()" id="bulk-delete-btn" style="display: none;">
                    <i class="ti ti-checkbox"></i> Delete Selected (<span id="bulk-count">0</span>)
                </button>
                <a href="{{ route('export.csv') }}" class="btn-action btn-success">
                    <i class="ti ti-download"></i> Export CSV
                </a>
                <button class="btn-action btn-danger" onclick="triggerClearAllHistory()">
                    <i class="ti ti-trash-x"></i> Purge All
                </button>
            </div>
        </div>

        <div class="history-grid" id="history-items-container">
            @include('partials.history-items')
        </div>

        <div class="pagination-wrapper" id="pagination-links-container">
            {!! $history->links() !!}
        </div>
    </div>

    <script>
        let selectedBulkIds = [];

        function togglePlatformTheme() {
            document.body.classList.toggle('light-theme');
            const isLight = document.body.classList.contains('light-theme');
            localStorage.setItem('theme-preference', isLight ? 'light' : 'dark');
            document.getElementById('theme-icon').className = isLight ? 'ti ti-moon fs-2' : 'ti ti-sun fs-2';
        }

        if (localStorage.getItem('theme-preference') === 'light') {
            document.body.classList.add('light-theme');
            document.getElementById('theme-icon').className = 'ti ti-moon fs-2';
        }

        function triggerToastNotification(msg) {
            const toast = document.getElementById('toast');
            document.getElementById('toast-message').innerText = msg;
            toast.classList.add('show');
            setTimeout(() => { toast.classList.remove('show'); }, 3500);
        }

        function openConfirmationModal(title, desc, callback) {
            document.getElementById('modal-title-text').innerText = title;
            document.getElementById('modal-desc-text').innerText = desc;
            const modal = document.getElementById('confirm-modal');
            modal.classList.add('show');
            document.getElementById('modal-confirm-btn').onclick = function() {
                callback();
                closeConfirmationModal();
            };
        }

        function closeConfirmationModal() {
            document.getElementById('confirm-modal').classList.remove('show');
        }

        function toggleCurrencyDropdown(val) {
            document.getElementById('currency-wrapper').style.display = (val === 'currency') ? 'block' : 'none';
            triggerLivePreviewRequest();
        }

        const inputNumber = document.getElementById('input-number');
        const inputLocale = document.getElementById('input-locale');
        const inputMode = document.getElementById('input-mode');
        const inputCurrency = document.getElementById('input-currency');
        const previewBox = document.getElementById('live-preview-display');

        [inputNumber, inputLocale, inputMode, inputCurrency].forEach(element => {
            element.addEventListener('input', triggerLivePreviewRequest);
        });

        function triggerLivePreviewRequest() {
            const num = inputNumber.value;
            if (!num) {
                previewBox.style.display = 'none';
                return;
            }
            
            fetch(`/live-preview?number=${num}&locale=${inputLocale.value}&mode=${inputMode.value}&currency=${inputCurrency.value}`)
                .then(res => res.json())
                .then(data => {
                    if (data.words) {
                        previewBox.innerText = data.words;
                        previewBox.style.display = 'block';
                    } else {
                        previewBox.style.display = 'none';
                    }
                });
        }

        document.getElementById('conversion-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    triggerToastNotification(data.message);
                    inputNumber.value = '';
                    previewBox.style.display = 'none';
                    executeServerFilter();
                }
            });
        });

        let searchTimeout;
        document.getElementById('search-input').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => { executeServerFilter(); }, 400);
        });

        function executeServerFilter() {
            const search = document.getElementById('search-input').value;
            const sort = document.getElementById('sort-select').value;
            const filter = document.getElementById('filter-select').value;
            const from = document.getElementById('date-from').value;
            const to = document.getElementById('date-to').value;

            fetch(`/?search=${search}&sort=${sort}&filter=${filter}&date_from=${from}&date_to=${to}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                document.getElementById('history-items-container').innerHTML = data.html;
                document.getElementById('pagination-links-container').innerHTML = data.pagination;
                selectedBulkIds = [];
                evaluateBulkActionBarState();
            });
        }

        function copyDataString(text) {
            navigator.clipboard.writeText(text).then(() => {
                triggerToastNotification('Text copied to system clipboard.');
            });
        }

        function invertFavoriteState(id, element) {
            fetch(`/toggle-favorite/${id}`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    element.classList.toggle('active', data.is_favorite);
                    triggerToastNotification(data.is_favorite ? 'Item pinned to favorites.' : 'Item removed from favorites.');
                }
            });
        }

        function mapBulkSelection(checkbox, id) {
            if (checkbox.checked) {
                selectedBulkIds.push(id);
            } else {
                selectedBulkIds = selectedBulkIds.filter(item => item !== id);
            }
            evaluateBulkActionBarState();
        }

        function evaluateBulkActionBarState() {
            const btn = document.getElementById('bulk-delete-btn');
            const count = document.getElementById('bulk-count');
            if (selectedBulkIds.length > 0) {
                count.innerText = selectedBulkIds.length;
                btn.style.display = 'inline-flex';
            } else {
                btn.style.display = 'none';
            }
        }

        function handleBulkDelete() {
            openConfirmationModal(
                'Delete Selected Items',
                `Are you sure you want to permanently delete the ${selectedBulkIds.length} selected record conversions?`,
                function() {
                    fetch('/bulk-delete', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ ids: selectedBulkIds })
                    })
                    .then(res => res.json())
                    .then(data => {
                        triggerToastNotification(data.message);
                        executeServerFilter();
                    });
                }
            );
        }

        function triggerClearAllHistory() {
            openConfirmationModal(
                'Purge Conversion History',
                'Are you completely sure you want to clear the entire record history logs permanently?',
                function() {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route("clear.all") }}';
                    form.innerHTML = `@csrf @method('DELETE')`;
                    document.body.appendChild(form);
                    form.submit();
                }
            );
        }

        function triggerSingleDeletion(actionUrl) {
            openConfirmationModal(
                'Delete Conversion Entry',
                'Are you sure you want to permanently clear this single conversion tracking card?',
                function() {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = actionUrl;
                    form.innerHTML = `@csrf @method('DELETE')`;
                    document.body.appendChild(form);
                    form.submit();
                }
            );
        }
    </script>
</body>
</html>