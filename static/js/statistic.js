const menu = document.querySelector(".menu");

let lastClickedId = 0;

document.addEventListener('contextmenu', e => {
    if (e.target.tagName != 'TR' && e.target.tagName != 'TD') {
        menu.classList.add("hidden");
        return;
    }
    drawContextMenu({ x: e.clientX, y: e.clientY });
    lastClickedId = e.target.id;
    e.preventDefault();
});

document.addEventListener('click', () => { menu.classList.add("hidden"); })

const drawContextMenu = pos => {
    menu.classList.remove("hidden");
    menu.setAttribute("style", `top: ${pos.y}px; left: ${pos.x}px;`);
};

document.querySelector(".item").addEventListener("click", () => {
    window.location.replace(`http://10.174.246.199/report/edit/id=${lastClickedId}`)
});