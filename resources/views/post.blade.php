@extends('layouts.mainlayout')

@section('title')
    Post
@endsection

@section('content')


    <html>
        <head>
            <title>All Posts</title>
        <style>
            table {
                border-collapse: collapse; /* merge borders */
                width: 80%;
            }

            table, th, td {
                border: 1px solid black; /* border for all */
            }

            th, td {
                padding: 10px;
                text-align: center;
            }
        </style>
        </head>
    <body>
        <center><h1>All Post</h1></center><br>
        <div>
             <a href="/addpost"><button> Add New </button></a> &nbsp;&nbsp; <button id="logoutButton"> Logout </button><br><br>
        </div>
        <center>
             <div id="test"></div>
        </center>


        <!--view Modal box-->
         <div class="modal fade" id="singlemodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="singleLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="singleLabel">Single Post</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
        </div>


        <!--update Modal box-->
         <div class="modal fade" id="updatemodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="updateLabel">Single Post</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="updateForm">
                    <div class="modal-body">
                    
                            <input type="text" id="postId" class="form-control" value=" ">
                            <b>Title:</b><input type="text" id="postTitle" class="form-control" value=" ">
                            <b>Description:</b><input type="text" id="postBody" class="form-control" value=" ">
                            <img id="showImage" width="150px">
                            <input type="file" id="postImage" class="form-control" placeholder="upload image">
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" value="save changes" class="btn btn-primary" />
                    </div>
                </form>
                </div>
            </div>
        </div>

        <!--bootstrap link-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

        <script>

            //logout logic
            document.querySelector("#logoutButton").addEventListener('click',function(){
                const token = localStorage.getItem('api_token');

                fetch('/api/logout',{
                    method : 'POST',
                    headers : {'Authorization' : `Bearer ${token}`}    //login hase ej logout thase 
                }).then(response => response.json()).then(data => {window.location.href = "/"});  //header no response then ma Aavse
            });

            //load data from database
            function loadData()
            {
                const token = localStorage.getItem('api_token');

                fetch('api/posts',{
                   method : 'GET',
                   headers : {'Authorization' :`Bearer ${token}`}
                }).then(response => response.json())
                  .then(data => {
                    var allpost=  data.posts;  //TACK DATA FROM DATABASE

                    const postContainer = document.querySelector("#test");      

                        var tabledata = `<table>         
                                <tr>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>View</th>
                                    <th>Update</th>
                                    <th>Delete</th>
                                </tr>
                            `;

                                allpost.forEach(post => {
                                        tabledata += 
                                            `<tr>
                                                <td>
                                                    <img src = "/uploads/${post.image}" width="150px">
                                                </td>    
                                                <td><h6> ${post.title}</h6></td>
                                                <td>${post.description}</td>
                                                <td><button type="button" data-id="${post.id}" data-bs-toggle="modal" data-bs-target="#singlemodal">View</button></td>
                                                <td><button type="button" data-id="${post.id}" data-bs-toggle="modal" data-bs-target="#updatemodal">Update</button></td>
                                                <td><button onclick="deletePost(${post.id})">Delete</button></td>
                                            </tr> `;
                                });
                        tabledata += `</table>`;

                        postContainer.innerHTML = tabledata ;
                   });
            }

            loadData();

            //open single modal view
            var singlemodal = document.querySelector("#singlemodal");
            if (singlemodal) 
            {
                singlemodal.addEventListener('show.bs.modal', event => {
                    const button = event.relatedTarget       // Button that triggered the modal
                    const id = button.dataset.id;    // Extract info from button
                    const token = localStorage.getItem('api_token');

                    fetch(`/api/posts/${id}`,{
                        method : 'GET',
                        headers : {
                            'Authorization' :`Bearer ${token}`, 
                            'Content-type' : 'application/json',
                        }
                    }).then(response => response.json()).then(data => {
                        const post = data.data.post[0]; 
                        const modalbody = document.querySelector("#singlemodal .modal-body");
                        modalbody.innerHTML = "";


                        modalbody.innerHTML = 
                            `<b>Title :</b> ${post.title}  
                            <br> 
                            <b>Discription:</b> ${post.description} 
                            <br> 
                            <img  width="150px" src="http://localhost:8000/uploads/${post.image}"/>
                            `;
                    });
                })
            }   

            //update modal view
            var updatemodal = document.querySelector("#updatemodal");
            if (updatemodal) 
            {
                updatemodal.addEventListener('show.bs.modal', event => {
                    const button = event.relatedTarget       // Button that triggered the modal
                    const id = button.dataset.id;       // Extract info from button
                    const token = localStorage.getItem('api_token');

                    fetch(`/api/posts/${id}`,{
                        method : 'GET',
                        headers :
                        {
                            'Authorization' :`Bearer ${token}`, 
                            'Content-type' : 'application/json',
                        }
                    }).then(response => response.json()).then(data => {
                        const post = Array.isArray(data.data.post)? data.data.post[0] : data.data.post;
                        
                        document.querySelector("#postId").value=post.id;
                        document.querySelector("#postTitle").value=post.title;
                        document.querySelector("#postBody").value=post.description;
                        document.querySelector("#showImage").src=`/uploads/${post.image}`;
                    });
                })
            }   

            //update data

            var updateform = document.querySelector("#updateForm");        //target form 
            updateform.onsubmit = async (e) => {
                e.preventDefault(); //page refresh nai thay

                const token = localStorage.getItem('api_token');

                const id = document.querySelector("#postId").value;   
                const title = document.querySelector("#postTitle").value;               //get value
                const description = document.querySelector("#postBody").value;
                
                var formData = new FormData();         //form ma value add krava,make object of formData class
                formData.append('id',id);
                formData.append('title',title);             //add all value
                formData.append('description',description);

                if (!document.querySelector("#postImage").files[0] == " ") 
                {
                    const image = document.querySelector("#postImage").files[0];
                    formData.append('image', image);
                }

                let a = await fetch(`/api/posts/${id}`,{                //send data into server 
                        method :'POST',
                        body : formData,  //for send data
                        headers : {
                           'Authorization' :`Bearer ${token}`,
                           'X-HTTP-Method-Override' : 'PUT'
                        }
                }).then(response => response.json()).then(data => {console.log(data);window.location.href="/Post";});
            }   

            //delete post
            async function deletePost(postId)
            {
                const token = localStorage.getItem('api_token');

                 let a = await fetch(`/api/posts/${postId}`,{                //send data into server 
                        method :'DELETE',
                        headers : {
                           'Authorization' :`Bearer ${token}`,  
                           'Content-type' : 'application/json'
                        }
                }).then(response => response.json()).then(data => {console.log(data);window.location.href="/Post";});

            }

        </script>
    </body>
</html>

@endsection