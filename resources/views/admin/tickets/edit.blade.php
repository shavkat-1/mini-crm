@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Редактировать заявку #{{ $ticket->id }}</h1>

    <form action="{{ route('admin.tickets.update', $ticket->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label>Статус</label>
            <select name="status" class="border rounded px-2 py-1">
                <option value="new" {{ $ticket->status == 'new' ? 'selected' : '' }}>Новый</option>
                <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>В работе</option>
                <option value="processed" {{ $ticket->status == 'processed' ? 'selected' : '' }}>Обработан</option>
            </select>
        </div>

        <div class="mb-4">
            <label>Ответ менеджера</label>
            <input type="datetime-local" name="answered_at" value="{{ $ticket->answered_at?->format('Y-m-d\TH:i') }}" class="border rounded px-2 py-1">
        </div>

        <div class="mb-4">
            <label>Добавить файлы</label>
            <input type="file" name="files[]" multiple>
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Сохранить</button>
        <a href="{{ route('admin.tickets.index') }}" class="ml-2 text-blue-600">Отмена</a>
    </form>
</div>
@endsection
