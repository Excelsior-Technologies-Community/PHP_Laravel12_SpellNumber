<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spell Number</title>

    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Space Grotesk', sans-serif;
        }

        body {
            min-height: 100vh;
            background:
                radial-gradient(circle at top left, #312e81, transparent 30%),
                radial-gradient(circle at bottom right, #0f766e, transparent 30%),
                #020617;
            padding: 40px;
            color: white;
        }

        .container {
            max-width: 1300px;
            margin: auto;
        }

        /* HERO */

        .hero {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(14px);
            border-radius: 28px;
            padding: 35px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 30px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .hero-left {
            flex: 1;
        }

        .hero-left h1 {
            font-size: 52px;
            margin-bottom: 12px;
            line-height: 1;
        }

        .hero-left p {
            color: #cbd5e1;
            line-height: 1.7;
            max-width: 500px;
        }

        .hero-right {
            width: 380px;
            background: white;
            border-radius: 24px;
            padding: 25px;
        }

        /* FORM */

        .hero-right h2 {
            color: #0f172a;
            margin-bottom: 18px;
            font-size: 24px;
        }

        .input-group {
            margin-bottom: 15px;
        }

        .hero-right input {
            width: 100%;
            padding: 15px;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            outline: none;
            font-size: 15px;
        }

        .convert-btn {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 16px;
            background: linear-gradient(135deg, #7c3aed, #2563eb);
            color: white;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        .convert-btn:hover {
            transform: translateY(-2px);
            opacity: 0.95;
        }

        .success {
            margin-top: 15px;
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 12px;
            font-size: 14px;
        }

        /* TOOLBAR */

        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            gap: 15px;
            flex-wrap: wrap;
        }

        .search-box {
            flex: 1;
        }

        .search-box input {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.08);
            color: white;
            outline: none;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .search-box input::placeholder {
            color: #94a3b8;
        }

        .clear-btn {
            padding: 14px 20px;
            border: none;
            border-radius: 16px;
            background: #ef4444;
            color: white;
            cursor: pointer;
            font-weight: 600;
            transition: 0.3s;
        }

        .clear-btn:hover {
            background: #dc2626;
        }

        /* CARDS */

        .history-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 22px;
        }

        .card {
            position: relative;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            padding: 22px;
            transition: 0.4s;
            backdrop-filter: blur(10px);
        }

        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 35px rgba(0, 0, 0, 0.35);
        }

        .card::before {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #7c3aed, #2563eb);
            border-radius: 50%;
            opacity: 0.15;
        }

        .number {
            font-size: 38px;
            font-weight: 700;
            margin-bottom: 12px;
            color: #fff;
        }

        .words {
            color: #cbd5e1;
            line-height: 1.7;
            font-size: 14px;
            min-height: 70px;
        }

        .delete-form {
            margin-top: 20px;
        }

        .delete-btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 14px;
            background: rgba(239, 68, 68, 0.18);
            color: #fca5a5;
            cursor: pointer;
            font-weight: 600;
            transition: 0.3s;
        }

        .delete-btn:hover {
            background: #ef4444;
            color: white;
        }

        /* PAGINATION */

        .pagination-wrapper {
            margin-top: 40px;
            display: flex;
            justify-content: center;
        }

        .custom-pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .custom-pagination a {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            justify-content: center;
            align-items: center;
            text-decoration: none;
            background: rgba(255, 255, 255, 0.08);
            color: white;
            font-weight: 600;
            border: 1px solid rgba(255, 255, 255, 0.08);
            transition: 0.3s;
        }

        .custom-pagination a:hover {
            background: #2563eb;
        }

        .custom-pagination .active {
            background: linear-gradient(135deg, #7c3aed, #2563eb);
            color: white;
        }

        /* MOBILE */

        @media(max-width:900px) {

            .hero {
                flex-direction: column;
            }

            .hero-right {
                width: 100%;
            }

            .hero-left h1 {
                font-size: 38px;
            }

        }
    </style>
</head>

<body>

    <div class="container">

        <!-- HERO -->

        <div class="hero">

            <div class="hero-left">

                <h1>🔢 Spell Number</h1>

                <p>
                    Transform numbers into readable words instantly using Laravel 12.
                    Search, manage, and explore conversion history with a modern experience.
                </p>

            </div>

            <!-- CONVERT BOX -->

            <div class="hero-right">

                <h2>Convert Number</h2>

                <form method="POST" action="{{ route('convert.number') }}">

                    @csrf

                    <div class="input-group">

                        <input type="number" name="number" placeholder="Enter number..." required>

                    </div>

                    <button class="convert-btn">
                        Convert Now
                    </button>

                </form>

                @if(session('success'))

                    <div class="success">
                        {{ session('success') }}
                    </div>

                @endif

            </div>

        </div>

        <!-- TOOLBAR -->

        <div class="toolbar">

            <form method="GET" class="search-box">

                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search history...">

            </form>

            <form method="POST" action="/clear-all">

                @csrf
                @method('DELETE')

                <button class="clear-btn">
                    Clear All
                </button>

            </form>

        </div>

        <!-- HISTORY -->

        <div class="history-grid">

            @foreach($history as $item)

                <div class="card">

                    <div class="number">
                        {{ $item->number }}
                    </div>

                    <div class="words">
                        {{ $item->words }}
                    </div>

                    <form method="POST" action="{{ route('delete.number', $item->id) }}" class="delete-form">

                        @csrf
                        @method('DELETE')

                        <button class="delete-btn">
                            Delete Conversion
                        </button>

                    </form>

                </div>

            @endforeach

        </div>

        <!-- PAGINATION -->

        <div class="pagination-wrapper">

            @if ($history->lastPage() > 1)

                <div class="custom-pagination">

                    @for ($i = 1; $i <= $history->lastPage(); $i++)

                        <a href="{{ $history->url($i) }}" class="{{ ($history->currentPage() == $i) ? 'active' : '' }}">
                            {{ $i }}
                        </a>

                    @endfor

                </div>

            @endif

        </div>

    </div>

</body>

</html>