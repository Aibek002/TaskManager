let text = document.getElementsByClassName('subtext-link')
let subtext = document.getElementsByClassName('subtext-text')

//hhhf hhfhhf

let html = document.getElementsByClassName('subtext-link');
let html_subtext = document.getElementsByClassName('subtext-text');

function startRunningTitle() {

    for (let i = 0; i < text.length; i++) {

        let display = text[i].innerHTML;
        display = display.substring(1) + display[0];
        html[i].innerHTML = display.replaceAll(" ", '&amp;nbsp;');
//hhhf&amp;nbsp;hhfhhf


    }

}

function startRunningText() {
    
    for (let i = 0; i < subtext.length; i++) {
        let element = subtext[i];

        if (!element.currentText) {
            element.currentText = element.innerHTML;
        }

        element.currentText = element.currentText.substring(1) + element.currentText[0];
        element.innerHTML = element.currentText.replaceAll(" ", '&nbsp;');

    }
}

setInterval(startRunningTitle, 1000);
setInterval(startRunningText, 200);

