let infoText = document.getElementById('zone_information');
console.log(infoText);
infoText.addEventListener('input', event => {
    console.log('yes');
    fetch('/game', {
        method: 'POST',
        headers : {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
        .then(res => res.json())
        .then(json => console.log(json));
})

function persist(json) {
    infoText.innerHTML = json.information;
}