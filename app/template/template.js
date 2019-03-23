function cl(data) {
    console.log(data);
}

function cd(data) {
    console.dir(data);
}

function toggle(element) {
    let state = element.style.display;

    element.style.display = state !== 'block'
        ? 'block'
        : 'none';
}

function hide(element) {
    element.style.display = 'none';
}