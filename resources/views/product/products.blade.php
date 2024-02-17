@extends('layuots.layuot')
@section('title', 'Главная')
@section('content')
@vite('resources/css/app.css')
<link rel="stylesheet" href="{{ asset('public/css/pagination.css') }}">

<div class="bg-black">
    <div class="pt-10 text-center">
        <label for="search" class="text-white mb-2 ">Поиск:</label>
        <input id="search" type="search" name="search" class="bg-gray-700 text-white p-2 mb-4 rounded w-96">
    </div>
    
    {{-- Непосредственно Категории сортировка --}}
    <div class="flex p-4 pt-20 place-content-center">
        <div class="flex flex-col mr-8">
            <label class="text-white mb-2">Категории:</label>
            <div class="flex flex-col mb-4">
                <div class="flex items-center mb-2">
                    <input type="radio" value="Смартфоны" name="category" id="categorySmartphones" checked>
                    <p class="text-white ml-2">Смартфоны</p>
                </div>
                <div class="flex items-center mb-2">
                    <input type="radio" value="Ноутбуки" name="category" id="categoryNoyt">
                    <p class="text-white ml-2">Ноутбуки</p>
                </div>
                <div class="flex items-center mb-2">
                    <input type="radio" value="Телевизоры" name="category" id="categorySmart">
                    <p class="text-white ml-2">Телевизоры</p>
                </div>
                <div class="flex items-center mb-2">
                    <input type="radio" value="Фотоаппараты" name="category" id="categoryFhoto">
                    <p class="text-white ml-2">Фотоаппараты</p>
                </div>
                <div class="flex items-center mb-2">
                    <input type="radio" value="Наушники" name="category" id="categoryHead">
                    <p class="text-white ml-2">Наушники</p>
                </div>
            </div>

            <div class="flex items-center text-white mb-2">
                <span class="mr-2">Сортировка:</span>
                <div class="relative inline-block text-left">
                    <button id="sortPrice" class="text-white p-2 pr-8 rounded">
                        Цена 
                    </button>
                </div>
                <div class="relative inline-block text-left ml-4">
                    <button id="sortName" class="text-white p-2 pr-8 rounded">
                        Имя
                    </button>
                </div>
            </div>
            
        </div>
        {{-- Непосредственно товары --}}
        <div class="flex flex-col overflow-y-auto max-h-full w-1/2" id="productsContainer">
            @foreach ($filteredProducts as $product)
            <div  class="border border-t-cyan-950 p-4 rounded-3xl flex items-start justify-between mb-4">
                <!-- Левая колонка: Название продукта и характеристики -->
                <div class="w-1/2 pr-4">
                    <p class="text-white">{{ $product['productName'] ?? 'Название продукта отсутствует' }}</p>
        
                    @if (isset($product['characteristics']) && is_array($product['characteristics']))
                        <table class="mt-4 text-white">
                            <tbody>
                                @foreach ($product['characteristics'] as $characteristic)
                                    @if (is_array($characteristic) && isset($characteristic['propertyName']) && isset($characteristic['propertyValue']))
                                        <tr>
                                            <td>{{ $characteristic['propertyName'] }}:</td>
                                            <td>{{ $characteristic['propertyValue'] }}</td>
                                        </tr>
                                    @else
                                        {{-- Если characteristics не является массивом с соответствующими ключами, просто вывести его значение --}}
                                        <tr>
                                            <td colspan="2">{{ $characteristic }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    @elseif (isset($product['characteristic']))
                        {{-- Если characteristics не является массивом, вывести его значение --}}
                        <p class="text-white">{{ $product['characteristic'] }}</p>
                    @endif
                </div>
                <div id="allProducts" data-products="{{ json_encode($allProducts) }}"></div>
                <!-- Правая колонка: Цены и кнопка -->
                <div class="w-1/2 pl-56">
                    @if (isset($product['basePrice']))
                        <p class="text-white"><del class="text-gray-500">{{ $product['basePrice'] }}</del></p>
                    @endif
        
                    @if (isset($product['salePrice']))
                        <p class="text-white">{{ $product['salePrice'] }}</p>
                    @endif
        
                    @if (isset($product['productId']))
                        <a href="{{ route('product.show', $product['productId']) }}" class="bg-blue-500 text-white px-4 py-2 hover:bg-blue-700 flex">Подробнее</a>
                    @elseif(isset($product['item']['productId']))
                        <a href="{{ route('product.show', $product['item']['productId']) }}" class="bg-blue-500 text-white px-4 py-2 hover:bg-blue-700 flex">Подробнее</a>
                    @endif
                </div>
            </div>
        @endforeach
        </div>
    </div>
</div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
var allProducts = @json($allProducts);
var perPage = 12;
var currentPage = 1;
var ascendingOrderPrice = true;
var ascendingOrderName = true;
var priceSortClicked = false; // Новая переменная для отслеживания клика по сортировке цен
var nameSortClicked = false;
function renderProducts(products) {
    $('#productsContainer').html('');

    products.data.forEach(function (product) {
        var productHtml = `
            <div class="border border-t-cyan-950 p-4 flex rounded-3xl  items-start justify-between mb-4">
                <div class="w-1/2 pr-4">
                    <p class="text-white">${product['productName'] ?? 'Название продукта отсутствует'}</p>
                    ${getCharacteristicsHtml(product)}
                </div>
                <div class="w-1/2 pl-56">
                    ${getPriceHtml(product)}
                    ${getButtonHtml(product)}
                </div>
            </div>
        `;
        $('#productsContainer').append(productHtml);
    });

    var paginationHtml = '<style>.pagination a, span { color: white; } .pagination .active { background-color: #4CAF50; }</style>';

    if (products.total > products.per_page) {
        var totalPages = Math.ceil(products.total / products.per_page);

        paginationHtml += '<div class="pagination">';
        if (products.current_page > 1) {
            paginationHtml += '<a href="#" class="prev" data-page="' + (products.current_page - 1) + '">Назад</a>';
        }

        for (var i = 1; i <= totalPages; i++) {
            if (
                i <= 2 ||
                (i >= products.current_page - 1 && i <= products.current_page + 1) ||
                i >= totalPages - 1
            ) {
                paginationHtml += '<a href="#" data-page="' + i + '" class="' + (products.current_page === i ? 'active' : '') + '">' + i + '</a>';
            } else if (i === 3 && products.current_page > 4) {
                paginationHtml += '<span>...</span>';
            }
        }

        if (products.current_page < totalPages) {
            paginationHtml += '<a href="#" class="next" data-page="' + (products.current_page + 1) + '">Вперёд</a>';
        }
        paginationHtml += '</div>';
    }

    $('#productsContainer').append(paginationHtml);
    console.log('Products container after appending:', $('#productsContainer').html());
    $('#productsContainer').show();
}

function sortProducts(products, selectedCategory, sortKey, ascending) {
    console.log('Before sorting:', products);

    // Используйте правильный ключ для доступа к продуктам
    var categoryProducts = Array.isArray(products[selectedCategory]) ? [...products[selectedCategory]] : [];
    console.log('sortKey:', sortKey);

    if (sortKey === 'price') {
        categoryProducts.sort((a, b) => (ascending ? parseFloat(a.salePrice) - parseFloat(b.salePrice) : parseFloat(b.salePrice) - parseFloat(a.salePrice)));
    } else if (sortKey === 'name') {
        categoryProducts.sort((a, b) => (ascending ? a.productName.localeCompare(b.productName) : b.productName.localeCompare(a.productName)));
    }

    // Обновите оригинальный объект
    products[selectedCategory] = categoryProducts;

    console.log('After sorting:', categoryProducts);
    return products;
}


function filterAndSortProducts() {
    var selectedCategory = $('input[name="category"]:checked').val();
    var selectedSort = $('#sortSelect').val();
    var searchTerm = $('#search').val();

    var filteredProducts = allProducts[selectedCategory] || [];

    if (searchTerm) {
        filteredProducts = filteredProducts.filter(function (product) {
            return product.productName.toLowerCase().includes(searchTerm.toLowerCase());
        });
    }

    var sortedProducts = sortProducts({ [selectedCategory]: filteredProducts }, selectedCategory, selectedSort, selectedSort === 'price' ? ascendingOrderPrice : ascendingOrderName);

    return {
        selectedCategory: selectedCategory,
        filteredProducts: filteredProducts,
        sortedProducts: sortedProducts[selectedCategory] || [] // Возвращаем отсортированный массив
    };
}

function getCharacteristicsHtml(product) {
    var characteristicsHtml = '<table class="mt-4 text-white"><tbody>';

    if (product['characteristics'] && Array.isArray(product['characteristics'])) {
        // Структура 1 (например, у "Mvideo")
        product['characteristics'].forEach(function (characteristic) {
            if (characteristic['propertyName'] && characteristic['propertyValue']) {
                characteristicsHtml += `<tr><td>${characteristic['propertyName']}:</td><td>${characteristic['propertyValue']}</td></tr>`;
            } else {
                characteristicsHtml += `<tr><td colspan="2">${characteristic}</td></tr>`;
            }
        });
    } else if (product['characteristic'] && typeof product['characteristic'] === 'string') {
        // Структура 2 (например, у "citilink")
        var characteristicLines = product['characteristic'].split('\n');
        characteristicLines.forEach(function (line) {
            var parts = line.split(';');
            if (parts.length === 2) {
                characteristicsHtml += `<tr><td>${parts[0]}</td><td>${parts[1]}</td></tr>`;
            }
        });
    }

    characteristicsHtml += '</tbody></table>';

    return characteristicsHtml;
}

function getPriceHtml(product) {
    var priceHtml = '';

    if (product['basePrice']) {
        priceHtml += `<p class="text-white"><del class="text-gray-500">${product['basePrice']}</del></p>`;
    }

    if (product['salePrice']) {
        priceHtml += `<p class="text-white">${product['salePrice']}</p>`;
    }

    return priceHtml;
}

function getButtonHtml(product) {
    var productId = product['productId'] || (product['item'] && product['item']['productId']);

    var buttonHtml = '';

    if (productId) {
        buttonHtml += '<a href="{{ route("product.show", "") }}/' + productId + '" class="bg-blue-500 text-white px-4 py-2 hover:bg-blue-700 flex">Подробнее</a>';
    }

    return buttonHtml;
}

function updateProducts(selectedCategory, sortKey) {
    var result = filterAndSortProducts();

    if (!result) {
        console.error('filterAndSortProducts returned undefined.');
        return;
    }

    // Используйте переданный sortKey
    var filteredProducts = result.filteredProducts || [];
    var sortedProducts = result.sortedProducts || [];

    if (sortKey === 'price') {
        sortedProducts = sortedProducts.sort((a, b) => (ascendingOrderPrice ? parseFloat(a.salePrice) - parseFloat(b.salePrice) : parseFloat(b.salePrice) - parseFloat(a.salePrice)));
    } else if (sortKey === 'name') {
        sortedProducts = sortedProducts.sort((a, b) => (ascendingOrderName ? a.productName.localeCompare(b.productName) : b.productName.localeCompare(a.productName)));
    }

    var offset = (currentPage - 1) * perPage;
    var currentPageItems = sortedProducts.slice(offset, offset + perPage);

    console.log('selectedCategory:', selectedCategory);

    $('#productsContainer').html('');
    renderProducts({
        data: currentPageItems,
        total: sortedProducts.length,
        per_page: perPage,
        current_page: currentPage
    });
}


function updateSortIcons(sortKey, ascending) {
    var selectedCategory = $('input[name="category"]:checked').val();

    $('#sortPrice').find('span').remove();
    $('#sortName').find('span').remove();

    var iconHtml = ascending ? '<span>&uarr;</span>' : '<span>&darr;</span>';
    $('#sort' + sortKey.charAt(0).toUpperCase() + sortKey.slice(1)).append(iconHtml);

    // Показывать стрелки только после первого клика
    if ((sortKey === 'price' && priceSortClicked) || (sortKey === 'name' && nameSortClicked)) {
        $('#sortPrice').css('visibility', 'visible');
        $('#sortName').css('visibility', 'visible');
    }

    // Обновите категорию перед вызовом updateProducts
    updateProducts(selectedCategory, sortKey);
}


$('input[name="category"]').change(function () {
    currentPage = 1;
    updateProducts();
});

$('#sortSelect').change(function () {
    currentPage = 1;
    updateProducts();
});

$('#search').on('input', function () {
    currentPage = 1;
    updateProducts();
});

$('body').on('click', '.pagination a', function (event) {
    event.preventDefault();
    currentPage = $(this).data('page');
    updateProducts();
});

$('body').on('click', '.pagination a.prev', function (event) {
    event.preventDefault();
    currentPage = $(this).data('page');
    updateProducts();
});

$('body').on('click', '.pagination a.next', function (event) {
    event.preventDefault();
    currentPage = $(this).data('page');
    updateProducts();
});

$('#sortPrice').click(function () {
    ascendingOrderPrice = !ascendingOrderPrice;
    priceSortClicked = true;
    updateSortIcons('price', ascendingOrderPrice); // используйте 'price' вместо 'Price'
});

$('#sortName').click(function () {
    ascendingOrderName = !ascendingOrderName;
    nameSortClicked = true;
    updateSortIcons('name', ascendingOrderName); // используйте 'name' вместо 'Name'
});
// Initial update to display products
updateProducts();

         </script>
@endsection

