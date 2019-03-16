window.addEventListener('load', () => {
    'use strict';

    let dataUrl  = '/ribbon/get-posts';
    let offset   = 0;
    let limit    = 1;
    let noPosts  = false;
    let ribbon   = document.getElementById('ribbon__container');
    let spinner  = document.getElementById('ribbon__spinner');

    let atBottom  = false;
    let xhrOpened = false;

    fillRibbonInitial();

    function fillRibbonInitial() {
       getPosts(offset, 1)
           .then(response => JSON.parse(response))
           .then(response => {
               if (!response.success) {
                   noPosts = true;
                   return;
               }
               xhrOpened = false;
               offset += 1;
               postModule.renderPosts(ribbon, response);
               if (document.body.offsetHeight < window.innerHeight) {
                    fillRibbonInitial(offset, 1);
               }
           })
           .catch(error => {
               alert(error);
           });
    }

    function fillRibbon() {
        getPosts(offset, limit)
            .then(response => JSON.parse(response))
            .then(response => {
                xhrOpened = false;
                hideSpinner();
                if (!response.success) {
                    noPosts = true;
                    return;
                }
                offset += limit;
                postModule.renderPosts(ribbon, response);
            })
            .catch(error => {
                alert(error);
            });
    }

    function getPosts(offset, limit) {
       return new Promise(function(resolve, reject) {
           let xhr          = new XMLHttpRequest();
           let formData     = new FormData();

           formData.append('offset', offset);
           formData.append('limit', limit);
           xhr.open('post', dataUrl);
           xhr.send(formData);

           xhr.onload = function() {
               resolve(this.response);
           };

           xhr.onerror = function () {
               reject(this.response);
           }
       });
    }

    function showSpinner() {
       spinner.style.display = 'block';
    }

    function hideSpinner() {
        spinner.style.display = 'none';
    }

    window.onscroll = function() {
        atBottom = (window.innerHeight + window.scrollY) >= document.body.offsetHeight;

        if (atBottom && !xhrOpened) {
            atBottom = false;
            xhrOpened = true;
            if (noPosts) {
                return;
            }
            showSpinner();
            setTimeout(function () {
                fillRibbon();
            }, 1000);
        }
    };
});
