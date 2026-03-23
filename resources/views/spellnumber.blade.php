<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spell Number</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea, #764ba2);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            width: 420px;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        input {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
        }

        button {
            padding: 12px;
            border: none;
            background: #667eea;
            color: #fff;
            font-weight: 500;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #5a67d8;
        }

        .success {
            margin-top: 15px;
            padding: 10px;
            background: #d4edda;
            color: #155724;
            border-radius: 6px;
            font-size: 14px;
        }

        .history {
            margin-top: 20px;
        }

        .history h3 {
            margin-bottom: 10px;
            color: #333;
        }

        ul {
            list-style: none;
            max-height: 180px;
            overflow-y: auto;
        }

        li {
            background: #f4f6f9;
            margin-bottom: 8px;
            padding: 8px 10px;
            border-radius: 6px;
            font-size: 14px;
        }

    </style>
</head>

<body>

<div class="container">

    <h2>🔢 Number to Words</h2>

    <!-- Success Message -->
    @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form -->
    <form action="{{ route('convert.number') }}" method="POST">
        @csrf
        <input type="number" name="number" placeholder="Enter number..." required>
        <button type="submit">Convert</button>
    </form>

    <!-- History -->
    <div class="history">
        <h3>📜 History</h3>

        @if(isset($history) && count($history) > 0)
            <ul>
                @foreach($history as $item)
                    <li>
                        <strong>{{ $item->number }}</strong> → {{ $item->words }}
                    </li>
                @endforeach
            </ul>
        @else
            <p>No history yet.</p>
        @endif
    </div>

</div>

</body>
</html>