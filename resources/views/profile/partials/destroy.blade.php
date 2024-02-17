<button id="delete-account-button" class="form__button" onclick="toggleDeleteForm()">Удалить аккаунт</button>
<div id="confirm-user-deletion" class="modal" style="display:{{ $errors->userDeletion->isNotEmpty() ? 'block' : 'none' }}">
    <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
        @csrf
        @method('delete')

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            Вы уверены, что хотите удалить свой аккаунт?
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            После удаления аккаунта все его ресурсы и данные будут безвозвратно удалены. Пожалуйста, введите свой пароль для подтверждения удаления аккаунта.
        </p>

        <div class="mt-6">
            <label for="password" class="sr-only">Пароль</label>
            <input id="password" name="password" type="password" class="mt-1 block w-3/4 form__input" placeholder="Пароль">
            @if ($errors->userDeletion->has('password'))
                <div class="mt-2 text-red-500">{{ $errors->userDeletion->first('password') }}</div>
            @endif
        </div>

        <div class="mt-6 flex justify-end">
            <button type="button" onclick="cancelDelete()" class="form__button">Отмена</button>

            <button type="submit" class="ml-3 form__button">Удалить аккаунт</button>
        </div>
    </form>
</div>
    <script>
        function toggleDeleteForm() {
            var deleteForm = document.getElementById('confirm-user-deletion');
            var deleteButton = document.getElementById('delete-account-button');
    
            if (deleteForm.style.display === 'none' || deleteForm.style.display === '') {
                deleteForm.style.display = 'block';
                deleteButton.style.display = 'none';
            } else {
                deleteForm.style.display = 'none';
                deleteButton.style.display = 'block';
            }
        }
    
        function cancelDelete() {
            var deleteForm = document.getElementById('confirm-user-deletion');
            var deleteButton = document.getElementById('delete-account-button');
    
            deleteForm.style.display = 'none';
            deleteButton.style.display = 'block';
        }
    </script>
    
    
    
