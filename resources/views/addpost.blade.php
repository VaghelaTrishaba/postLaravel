<html>
    <head>
        <title>Add Post</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    </head>

    <body>
        <div class="container">
            <div class="row">
                <div class="col-8 bg-primary text-white mb-4">
                    <h1>Create Post</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-8">
                    <form id="addform">
                        Title:<input type="text" id="title" class="form-control mb-3"><br/>
                        Description:<textarea id="description" class="form-control mb-3"></textarea><br/>
                        <input type="file" id="image" placeholder="image" class="form-control mb-3"><br/>
                        <input type="submit" placeholder="Add" class="btn btn-primary">&nbsp;

                        <a href="/Post" class="btn btn-secondary">Back</a>
                    </form>
                </div>
            </div>
        </div>
        <script>
            var addform = document.querySelector("#addform");        //target form 
            addform.onsubmit = async (e) => {
                e.preventDefault();

                const token = localStorage.getItem('api_token');
                const title = document.querySelector("#title").value;               //get value
                const description = document.querySelector("#description").value;
                const image = document.querySelector("#image").files[0];

                var formData = new FormData();          //form ma value add krava,make object of formData class
                formData.append('title',title);             //add all value
                formData.append('description',description);
                formData.append('image',image);
             
                let r = await fetch('api/posts',{                //send data into server 
                        method :'POST',
                        body : formData,  //for send data
                        headers : {
                           'Authorization' :`Bearer ${token}`, 
                        }
                }).then(response => response.json()).then(data => {window.location.href="/Post";});
            }   
        </script>
    </body>
</html>