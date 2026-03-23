# PHP_Laravel12_SpellNumber

## Introduction

The PHP_Laravel12_SpellNumber project is a Laravel 12 based web application designed to convert numerical values into their corresponding word format.

This project demonstrates key Laravel concepts such as MVC architecture, request validation, package integration, and database operations.

It provides a user-friendly interface where users can input numbers, view their converted word format, and maintain a history of previous conversions stored in a MySQL database.

---

## Project Overview

The PHP_Laravel12_SpellNumber project is built using Laravel 12 and follows a clean MVC structure.

### Key Functionalities:
- Accept numeric input from the user
- Convert numbers into words using the SpellNumber package
- Store each conversion in the database
- Display previously converted numbers (history)
- Provide a clean and responsive user interface

### Technologies Used:
- Laravel 12
- PHP 8.2+
- MySQL Database
- Blade Templates (Laravel Views)
- SpellNumber Package

### Workflow:
1. User enters a number in the form  
2. Request is sent to the controller  
3. SpellNumber converts the number into words  
4. Data is saved into the database  
5. Converted result is displayed on the UI along with history  

---

## Step 1: Create Laravel Project

```bash
composer create-project laravel/laravel PHP_Laravel12_SpellNumber "12.*"
cd PHP_Laravel12_SpellNumber
```
---

## Step 2: Install SpellNumber Package

```bash
composer require rmunate/spell-number
```
---

## Step 3: Configure Database

Update .env

```.env
DB_DATABASE=spellnumber_db
DB_USERNAME=root
DB_PASSWORD=
```
Run Migration Command:

```bash
php artisan migrate
```
---

## Step 4: Create Migration

```bash
php artisan make:migration create_conversions_table
```

File: database/migrations/xxxx_create_conversions_table.php

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('conversions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('number');
            $table->string('words');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversions');
    }
};
```
Run migration:

```bash
php artisan migrate
```
---

## Step 5: Create Model

```bash
php artisan make:model Conversion
```
File: app/Models/Conversion.php

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversion extends Model
{
    use HasFactory;
    protected $fillable = [
        'number',
        'words'
    ];
}
```
---

## Step 6: Create Controller

```bash
php artisan make:controller SpellNumberController
```

File: app/Http/Controllers/SpellNumberController.php

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversion;
use Rmunate\Utilities\SpellNumber;

class SpellNumberController extends Controller
{
    public function index()
    {
        $history = Conversion::latest()->get();
        return view('spellnumber', compact('history'));
    }

    public function convert(Request $request)
    {
        $request->validate([
            'number' => 'required|numeric'
        ]);

        $number = $request->input('number');

        $spell = SpellNumber::value($number)->toLetters();

        // Save to database
        Conversion::create([
            'number' => $number,
            'words' => $spell,
        ]);

        return redirect()->back()->with('success', "The number {$number} is spelled as: {$spell}");
    }
}
```
---

## Step 7: Define Routes

File: routes/web.php

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpellNumberController;

Route::get('/', [SpellNumberController::class, 'index']);
Route::post('/convert', [SpellNumberController::class, 'convert'])->name('convert.number');
```
---

## Step 8: Create Blade View

File: resources/views/spellnumber.blade.php

```blade
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
```

---

## Step 9: Run Project

```bash
php artisan serve
```
Open:

```bash
http://127.0.0.1:8000
```
---

## Output

<img src="screenshots/Screenshot 2026-03-23 140751.png" width="1000">

<img src="screenshots/Screenshot 2026-03-23 140818.png" width="1000">

---

## Project Structure

```
PHP_Laravel12_SpellNumber/
│
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── SpellNumberController.php
│   │
│   ├── Models/
│   │   └── Conversion.php
│
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│       └── xxxx_create_conversions_table.php
│
│
├── resources/
│   ├── views/
│       └── spellnumber.blade.php
│   
│
├── routes/
│   └── web.php
│
│
├── vendor/
│   └── rmunate/
│       └── spell-number/
│
├── .env
├── .env.example
├── artisan
├── composer.json
├── composer.lock
└── README.md
```
---

Your PHP_Laravel12_SpellNumber Project is now ready!


