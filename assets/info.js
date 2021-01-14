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



const cats = document.getElementsByClassName('category-drop');
const boxes = document.getElementsByClassName('category-box-drop');
const numberOfCategories = cats.length;
const numberOfBoxes = boxes.length;
let orderDragStart = 0;
let itemToDrop = '';

for (let i = 0; i < numberOfCategories; i++) {
    cats[i].addEventListener('dragstart', (event) => {
        orderDragStart = parseInt(event.target.parentNode.id);
        itemToDrop = event.target.id;
    });
}

for (let i = 0; i < numberOfBoxes; i++) {
    boxes[i].addEventListener('dragover', (event) => {
        event.preventDefault();
    });
}

let boxToMove = '';
let boxFromMove = '';
let categoryToMove = '';

for (let i = 0; i < numberOfBoxes; i++) {
    boxes[i].addEventListener('drop', (event) => {
        event.preventDefault();
        if (Number.isInteger(parseInt(event.target.id))) {
            if (orderDragStart < parseInt(event.target.id)) {
                for (let x = parseInt(event.target.id) - 1; x >= orderDragStart; x--) {
                    boxToMove = document.getElementById(x);
                    boxFromMove = document.getElementById(x + 1);
                    categoryToMove = boxFromMove.firstElementChild;
                    boxToMove.appendChild(categoryToMove);
                }
                event.target.appendChild(document.getElementById(itemToDrop));
            } else {
                for (let x = parseInt(event.target.id); x < orderDragStart; x++) {
                    boxToMove = document.getElementById(x + 1);
                    boxFromMove = document.getElementById(x);
                    categoryToMove = boxFromMove.firstElementChild;
                    boxToMove.appendChild(categoryToMove);
                }
                event.target.appendChild(document.getElementById(itemToDrop));
            }
        } else {
            if (orderDragStart < parseInt(event.target.parentNode.id)) {
                event.target.parentNode.appendChild(document.getElementById(itemToDrop));
                for (let x = parseInt(event.target.parentNode.id) - 1; x >= orderDragStart; x--) {
                    boxToMove = document.getElementById(x);
                    boxFromMove = document.getElementById(x + 1);
                    categoryToMove = boxFromMove.firstElementChild;
                    boxToMove.appendChild(categoryToMove);
                }
            } else {
                event.target.parentNode.appendChild(document.getElementById(itemToDrop));
                for (let x = parseInt(event.target.parentNode.id); x < orderDragStart; x++) {
                    boxToMove = document.getElementById(x + 1);
                    boxFromMove = document.getElementById(x);
                    categoryToMove = boxFromMove.firstElementChild;
                    boxToMove.appendChild(categoryToMove);
                }
            }
        }
    });
}