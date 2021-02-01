<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Best Ecommerce Platform - 5HIMAKA
                    </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>@import url("https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap");

* {
  box-sizing: border-box;
}

body {
  background-color: #ecf0f1;
  font-family: "Roboto", sans-serif;
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100vh;
  overflow: hidden;
  margin: 0;
}

img {
  max-width: 100%;
}

.card {
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
  border-radius: 10px;
  overflow: hidden;
  width: 350px;
}

.card-header {
  height: 200px;
}

.card-header img {
  object-fit: cover;
  height: 100%;
  width: 100%;
}

.card-content {
  background-color: #fff;
  padding: 30px;
}

.card-title {
  height: 20px;
  margin: 0;
}

.card-excerpt {
  color: #777;
  margin: 10px 0 20px;
}

.author {
  display: flex;
}

.profile-img {
  border-radius: 50%;
  overflow: hidden;
  height: 40px;
  width: 40px;
}

.author-info {
  display: flex;
  flex-direction: column;
  justify-content: space-around;
  margin-left: 10px;
  width: 100px;
}

.author-info small {
  color: #aaa;
  margin-top: 5px;
}


}
}
</style>
</head>
<body>
<div class="card">
      <div class="card-header animated-bg" id="header"> <div class="row">
    <div class="col-md-12">
    @if(Session::has('referenceNumber'))
            <div class="row">
              <div class="text-center alert-info" style="padding:50px;margin:15px;width:100%">Success You can paid with reference number {{ Session::get('referenceNumber') }} <br></div>
            </div>
            @else
        <div class="links">
        <a style="display: inherit;
    margin: 10px;
    width: 95%;" class="btn btn-primary" href="{{ route('paycard',$amount) }}">Credit Card</a>
   <a style="display: inherit;
    margin: 10px;
    width: 95%;" class="btn btn-info"   href="{{ route('paykiosk',$amount) }}">Accept Number</a>
   <a style="display: inherit;
    margin: 10px;
    width: 95%;" class="btn btn-danger" href="{{ route('payfawry',$amount) }}">Fawry Number</a>
 
        </div>
        @endif
    </div>
  </div> </div>

     
    </div>
    <script>
   
    </script>
</body>
</html>
  <!-- -->
