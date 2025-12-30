<table>
    <head>
        <title>Login page</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    </head>

    <body>
        <div class="container mt-5">
            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-header">
                            <h2><b>Login</b></h2>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                Email:<input type="email" id="email" class="from-control">
                            </div>
                            <div class="mb-3">
                                password:<input type="password" id="password" class="from-control">
                            </div>
                            <button id="loginButton" class="btn btn-primary">Login</button>
                        </div>
                        <div class="card-footer"></div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        
        <script>
            $(document).ready(function(){           //this function use for cheack document load or not
                    $("#loginButton").on('click',function(){
                            const email = $("#email").val();            //get pass & email from login upper
                            const password = $("#password").val();

                            $.ajax({
                                url : '/api/login',
                                type : 'POST',
                                contentType : 'application/json',
                                data : JSON.stringify({
                                    email : email,
                                    password : password
                                }),
                                success : function(response)
                                {
                                        console.log(response);

                                        localStorage.setItem('api_token',response.token);       //save token of user
                                        window.location.href = "/home";   //redirect to post page 
                                },
                                error : function(xhr,status,error){
                                        alert('Error' + xhr.responseText);  //error in text formate 
                                }
                            });
                    });
            });
        </script>

    </body> 
</table>