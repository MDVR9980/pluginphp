<link rel="stylesheet" type="text/css" href="<?=plugin_http_path('assets/css/style.css')?>">

<main class="p-4" style="background-color: #dde5f4; height:100vh">
    <form method="post" class="col-xl-3 col-lg-4 col-md-6 col-sm-8 mx-auto p-4 shadow" style="border-radius: 40px; background-color: #f1f7fe">
        <h3 class="text-center mt-2">Signup</h3>
        <div class="mb-4 text-muted text-center"><i>Please enter your details</i></div>
        <div class="form-floating my-2">
            <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" style="border-radius: 40px;">
            <label for="floatingInput">First Name</label>
        </div>
        <div class="form-floating my-2">
            <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" style="border-radius: 40px;">
            <label for="floatingInput">Last Name</label>
        </div>
        <div class="form-floating my-2">
            <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" style="border-radius: 40px;">
            <label for="floatingInput">Email address</label>
        </div>
        <div class="form-floating my-2">
            <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" style="border-radius: 40px;">
            <label for="floatingInput">Password</label>
        </div>
        <div class="form-floating my-2">
            <input type="password" class="form-control" id="floatingPassword" placeholder="Password" style="border-radius: 40px;">
            <label for="floatingPassword">Retype Password</label>
        </div>

        <div class="px-2 d-flex justify-content-between">
            <a href="<?=ROOT?>/<?=$vars['forgot_page']?>">Forgot password</a>
            <a href="<?=ROOT?>/<?=$vars['login_page']?>">or Login</a>            
        </div>

        <buton class="btn text-white px-4 py-3 w-100 my-4" style="background-color: #3d4785; border-radius: 40px">Login</buton>
    </form>
</main>


<script src="<?=plugin_http_path('assets/js/plugin.js')?>"></script>