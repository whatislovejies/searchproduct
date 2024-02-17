@extends('layuots.layuot')
@vite('resources/css/app.css')

@section('title', 'Избранные товары - Администратор')

@section('content')
    <div class=" mx-auto  bg-black text-white">
        <h2 class="text-2xl font-bold mb-4">Избранные товары - Администратор</h2>
        <ul>
            @foreach ($favorites as $favorite)
                <li class="border-b border-gray-300 py-2">
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="font-bold">{{ $favorite->product_name }}</span>
                            <span class="font-bold">Пользователь №{{ $favorite->user_id }}</span>
                            
                            <span class="text-gray-600"> - {{ $favorite->price }} - {{ $favorite->store }}</span>
                        </div>
                        <form action="{{ route('admin.addComment', $favorite->user_id) }}" method="POST" class="ml-4  text-black ">
                            @csrf
                            <label for="comment_type" class="mr-2">Тип комментария:</label>
                            <select name="comment_type" id="comment_type" class="border p-1">
                                <option value="Нет изменений">Нет изменений</option>
                                <option value="Товар закончился">Товар закончился</option>
                                <option value="Цена изменилась">Цена изменилась</option>
                            </select>

                            <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded">Добавить</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endsection