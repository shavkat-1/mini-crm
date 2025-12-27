<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Обратная связь</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-6 rounded shadow w-full max-w-md">
        <h2 class="text-2xl font-bold mb-4">Обратная связь</h2>
        <div id="success" class="hidden p-2 mb-4 bg-green-100 text-green-700 rounded"></div>
        <div id="errors" class="hidden p-2 mb-4 bg-red-100 text-red-700 rounded"></div>
        <form id="ticketForm" enctype="multipart/form-data">

            <div class="mb-3">
                <label class="block mb-1">Имя</label>
                <input type="text" name="name" class="w-full border rounded px-3 py-2">
            </div>
            <div class="mb-3">
                <label class="block mb-1">Email</label>
                <input type="email" name="email" class="w-full border rounded px-3 py-2">
            </div>
            <div class="mb-3">
                <label class="block mb-1">Телефон</label>
                <input type="text" name="phone" class="w-full border rounded px-3 py-2" placeholder="+71234567890">
            </div>
            <div class="mb-3">
                <label class="block mb-1">Тема</label>
                <input type="text" name="subject" class="w-full border rounded px-3 py-2">
            </div>
            <div class="mb-3">
                <label class="block mb-1">Сообщение</label>
                <textarea name="message" class="w-full border rounded px-3 py-2" rows="4"></textarea>
            </div>
            <div class="mb-3">
                <label class="block mb-1">Файлы</label>
                <input type="file" name="files[]" multiple>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Отправить</button>
        </form>
    </div>

    <script>
        const form = document.getElementById('ticketForm');
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const errorsDiv = document.getElementById('errors');
            const successDiv = document.getElementById('success');
            errorsDiv.classList.add('hidden');
            successDiv.classList.add('hidden');
            errorsDiv.innerHTML = '';
            successDiv.innerHTML = '';

            const formData = new FormData(form);

            try {
                const response = await fetch('/api/tickets', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (!response.ok) {
                    if (data.errors) {
                        for (const key in data.errors) {
                            errorsDiv.innerHTML += `<p>${data.errors[key].join(', ')}</p>`;
                        }
                    } else {
                        errorsDiv.innerHTML = `<p>${data.message}</p>`;
                    }
                    errorsDiv.classList.remove('hidden');
                } else {
                    successDiv.innerHTML = 'Заявка успешно отправлена!';
                    successDiv.classList.remove('hidden');
                    form.reset();
                }
            } catch (err) {
                errorsDiv.innerHTML = 'Ошибка отправки формы';
                errorsDiv.classList.remove('hidden');
            }
        });
    </script>
</body>
</html>
