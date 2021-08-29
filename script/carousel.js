function btnClick() {
    let previous = document.getElementById('previous');
    let next = document.getElementById('next');
    let inputs = document.getElementsByTagName('input');
    for (const el of inputs) {
        el.addEventListener('click', function () {
            if (this.value === '1') {
                previous.disabled = true;
                next.disabled = false;
            } else if (this.value === '4') {
                next.disabled = true;
                previous.disabled = false;
            } else {
                previous.disabled = false;
                next.disabled = false;
            }
        })
    }
    previous.addEventListener('click', function () {
        let val = -2;
        let index = 0;
        for (const input of inputs) {
            if (input.checked) {
                val = input.value;
                break;
            }
            index++;
        }
        if (index > 0) {
            inputs[index - 1].checked = true;
        }
        if (val >= 3) {
            next.disabled = false;
        }
        if (val <= 2){
            previous.disabled = true;
        }
        document.getElementById('slides').style.transform = `translateX(-${val - 2}00vw)`;
    });
    
    next.addEventListener('click', function () {
        let val = -1;
        let index = 0;
        for (const input of inputs) {
            if (input.checked) {
                val = input.value;
                break;
            }
            index++;
        }
        if (index < 4) {
            inputs[index + 1].checked = true;
        }
        if (val >= 3) {
            next.disabled = true;
        }
        if (val <= 3){
            previous.disabled = false;
        }
        document.getElementById('slides').style.transform = `translateX(-${val}00vw)`;
    });
}
btnClick();

function slide() {
    const selection = document.getElementsByTagName('input');
    for (const el of selection) {
        el.addEventListener('click', function () {
            let doc = document.getElementById(`slides`);
            doc.style.transform = `translateX(-${this.value - 1}00vw)`;
        })
    }
}
slide();
