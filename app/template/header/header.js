window.addEventListener('load', () => {
    let toggler = document.querySelector("[data-toggle]");
    let dropdown = document.querySelector(".dropdown-menu");

    if (toggler) {
        toggler.addEventListener('click', (event) => {
            event.stopPropagation();
            toggle(dropdown);
        });
    }

    document.addEventListener('click', () => {
        hide(dropdown);
    });
});