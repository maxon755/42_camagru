;var postModule = (function() {
    'use strict';

    function toggleLike(event) {
        let dataUrl = '/ribbon/toggle-like';
        let heart = event.target;
        let likeCounter = heart.closest('.post__like-block')
                               .getElementsByClassName('post__like-counter')[0];
        let postId = heart.closest('.post__container').dataset.postId;

        performRequest(dataUrl, { postId })
            .then(response => JSON.parse(response))
            .then(response => {
                if (response.success) {
                    heart.classList.add('liked');
                } else {
                    heart.classList.remove('liked');
                }
                likeCounter.innerText = response.likeCount;
            })
            .catch((error) => {
                alert(error.message);
            })
    }

    function toggleCommentEditor(event)
    {
        let comment         = event.target;
        let post            = comment.closest('.post__container');
        let commentEditor   = post.getElementsByClassName('post__comment-editor')[0];
        let commentInput    = commentEditor.querySelector('textarea');
        let editorState     = commentEditor.style.display;

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
        let postId = parseInt(form.closest('.post__container').dataset.postId);

        return new Promise((resolve, reject) => {
            if (comment.trim() === '') {
                alert('Comment should not be empty');
                reject();
            }

            performRequest(action, { postId, comment })
                .then(response => JSON.parse(response))
                .then(response => {
                        closeCommentEditor(submitButton);
                        resolve(response);
                    }
                )
                .catch(error => {
                    reject(error);
                });
        });
    }

    function closeCommentEditor(submitButton) {
        let commentEditor = submitButton.closest('.post__comment-editor');
        let commentInput = commentEditor.querySelector('textarea');

        commentInput.value = '';
        commentEditor.style.display = 'none';
    }

    function deleteComment(event) {
        event.preventDefault();

        let dataUrl = '/ribbon/delete-comment';

        let deleteButton    = event.target;
        let comment         = deleteButton.closest('.comment__container');
        let commentId       = comment.dataset.commentId;

        performRequest(dataUrl, { commentId })
            .then(response => JSON.parse(response))
            .then(response => {
                    if (response.success) {
                        comment.parentElement.removeChild(comment);
                    }
                }
            )
            .catch(error => {
                    alert(error.message);
                }
            );
    }

    function commentNotify(commentId)
    {
        performRequest('/ribbon/commentNotify', commentId);
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
                resolve(this.response);
            };

            xhr.onerror = function () {
                reject(new Error("Network Error"));
            }
        });
    }

    return {
        toggleLike,
        toggleCommentEditor,
        createComment,
        deleteComment,
        commentNotify
    }
}());

window.addEventListener('load', function () {
   let hearts = document.getElementsByClassName('like');

   for (i = 0; i < hearts.length; i++) {
       hearts[i].addEventListener('click', function () {
           postModule.toggleLike();
       })
   }
});
