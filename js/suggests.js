// setInterval('load_suggest()', 5000);

// var load_suggest =function () {
//     $('#suggest').load('../pages/suggestion.php');
// }

var sugg_infos = document.querySelectorAll('.sugg-infos'),
    blocPage = document.querySelector('#sugg-msg-page'),
    viewer = document.querySelector('.sugg-msg-bloc'),
    close = document.querySelector('#sugg-msg-close')

sugg_infos.forEach(sugg_info => {
    sugg_info.addEventListener('click', function (e) {

        var name = this.querySelector('.sugg-nom span').innerText,
            obj = this.querySelector('.sugg-objet span').innerText,
            day = this.querySelector('.sugg-date span').innerText,
            content = this.querySelector('.sugg-corps span').innerHTML,
            count = this.querySelector('.member-count').innerText

            initName = document.querySelector('.sugg-named-init span')
            viewName = document.querySelector('.sugg-named-name'),
            viewObj = document.querySelector('.sugg-obj-content'),
            viewDay = document.querySelector('.sugg-body-date'),
            viewContent = document.querySelector('.sugg-body-content span')


            viewName.innerText = name;
            viewObj.innerText = obj;
            viewDay.innerText = day;
            viewContent.innerHTML = content
            initName.innerText = initget(name)

            if (name = 'Yetekouman Bot') {
                var counter = viewContent.querySelector('.member-count')

                counter.innerText = 0
                setTimeout(() => {
                    setInterval(() => {
                        if (counter.innerText < count) {
                            counter.innerText++;
                        }
                    }, 50);
                }, 1000);

            }

        blocPage.classList.remove('sugg-dnone')
        viewer.classList.add('sugg-slide-down')
        setTimeout(() => {
            viewer.classList.remove('sugg-slide-down')
        }, 450);
    })
});

close.addEventListener('click', function (e) {
    viewer.classList.add('sugg-slide-up')
    setTimeout(() => {
        blocPage.classList.add('sugg-dnone')
        viewer.classList.remove('sugg-slide-up')
    }, 350);
})

initget = function (name) {
    name = name.trim()
    if (name.indexOf(' ') == -1) {
        var named = name.split('')
        var init = named[0]
        init = init.toUpperCase()
        return init;
    } else {
        var named = name.split(' ')
        var nameOne = named[0].split('')
        var nameTow = named[1].split('')

        var init = nameOne[0] + nameTow[0]
        init = init.toUpperCase()
        return init;
    }
}