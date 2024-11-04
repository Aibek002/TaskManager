let text = document.getElementsByClassName('subtext-link')
let subtext = document.getElementsByClassName('subtext-text')



let html = document.getElementsByClassName('subtext-link');
let html_subtext = document.getElementsByClassName('subtext-text');

function startRunningTitle() {

    for (let i = 0; i < text.length; i++) {

        let display = text[i].innerHTML;
        display = display.substring(1) + display[0];
        html[i].innerHTML = display.replaceAll(" ", '&nbsp;');

    }

}

function startRunningText() {
    
    for (let i = 0; i < subtext.length; i++) {

        let display_subtext = subtext[i].innerHTML;
        display_subtext = display_subtext.substring(1) + display_subtext[0];
        html_subtext[i].innerHTML = display_subtext.replaceAll(" ", '&nbsp;');

    }
}

setInterval(startRunningTitle, 1000);
setInterval(startRunningText, 200);

