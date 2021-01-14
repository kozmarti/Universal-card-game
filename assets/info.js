let infoText = document.getElementById('zone-information');
let textShow = document.getElementById('text-show');


infoText.addEventListener('input', event => {
    console.log('EVENT');
    fetch('/note?text-to-update=' + event.target.value)
        .then( res=>res.json())
        .then( json => autocomplete(json))

})


function removeAllChildNodes(parent) {
    while (parent.firstChild) {
        parent.removeChild(parent.firstChild);
    }
}

function autocomplete(json) {
    let textToShow=json;
    let text=textToShow.information;
    textShow.innerText=text;
}

