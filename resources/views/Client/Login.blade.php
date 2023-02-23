@extends('Client.Layout')

@section('body')

    <div class="container"  style="padding-top:200px">
        <div class="eag-content-acc">
            <h3 class="title-head"><span>Đăng nhập tài khoản</span></h3>
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-login margin-bottom-30">
                        <div id="login">
                            <form accept-charset="utf-8" action="/client/login" id="customer_login" method="get">
                                <input name="FormType" type="hidden" value="customer_login">
                                <input name="utf8" type="hidden" value="true">
                                <div class="form-signup">

                                </div>
                                @if (Session::get('notifications'))
                                <h3 class="text-success text-center mb-3">@php echo Session::get('notifications');
                                    Session::put('notifications', null);
                                @endphp</h3>
                            @endif
                               <h6 style="color: red"> @php
                                if( Session::get('fail')){
                                 echo Session::get('fail');
                                 Session::put('fail',null);
                                } 
                                
                             @endphp</h6>
                                <div class="form-signup clearfix">
                                    <fieldset class="form-group">
                                        <label>Email: </label>
                                        <input type="email" class="form-control form-control-lg ega-input-valid"
                                            value="" name="email" id="customer_email" placeholder="Email">

                                    </fieldset>

                                    <fieldset class="form-group">
                                        <label>Mật khẩu: </label>
                                        <input type="password" class="form-control form-control-lg ega-input-valid"
                                            value="" name="password" id="customer_password" placeholder="Mật khẩu">
                                </div>
                                </fieldset><div class="pull-xs-left" style="margin-top: 25px;">
                                    <input class="lo" type="submit" value="Login"
                                        style="width: 100px;height:30px;background-color:black;color:white;margin-top:3px;border-radius:5px" >
                                        <div class="req_pass" style="color: black; font-size:0.7rem">
                                            <a href="" onclick="showRecoverPasswordForm();return false;" >Forgot
                                                password?</a><br>
                                            or <a href="/register" title="Đăng ký">Register</a>
                                        </div>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
                
            </div>

            <input id='5dffb67f27b3439ead8749d496167bdb' name='g-recaptcha-response'
                type='hidden'>
            <script src='../../www.google.com/recaptcha/api4d7a.js?render=6LdD18MUAAAAAHqKl3Avv8W-tREL6LangePxQLM-'></script>
            <script>
                grecaptcha.ready(function() {
                    grecaptcha.execute('6LdD18MUAAAAAHqKl3Avv8W-tREL6LangePxQLM-', {
                        action: 'submit'
                    }).then(function(token) {
                        document.getElementById('5dffb67f27b3439ead8749d496167bdb').value = token;
                    });
                });
            </script>
            @csrf
        </form>
    </div>
    <div id="recover-password" style="display:none;" class="userbox">
        <div class="accounttype">
            <h2>Password recovery</h2>
        </div>
        <form accept-charset='UTF-8' action='/sendemail' method='get'>
            <input name='form_type' type='hidden' value='recover_customer_password'>
            <input name='utf8' type='hidden' value='✓'>

            @php
                if (Session::get('f')) {
                    echo Session::get('f');
                    Session::put('f', null);
                }
            @endphp
            <div class="clearfix large_form large_form-mr10">
                <label for="email" class="icon-field"><i
                        class="icon-login icon-envelope "></i></label>
                <input type="email" value="" size="30" name="email"
                    placeholder="Email" id="recover-email" class="text" />
            </div>

            <div class="clearfix action_account_custommer">
                <div class="action_bottom button dark">
                    <input class="btn" type="submit" value="Send" />
                </div>
                <div class="req_pass">
                    <a href="#"
                        onclick="hideRecoverPasswordForm();return false;">Cancel</a>
                </div>
            </div>

            <input id='513764b72f954590867c53ae735f3222' name='g-recaptcha-response'
                type='hidden'>
            <script src='../../www.google.com/recaptcha/api4d7a.js?render=6LdD18MUAAAAAHqKl3Avv8W-tREL6LangePxQLM-'></script>
            {{-- <script>
                grecaptcha.ready(function() {
                    grecaptcha.execute('6LdD18MUAAAAAHqKl3Avv8W-tREL6LangePxQLM-', {
                        action: 'submit'
                    }).then(function(token) {
                        document.getElementById('513764b72f954590867c53ae735f3222').value = token;
                    });
                });
            </script> --}}
        </form>
    </div>
                {{-- <div id="recover-password" style="margin: 10px 0" class="form-signup">
                    <span>
                        Bạn quên mật khẩu? Nhập địa chỉ email để lấy lại mật khẩu qua email.
                    </span>
                    <form accept-charset="utf-8" action="/account/recover" id="recover_customer_password" method="post">
                        <input name="FormType" type="hidden" value="recover_customer_password">
                        <input name="utf8" type="hidden" value="true">
                        <div class="form-signup"> </div>
                        <div class="form-signup clearfix">

                            <fieldset class="form-group" style="padding-top: 5px">

                                <input type="email" class="form-control form-control-lg ega-input-valid" value=""
                                    name="Email" id="recover-email" placeholder="Email">

                            </fieldset>
                        </div>
                        <div class="action_bottom">
                            <input class="repass" type="submit" value="Send"
                                style="width: 100px;height:30px;background-color:black;color:white;margin-top:3px;border-radius:5px">

                        </div>
                    </form>
                </div>

            </div> --}}
            <div class="col-xs-12 col-sm-6">
                <div id="social_login_widget"></div>
            </div>
        </div>
    </div>

    </div>
    <script type="text/javascript">
        function showRecoverPasswordForm() {
            document.getElementById('recover-password').style.display = 'block';
            document.getElementById('login').style.display = 'none';
        }

        function hideRecoverPasswordForm() {
            document.getElementById('recover-password').style.display = 'none';
            document.getElementById('login').style.display = 'block';
        }
        if (window.location.hash == '#recover') {
            showRecoverPasswordForm()
        }
    </script>
@endsection
