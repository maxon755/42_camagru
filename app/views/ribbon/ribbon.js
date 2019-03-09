window.addEventListener('load', () => {
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
           .then(response => {
               xhrOpened = false;
               offset += 1;
               handleResponse(response);
               if (document.body.offsetHeight < window.innerHeight) {
                    fillRibbonInitial(offset, 1);
               }
           });
   }

    function fillRibbon() {
        getPosts(offset, limit)
            .then(response => {
                xhrOpened = false;
                hideSpinner();
                if (!response) {
                    noPosts = true;
                    return;
                }
                offset += limit;
                handleResponse(response);
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

    function handleResponse(response) {

        let post = document.createElement('div');
        post.innerHTML = response.trim();

        let heart = post.getElementsByClassName('fa-heart')[0];
        heart.addEventListener('click', function (event) {
            postModule.toggleLike(event);
        });

        ribbon.appendChild(post);
    }

    window.onscroll = function(e) {
        if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
            atBottom = true;
        }  else {
            atBottom = false;
        }

        if (atBottom && !xhrOpened) {
            atBottom = false;
            xhrOpened = true;
            !noPosts && showSpinner();
            setTimeout(function () {
                fillRibbon();
            }, 1000);
        }
    };
});