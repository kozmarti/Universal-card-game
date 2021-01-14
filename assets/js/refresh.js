const body = document.querySelector("body");
console.log(body);

body.addEventListener("timeupdate", event => {
    fetch('/game')
})