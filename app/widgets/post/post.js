;var postModule = (function() {
    let dataUrl = '/ribbon/toggle-like';

    function toggleLike(event) {
        let heart = event.target;
        let likeCounter = heart.closest('.post__like-block')
                               .getElementsByClassName('post__like-counter')[0];
        let postId = heart.closest('.post__container').dataset.postId;

        performRequest(postId)
            .then(response => {
                if (response.likeAdded) {
                    heart.classList.add('liked');
                } else {
                    heart.classList.remove('liked');
                }
                likeCounter.innerText = response.likeCount;
            })
            .catch(() => {})
    }

    function performRequest(postId) {
        return new Promise((resolve, reject) => {
            let xhr         = new XMLHttpRequest();
            let formData    = new FormData();

            formData.append('postId', postId);
            xhr.open('post', dataUrl);
            xhr.send(formData);

            xhr.onload = function() {
                try {
                    var json = JSON.parse(this.response);
                }
                catch(e) {
                    reject();
                }
                resolve(json);
            };

            xhr.onerror = function () {
                reject(this.response);
            }
        });
    }

    return {
        toggleLike
    }
}());

window.addEventListener('load', function () {
   let hearts = document.getElementsByClassName('fa-heart');

   for (i = 0; i < hearts.length; i++) {
       hearts[i].addEventListener('click', function () {
           postModule.toggleLike();
       })
   }
});