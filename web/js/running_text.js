let text = document.getElementsByClassName('subtext-link')
let subtext = document.getElementsByClassName('subtext-text')




function startRunningTitle() {

    for (let i = 0; i < text.length; i++) {

        let title = text[i];

        if (!title.currentText) {
            title.currentText = title.innerHTML;
        }

        title.currentText = title.currentText.substring(1) + title.currentText[0];
        title.innerHTML = title.currentText.replaceAll(" ", '&nbsp;');


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

