@extends('layouts.admin') {{-- основной шаблон админки --}}

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Список заявок</h1>

    {{-- Фильтр --}}
    <form method="GET" class="mb-4 flex gap-2 items-end">
        <div>
            <label>Email</label>
            <input type="text" name="email" value="{{ request('email') }}" class="border rounded px-2 py-1">
        </div>
        <div>
            <label>Телефон</label>
            <input type="text" name="phone" value="{{ request('phone') }}" class="border rounded px-2 py-1">
        </div>
        <div>
            <label>Статус</label>
            <select name="status" class="border rounded px-2 py-1">
                <option value="">Все</option>
                <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>Новый</option>
                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>В работе</option>
                <option value="processed" {{ request('status') == 'processed' ? 'selected' : '' }}>Обработан</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-1 rounded">Фильтровать</button>
    </form>

    {{-- Таблица заявок --}}
    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-2 py-1">ID</th>
                <th class="border px-2 py-1">Клиент</th>
                <th class="border px-2 py-1">Email</th>
                <th class="border px-2 py-1">Телефон</th>
                <th class="border px-2 py-1">Тема</th>
                <th class="border px-2 py-1">Статус</th>
                <th class="border px-2 py-1">Дата</th>
                <th class="border px-2 py-1">Действия</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tickets as $ticket)
            <tr>
                <td class="border px-2 py-1">{{ $ticket->id }}</td>
                <td class="border px-2 py-1">{{ $ticket->customer?->name ?? '-' }}</td>
                <td class="border px-2 py-1">{{ $ticket->customer?->email ?? '-' }}</td>
                <td class="border px-2 py-1">{{ $ticket->customer?->phone ?? '-' }}</td>
                <td class="border px-2 py-1">{{ $ticket->subject }}</td>
                <td class="border px-2 py-1">{{ $ticket->status }}</td>
                <td class="border px-2 py-1">{{ $ticket->created_at->format('d.m.Y H:i') }}</td>
                <td class="border px-2 py-1">
                    <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="text-blue-600">Просмотр</a> |
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="border px-2 py-1 text-center">Заявок нет</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
