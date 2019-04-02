window.addEventListener('load', () => {
    let tabPanel = document.querySelector('div.nav-tabs');
    let tabs = document.querySelectorAll('nav>.nav-tabs>.nav-item');
    let panes = document.querySelectorAll('#nav-tabContent .tab-pane');

    tabPanel.addEventListener('click', (event) => {
        if (!event.target.classList.contains('nav-item')) {
            return;
        }
        console.log(event.target.dataset['pane']);
        let tab = event.target;
        let pane = document.getElementById(tab.dataset['pane']);

        deactivateTabs();
        hidePanes();

        tab.classList.add('active');
        pane.classList.add('active');
        pane.classList.add('show');
    });

    function deactivateTabs() {
        for (let i = 0; i < tabs.length; i++) {
            tabs[i].classList.remove('active');
        }
    }

    function hidePanes() {
        for (let i = 0; i < panes.length; i++) {
            panes[i].classList.remove('show');
            panes[i].classList.remove('active');
        }
    }
});
