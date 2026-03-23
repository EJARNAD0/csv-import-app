<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CSV Import</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 p-6">

<div class="max-w-5xl mx-auto bg-white p-6 rounded shadow">

    <h1 class="text-2xl font-bold mb-4">CSV Upload</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-2 mb-4 rounded">
            {{ $errors->first() }}
        </div>
    @endif

    <!-- Upload -->
    <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data" class="mb-6">
        @csrf
        <input type="file" name="file" class="border p-2 rounded w-full mb-2">
        <button class="bg-blue-500 text-white px-4 py-2 rounded">Upload</button>
    </form>

    <!-- Search -->
    <form method="GET" class="mb-4">
        <input type="text" name="search" placeholder="Search..."
               value="{{ request('search') }}"
               class="border p-2 rounded w-full">
    </form>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full border">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-2 border">Name</th>
                    <th class="p-2 border">Email</th>
                    <th class="p-2 border">Amount</th>
                    <th class="p-2 border">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $t)
                    <tr>
                        <td class="p-2 border">{{ $t->name }}</td>
                        <td class="p-2 border">{{ $t->email }}</td>
                        <td class="p-2 border">{{ $t->amount }}</td>
                        <td class="p-2 border">{{ $t->date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $transactions->links() }}
    </div>

</div>

</body>
</html>