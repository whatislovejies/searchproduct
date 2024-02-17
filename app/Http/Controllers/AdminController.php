<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorites;
class AdminController extends Controller
{
    public function viewFavorites()
    {
        $favorites = Favorites::all();
        return view('admin.viewFavorites', compact('favorites'));
    }

    public function addComment(Request $request, $user_id)
    {
        $request->validate([
            'comment_type' => 'required|in:Нет изменений,Товар закончился,Цена изменилась',
        ]);
    
        $commentType = $request->input('comment_type');
    
        // Находим запись в таблице favorites по user_id и auth()->id()
        $favorite = Favorites::where('user_id', $user_id)
            ->firstOrFail();
    
        // Заполняем поле comment в таблице favorites
        $favorite->update([
            'comments' => $commentType,
        ]);
    
        return redirect()->back()->with('success', 'Комментарий добавлен.');
    }
    

    
}
