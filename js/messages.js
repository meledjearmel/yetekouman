
setInterval('load_messages()', 1500);
// setInterval('load_contacts()', 1500);

var load_messages =function () {
    $('#messages').load('../pages/messages.php');
}

var load_contacts = function () {
    $('#contacts').load('../pages/contacts.php');
}

var inputFieldDiv = document.querySelector('.msg-conv-area-text'),
    button = inputFieldDiv.querySelector('button');
    btnType = button.getAttribute('type');

var inputField = document.querySelector('.msg-conv-input'),
    form = document.querySelector('#msg-form')

if (btnType != 'submit') {
    inputField.style.background = '#eee9e9';
    inputField.style.cursor = 'no-drop';
    inputField.setAttribute('placeholder', 'Aucun contact selectionne');
    inputField.addEventListener('keydown', function (e) {
        e.preventDefault()
    })
} else {
    inputField.addEventListener('keydown', function (e) {
        if (e.key == 'Enter') {
            if (!e.shiftKey) {
                e.preventDefault();
                form.submit();
            }
        }
    })
}