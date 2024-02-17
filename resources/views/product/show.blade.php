@extends('layuots.layuot')
@vite('resources/css/app.css')
<body class="bg-black">
    

@section('content')
    <div class="container mx-auto mt-8">
        <div class=" p-8 shadow-md rounded-md">
            <h2 class="text-2xl font-bold mb-4 text-white">{{ $product['productName'] }}</h2>

          {{-- Вывод характеристик товара --}}
<table class="mt-4 text-white">
    
    <tbody>
    
        @if (isset($product['characteristics']) && is_array($product['characteristics']))
            {{-- Структура 1 (например, у "Mvideo") --}}
            @foreach ($product['characteristics'] as $characteristic)
                @if (isset($characteristic['propertyName']) && isset($characteristic['propertyValue']))
                    <tr>
                        <td>{{ $characteristic['propertyName'] }}:</td>
                        <td>{{ $characteristic['propertyValue'] }}</td>
                    </tr>
                @else
                    <tr>
                        <td colspan="2">{{ $characteristic }}</td>
                    </tr>
                @endif
            @endforeach
            <tr>
                <td>Магазин:Mvideo</td>
             
            </tr>
        @elseif (isset($product['characteristic']) && is_string($product['characteristic']))
            {{-- Структура 2 (например, у "citilink") --}}
            @php
                $characteristicLines = explode("\n", $product['characteristic']);
            @endphp

            @foreach ($characteristicLines as $line)
                @php
                    $parts = explode(';', $line);
                @endphp

                @if (count($parts) === 2)
                    <tr>
                        <td>{{ $parts[0] }}</td>
                        <td>{{ $parts[1] }}</td>
                    </tr>
                @endif
            @endforeach
            <tr>
                <td>Магазин: citilink</td>
            </tr>
        @endif
    </tbody>
</table>


            {{-- Вывод цен и кнопки --}}
            <div class="mt-4">
                @if (isset($product['basePrice']))
    <p class="text-gray-500"><del class="text-gray-500">{{ $product['basePrice'] }}</del></p>
@endif
                <p class="text-blue-500">{{ $product['salePrice'] }}</p>
            </div>
            <div class="mt-8">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('info'))
                    <div class="alert alert-info">
                        {{ session('info') }}
                    </div>
                @endif
                @if (Auth::check())
                    @if ($isFavorite)    
                        <form action="{{ route('products.removeFromFavorites', $product['productId']) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-red-500 hover:text-red-700">Удалить из избранного</button>
                        </form>
                    @else
                    <form action="{{ route('products.addToFavorites', $product['productId']) }}" method="POST">
                        @csrf
                        <input type="hidden" name="productName" value="{{ $product['productName'] }}">
                        <input type="hidden" name="price" value="{{ $product['salePrice'] }}">
                        <button type="submit" class="text-blue-500 hover:text-blue-700">Добавить в избранное</button>
                    </form>
                    @endif
                @endif
            </div>
            <div class="mt-8">
                <a href="{{ route('products.index') }}" class="text-blue-500 hover:text-blue-700">Назад к списку товаров</a>
            </div>
        </div>
    </div>
@endsection
</body>