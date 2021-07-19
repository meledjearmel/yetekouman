var inputField = document.querySelector('.post-content'),
    form = document.querySelector('#post-form')

inputField.addEventListener('keydown', function (e) {
    if (e.key == 'Enter') {
        if (!e.shiftKey) {
            e.preventDefault();
            form.submit();
        }
    }
})