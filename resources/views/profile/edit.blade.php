@extends('layuots.layuot')
@section('title', 'Категории')
@section('content')
@vite('resources/css/app.css')


<div class="bg-black">
    <p class="text-2xl font-semibold pt-20 text-white text-center">Личный кабинет</p>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="bg-black dark:bg-gray-800 p-6 sm:p-8 rounded-lg shadow">
            <p class="text-xl font-semibold mb-4">Информация о профиле</p>
            <div class="max-w-md">
                @include('profile.partials.update')
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 p-6 sm:p-8 rounded-lg shadow">
            <div class="max-w-md">
                @include('profile.partials.edit-password')
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 p-6 sm:p-8 rounded-lg shadow">
            <div class="max-w-md">
                @include('profile.partials.destroy')
            </div>
        </div>
    </div>
</div>
@endsection