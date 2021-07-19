setInterval('load_msglink()', 1500);

var load_msglink =function () {
    $('#msglink').load('../pages/msglink.php');
}

// var notif = document.querySelector('#msglink').querySelector('.counter');

// var count = notif.innerText

// notif.addEventListener('load', function (e) {
//     console.log(notif.innerText);
// })

document.querySelector('#disconnect').addEventListener('click', function deconnect(e) {
    document.querySelector('#disc-form').submit()
})
