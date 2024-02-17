<form method="POST" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
    @csrf
    @method('PATCH')

    <div class="form__field">
        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Имя</label>
        <input id="name" type="text" name="name" class="mt-1 block w-full form__input" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
        @if ($errors->has('name'))
            <div class="alert alert-danger">{{ $errors->first('name') }}</div>
        @endif
    </div>

    <div class="form__field">
        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Электронная почта</label>
        <input id="email" type="email" name="email" class="mt-1 block w-full form__input" value="{{ old('email', $user->email) }}" required autocomplete="username">
        @if ($errors->has('email'))
            <div class="alert alert-danger">{{ $errors->first('email') }}</div>
        @endif
    </div>

    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
        <div>
            <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                Ваш адрес электронной почты не подтвержден.
                <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                    Нажмите здесь, чтобы отправить повторное письмо с подтверждением.
                </button>
            </p>
            @if (session('status') === 'verification-link-sent')
                <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                    Новая ссылка для подтверждения была отправлена на ваш адрес электронной почты.
                </p>
            @endif
        </div>
    @endif

    <div class="flex items-center gap-4">
        <button type="submit" class="form__button">Сохранить</button>
        @if (session('status') === 'profile-updated')
            <p class="text-sm text-gray-600 dark:text-gray-400">Сохранено.</p>
        @endif
    </div>
</form>
