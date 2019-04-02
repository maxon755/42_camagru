window.addEventListener('load', () => {
    let toggler = document.querySelector("header [data-toggle]");
    let dropdown = document.querySelector("header .dropdown-menu");

    if (toggler) {
        toggler.addEventListener('click', (event) => {
            event.stopPropagation();
            toggle(dropdown);
        });
    }

    if (dropdown) {
        document.addEventListener('click', () => {
            hide(dropdown);
        });
    }
});
