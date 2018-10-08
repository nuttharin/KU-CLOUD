@extends('layouts.login') 
@section('content')
<style>
    #form_login {
        width: 40%;
        margin: auto;
        padding: 50px;
    }

    @media screen and (max-width: 850px) {
        #form_login {
            width: 70%;
        }
    }

    @media screen and (max-width: 600px) {
        #form_login {
            width: 100%;
        }
    }
</style>
<form id="form_login">
    <div class="alert alert-danger" style="display:none">

    </div>
    <h1>Login</h1>
    <label>Username</label>
    <input type="text" class="form-control" id="email">
    <label>Password</label>
    <input type="text" class="form-control" id="pwd">
    <button class="btn btn-success btn-block mt-3" id="btn-submit-login">Login</button>
</form>


<script>
    $(document).ready(function(){   
        $('#btn-submit-login').click(function() {
            event.preventDefault();
            $.ajax({
                url:"http://localhost:8000/api/Auth",
                method:"POST",
                dataType:"json",
                data:{
                    email:$("#email").val(),
                    password:$("#pwd").val()
                },
                success:(res) => {
                    console.log(res);
                    setCookie("token",res.token);
                    window.location = "/Company/User";
                },
                error:(res) => {
                    if(res.status === 500){
                        $(".alert").show();
                        $(".alert").html("<strong>Error!</strong> Please check email " + $("#email").val() + " to verify.");
                    }
                }
            });
        })
        $("input,button").focus(function() {
            $(".alert").hide();
        });
    });

</script>
@endsection