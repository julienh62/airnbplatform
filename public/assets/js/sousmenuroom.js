//console.log("cc sousumenuroom");
const container = document.getElementById('roomForm');
let template = container.dataset.prototype;
let divBeds = document.getElementById('beds');

const addButton = document.getElementById('addBed');
const removeButtons = document.querySelectorAll('.removeBed');

let index = container.dataset.index

function onClickRemove()
{
    this.parentElement.remove();
}
function onClickAddBed()
{
    const divBed = document.createElement("div");
    divBed.innerHTML = template.replaceAll("__name__", index);
    divBeds.append(divBed);
    index++;
    divBed.querySelector('.removeBed').addEventListener('click', onClickRemove);
}

addButton.addEventListener('click', onClickAddBed);

for(const removebutton of removeButtons) {
    removebutton.addEventListener('click', onClickRemove);
}



