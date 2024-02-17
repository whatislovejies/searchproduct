@extends('layuots.layuot')

@vite('resources/css/app.css')

@section('title', 'Избранные товары')

@section('content')
    <div class=" mx-auto bg-black">
        @if (!$favorites->isEmpty())
            <h2 class="text-2xl font-bold mb-4 text-white">Избранные товары</h2>
            <table class="table-auto text-white">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Название товара</th>
                        <th class="px-4 py-2">Цена</th>
                        <th class="px-4 py-2">Магазин</th>
                        <th class="px-4 py-2">Состояние</th>
                        <th class="px-4 py-2">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($favorites as $favorite)
                        <tr>
                            <td class="border px-4 py-2">{{ $favorite->product_name }}</td>
                            <td class="border px-4 py-2">{{ $favorite->price }}</td>
                            <td class="border px-4 py-2">{{ $favorite->store }}</td>
                            <td class="border px-4 py-2">{{ $favorite->comments }}</td>

                            <td class="border px-4 py-2">
                                <form action="{{ route('products.removeFromFavoritesView', $favorite->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-500">У вас нет избранных товаров.</p>
        @endif
    </div>
@endsection