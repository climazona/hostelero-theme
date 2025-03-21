<?php

add_action("login_head", "my_login_head");
add_action("login_headertext", "my_custom_login_title");
add_action('login_headerurl', 'my_custom_login_url');

function my_login_head()
{
    echo '
  <style>
      body.login #login h1 a { width: 252px; height: 84px; background-size: 252px 84px; background-image: url("' . site_url() . '/wp-content/themes/climazona/inc/seoseu.png"); border-radius:1.2rem; background-color:white; padding-bottom:0px; box-shadow: 0 0.5rem 1rem rgb(0 0 0 / 15%);}
      body.login {background-image: url("' . site_url() . '/wp-content/themes/climazona/inc/fondo-login.jpg"); background-repeat: repeat;}
      form#loginform{margin-top:50px; border:0px; border-radius:1.2rem; box-shadow: 0 0.5rem 1rem rgb(0 0 0 / 15%);}
      form#loginform label{font-size: 1rem; color: #6c757d;}
      form#loginform input{padding: .375rem .75rem; font-size: 1rem; font-weight: 400; line-height: 1.5; color: #212529; background-color: #fff; background-clip: padding-box; border: 1px solid #ced4da; -webkit-appearance: none; -moz-appearance: none; appearance: none; border-radius: .25rem; transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;}
  </style>
  ';
}

//Cambiar texto alt del logo de login
function my_custom_login_title()
{
    return 'seoseu.com';
}

// personalizar url logo acceso
function my_custom_login_url()
{
    return 'https://seoseu.com';
}
