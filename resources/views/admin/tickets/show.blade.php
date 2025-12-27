@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Заявка #{{ $ticket->id }}</h1>

    <div class="mb-4">
        <strong>Клиент:</strong> {{ $ticket->customer?->name ?? '-' }} <br>
        <strong>Email:</strong> {{ $ticket->customer?->email ?? '-' }} <br>
        <strong>Телефон:</strong> {{ $ticket->customer?->phone ?? '-' }}
    </div>

    <div class="mb-4">
        <strong>Тема:</strong> {{ $ticket->subject }} <br>
        <strong>Сообщение:</strong> {{ $ticket->message }} <br>
        <strong>Статус:</strong> {{ $ticket->status }} <br>
    </div>

    <div class="mb-4">
       <form action="{{ route('admin.tickets.update', $ticket->id) }}" method="POST">
    @csrf
    @method('PATCH')

    <div class="mb-4">
        <label class="block font-medium mb-1">Ответ менеджера</label>
        <textarea
            name="manager_answer"
            rows="5"
            class="border rounded px-2 py-1 w-full"
        >{{ old('manager_answer', $ticket->manager_answer) }}</textarea>
    </div>

    <div class="mb-4">
        <label class="block font-medium mb-1">Статус</label>
        <select name="status" class="border rounded px-2 py-1">
            <option value="new">Новый</option>
            <option value="in_progress">В работе</option>
            <option value="processed">Обработан</option>
        </select>
    </div>

    <button class="bg-green-600 text-white px-4 py-2 rounded">
        Отправить ответ
    </button>
</form>

    </div>


    <div class="mb-4">
        <strong>Файлы:</strong>
        <ul>
            @foreach($ticket->getMedia('files') as $file)
                <li><a href="{{ $file->getUrl() }}" target="_blank">{{ $file->name }}</a></li>
            @endforeach
        </ul>
    </div>

    <a href="{{ route('admin.tickets.index') }}" class="text-blue-600">Назад к списку</a>
</div>
@endsection
