<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container mt-3 ">
  <h2>Form</h2>
  <form>
    <div class="mb-3 mt-3">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
    </div>
    <div class="mb-3">
      <label for="pwd">Password:</label>
      <input type="password" class="form-control" id="password" placeholder="Enter password" name="password">
    </div>
    <button id="loginButton" type="submit" class="btn btn-primary">Submit</button>
  </form>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        $("#loginButton").on("click" ,function(){
            const email = $('#email').val();
            const password = $('#password').val();

            $.ajax({
                url : '/api/login',
                type : 'POST',
                contentType : 'application/json',
                data : JSON.stringify({
                    email : email,
                    password : password,
                }),
                success:function(response){
                    console.log(response);
                    localStorage.setItem('api_token' , response.token); 
                    window.location.href = "/allpost"; 
                },
                error: function(xhr,status) {
                   alert("Error : " + xhr.responseText);
                }
            });
        });
    });
</script>

</body>
</html>
