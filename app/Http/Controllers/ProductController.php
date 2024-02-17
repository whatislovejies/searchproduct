<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Favorites;
use Illuminate\Pagination\LengthAwarePaginator;
class ProductController extends Controller
{
   
    public function index(Request $request)
    {
        $allProducts = $this->getAllProducts();

        $selectedCategory = $request->input('category');
        $selectedSort = $request->input('sort');
        $searchTerm = $request->input('search');
        
        // Извлекаем данные только для выбранной категории
        $filteredProducts = $allProducts[$selectedCategory] ?? [];
        
        // Фильтрация товаров по поисковому запросу
        if (!empty($searchTerm)) {
            $filteredProducts = array_filter($filteredProducts, function ($product) use ($searchTerm) {
                // Замените 'productName' на поле, по которому вы хотите выполнять поиск
                return stripos($product['productName'], $searchTerm) !== false;
            });
        }
        
        // Сортировка товаров
        if (!empty($selectedSort)) {
            usort($filteredProducts, function ($a, $b) use ($selectedSort) {
                return $a[$selectedSort] <=> $b[$selectedSort];
            });
        }
        
        // Передаем полный список продуктов и отфильтрованный список для текущей категории в представление
        return view('product.products', compact('allProducts', 'filteredProducts'));
    }

    private function getAllProducts()
{
    $allProducts = [];

    $jsonFiles = [
        public_path('json/mvn.json'),
        public_path('json/mvnF.json'),
        public_path('json/mvnNa.json'),
        public_path('json/mvnP.json'),
        public_path('json/mvnT.json'),
        public_path('json/subcategorysWithHydratedItems.json'),
    ];

    foreach ($jsonFiles as $jsonFile) {
        $jsonData = file_get_contents($jsonFile);
        $products = json_decode($jsonData, true);

        if (isset($products[0]['subcategory']) && isset($products[0]['items'])) {
            foreach ($products as $product) {
                $allProducts[$product['subcategory']] = array_merge($allProducts[$product['subcategory']] ?? [], $product['items']);
            }
        } elseif (isset($products['subcategory'])) {
            $subcategory = $products['subcategory'];

            if (isset($products['items'])) {
                $allProducts[$subcategory] = is_array($products['items']) ? $products['items'] : [$products['items']];
            } elseif (isset($products['characteristics'])) {
                $allProducts[$subcategory] = is_array($products['characteristics']) ? $products['characteristics'] : [$products['characteristics']];
            }
        }
    }

    return $allProducts;
}

public function show($id)
{
    $allProducts = $this->getAllProducts();

    foreach ($allProducts as $categoryProducts) {
        foreach ($categoryProducts as $product) {
            if (data_get($product, 'productId') === $id) {
                $user = Auth::user();
                $isFavorite = false;

                if ($user) {
                    $favoriteProduct = Favorites::where(['user_id' => $user->id, 'product_id' => $id])->first();
                    $isFavorite = $favoriteProduct ? true : false;
                }

                // Передаем в представление значение магазина из первого продукта в категории
                $category = data_get($product, 'shop', '');
                return view('product.show', compact('product', 'isFavorite', 'category'));
            }
        }
    }

    abort(404);
}



    

public function addToFavorites(Request $request, $productId)
{
    $user = Auth::user();
    $allProducts = $this->getAllProducts();

    // Ищем продукт по ID во всех категориях
    foreach ($allProducts as $categoryProducts) {
        $product = collect($categoryProducts)->firstWhere('productId', $productId);
        if ($product) {
            break; // Прекращаем поиск, если продукт найден
        }
    }

    if (!$product) {
        abort(404);
    }

    $favorite = Favorites::firstOrNew([
        'user_id' => $user->id,
        'product_id' => $productId,
    ]);

    $favorite->product_name = $product['productName'];
    $favorite->price = $product['salePrice'];
    $favorite->store = 'Мвидео';
    $favorite->save();

    return redirect()->back()->with('success', 'Товар добавлен в избранное.');
}

    

    public function removeFromFavorites($productId)
    {
        $user = Auth::user();
        $favorite = Favorites::where(['user_id' => $user->id, 'product_id' => $productId])->first();
        if ($favorite) {
            $favorite->delete();
        }

        return redirect()->back()->with('success', 'Товар удален из избранного.');
    }

    
}
