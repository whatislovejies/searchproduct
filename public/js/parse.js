fetch('/fetch-and-save')
    .then(response => response.json())
    .then(data => {
        console.log(data.message);
        // Обновите ваш интерфейс в соответствии с полученными данными
    })
    .catch(error => console.error('Error:', error));