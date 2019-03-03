window.addEventListener('load', () => {
   console.log('works');

   let dataUrl  = '/ribbon/get-posts';
   let offset   = 0;
   let limit    = 5;

   getPosts(offset, limit)
       .then(response => {
           console.log(response);
       });

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
});