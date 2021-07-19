setInterval('load_content()', 1500);

var load_content =function () {
    $('#dash-content').load('../pages/dashContent.php');
}

var msgIcons = document.querySelectorAll('.dash-send-msg'),
    phnIcons = document.querySelectorAll('.dash-view-contact'),
    msgSend = '.dash-member-msg-send',
    phnView = '.dash-member-contact-view'

let outBox = function (icons, addClass, removeClass) {
    for (let i = 0; i < icons.length; i++) {
        let Icon = icons[i];
        Icon.addEventListener('click', function (e) {
            let parent = this.parentNode.parentNode.parentNode.parentNode
    
            if (!parent.querySelector(removeClass).classList.contains('dash-dnone')) {
                parent.querySelector(removeClass).classList.add('dash-dnone')
            }
    
            let bloc = parent.querySelector(addClass)
            if (bloc.classList.contains('dash-dnone')) {
                bloc.classList.remove('dash-dnone')
                parent.querySelector('.dash-card-info-send').classList.remove('dash-dnone')
            } else {
                bloc.classList.add('dash-dnone')
                parent.querySelector('.dash-card-info-send').classList.add('dash-dnone')
            }
        })
    }
}

outBox(msgIcons, msgSend, phnView);
outBox(phnIcons, phnView, msgSend)

document.querySelector('#dash-footer-disc').addEventListener('click', function deconnect(e) {
    e.preventDefault();
    document.querySelector('#disc-form').submit()
})

var inputField = document.querySelector('.dash-input'),
    form = document.querySelector('#dash-form')

inputField.addEventListener('keydown', function (e) {
    if (e.key == 'Enter') {
        if (!e.shiftKey) {
            e.preventDefault();
            form.submit();
        }
    }
})