document.addEventListener('DOMContentLoaded', () => {
    let tabs = document.querySelectorAll('nav>.nav-tabs>.nav-item');
    let panes = document.querySelectorAll('#nav-tabContent .tab-pane');
    let hash = window.location.hash;

    if (hash) {
        hash = hash.substr(1);
        deactivateTabs(tabs);
        hidePanes(panes);

        let tab = document.querySelector(`[data-pane=${hash}]`);
        let pane = document.getElementById(hash);

        tab.classList.add('active');
        pane.classList.add('active');
        pane.classList.add('show');
    }
});

window.addEventListener('load', () => {
    let tabPanel = document.querySelector('div.nav-tabs');
    let tabs = document.querySelectorAll('nav>.nav-tabs>.nav-item');
    let panes = document.querySelectorAll('#nav-tabContent .tab-pane');

    tabPanel.addEventListener('click', (event) => {
        if (!event.target.classList.contains('nav-item')) {
            return;
        }
        let tab = event.target;
        let pane = document.getElementById(tab.dataset['pane']);

        deactivateTabs(tabs);
        hidePanes(panes);

        tab.classList.add('active');
        pane.classList.add('active');
        pane.classList.add('show');
    });

});


function deactivateTabs(tabs) {
    for (let i = 0; i < tabs.length; i++) {
        tabs[i].classList.remove('active');
    }
}

function hidePanes(panes) {
    for (let i = 0; i < panes.length; i++) {
        panes[i].classList.remove('show');
        panes[i].classList.remove('active');
    }
}
