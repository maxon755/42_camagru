;var postModule = (function() {
    'use strict';

    let dataUrl = '/ribbon/toggle-like';

    function toggleLike(event) {
        let heart = event.target;
        let likeCounter = heart.closest('.post__like-block')
                               .getElementsByClassName('post__like-counter')[0];
        let postId = heart.closest('.post__container').dataset.postId;

        performRequest(dataUrl, { postId })
            .then(response => {
                if (response.likeAdded) {
                    heart.classList.add('liked');
                } else {
                    heart.classList.remove('liked');
                }
                likeCounter.innerText = response.likeCount;
            })
            .catch((response) => {
                console.log(response)
            })
    }

    function performRequest(action, data) {
        return new Promise((resolve, reject) => {
            let xhr         = new XMLHttpRequest();
            let formData    = new FormData();

            for (let key in data) {
                if (data.hasOwnProperty(key)) {
                    formData.append(key, data[key]);
                }
            }
            xhr.open('post', action);
            xhr.send(formData);

            xhr.onload = function() {
                try {
                    var json = JSON.parse(this.response);
                }
                catch(e) {
                    reject(this.response);
                }
                resolve(json);
            };

            xhr.onerror = function () {
                reject(this.response);
            }
        });
    }

    function toggleCommentEditor(event)
    {
        let comment = event.target;
        let post = comment.closest('.post__container');
        let commentEditor = post.getElementsByClassName('post__comment-editor')[0];
        let commentInput = commentEditor.querySelector('textarea');
        let editorState = commentEditor.style.display;

        if (editorState !== 'block') {
            commentInput.value = '';
        }
        commentEditor.style.display = editorState !== 'block'
            ? 'block'
            : 'none';
    }

    function createComment(event) {
        event.preventDefault();

        let submitButton = event.target;
        let form = submitButton.closest('form');
        let action = form.action;
        let comment = form.querySelector('textarea').value;
        let postId = form.closest('.post__container').dataset.postId;

        performRequest(action, {
            postId,
            comment
        })
            .then(response => {
                console.log(response);
            })
            .catch(response => {
                console.log(response);
            });
    }

    return {
        toggleLike,
        toggleCommentEditor,
        createComment
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