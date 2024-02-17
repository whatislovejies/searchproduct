<form method="post" action="{{ route('profile.password.update') }}" class="p-6">

    @csrf
    @method('patch')

    <div class="mb-4">
        <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Текущий пароль</label>
        <input id="current_password" name="current_password" type="password" class="mt-1 block w-full form__input" autocomplete="current-password">
        @if ($errors->updatePassword->has('current_password'))
            <div class="mt-2 text-red-500">{{ $errors->updatePassword->first('current_password') }}</div>
        @endif
    </div>

    <div class="mb-4">
        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Новый пароль</label>
        <input id="password" name="password" type="password" class="mt-1 block w-full form__input" autocomplete="new-password">
        @if ($errors->updatePassword->has('password'))
            <div class="mt-2 text-red-500">{{ $errors->updatePassword->first('password') }}</div>
        @endif
    </div>

    <div class="mb-4">
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Подтверждение пароля</label>
        <input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full form__input" autocomplete="new-password">
        @if ($errors->updatePassword->has('password_confirmation'))
            <div class="mt-2 text-red-500">{{ $errors->updatePassword->first('password_confirmation') }}</div>
        @endif
    </div>

    <div class="flex items-center gap-4">
        <button type="submit" class="form__button">Сохранить</button>

        @if (session('status') === 'password-updated')
            <p class="text-sm text-gray-600 dark:text-gray-400">Сохранено.</p>
        @endif
    </div>

</form>
