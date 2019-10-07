<div id="box1">
    <div id="box3">
        <h1 class="titleInHeader">{register}</h1>
        <table border="0" cellspacing="1" cellpadding="0" width="100%">
            <tr>
                <td colspan="2"><img src="images/en/a/banner2.jpg" /></td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2"><h4 class="round">{register_userinfo}</h4>
                    {account_created}</td>
            </tr>


            <form method="POST" action="">
                    <tr class="top">
                        <th><label for="userName">{username}</label></th>
                        <td>
                            <input id="username" class="text" type="text" name="username" value="" maxlength="15" />
                            <span class="error">{error1}</span>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="userEmail">{email}</label></th>
                        <td>
                            <input id="userEmail" class="text" type="text" name="email" value="" maxlength="40" />
                            <span class="error">{error2}</span>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="userEmail">{email_confirm}</label></th>
                        <td>
                            <input id="userEmail" class="text" type="text" name="email2" value="" maxlength="40" />
                            <span class="error">{error3}</span>
                        </td>
                    </tr>
                    <tr class="btm">
                        <th><label for="userPassword">{password}</label></th>
                        <td>
                            <input id="userPassword" class="text" type="password" name="password" value="" maxlength="20" />
                            <span class="error">{error4}</span>
                        </td>
                    </tr>
                    <tr class="btm">
                        <th><label for="userPassword">{password_confirm}</label></th>
                        <td>
                            <input id="userPassword" class="text" type="password" name="confirmpassword" value="" maxlength="20" />
                            <span class="error">{error5}</span>
                        </td>
                    </tr>
                    <tr class="btm">
                        <th> <label for="agb">{accept_rules}</label>  </th>
                        <td>
                            <div class="checks">
                                <input class="check" type="checkbox" id="agb" name="agb" value="1"/>

                            </div>
                        </td>
                    </tr>
                    <tr class="btm">
                        <th><td>   <ul class="important">

                                {error6} <br> {notice}

                            </ul>  </td>
                    </tr><tr class="btm">
                        <td colspan="2" align="center">
                            <div class="btn">
                                <button type="submit" value="register" name="submit" id="btn_signup" title="Register">
                                    <div class="button-container">
                                        <div class="button-position">
                                            <div class="btl">
                                                <div class="btr">
                                                    <div class="btc"></div></div></div>
                                            <div class="bml">
                                                <div class="bmr">
                                                    <div class="bmc"></div></div></div>
                                            <div class="bbl">
                                                <div class="bbr">
                                                    <div class="bbc"></div></div></div></div>
                                        <div class="button-contents">{register_submit}</div></div>
                                </button>
                            </div>   </td>
                    </tr>

        </table>

    </div>
</div>
</div>

<div id="boxright1">
    <div class="boxright13">
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td height="57" valign="top"><a href="login.php"><img src="images/en/t2/server1.jpg" width="279" height="51" /></a></td>
            </tr>
            <tr>
                <td><table border="0" cellspacing="1" cellpadding="0" class="p3" width="280">
                        <tr>
                            <td>{Total}</td>
                            <td align="right"><strong>{players}</strong></td>
                        </tr>
                        <tr>
                            <td>{Active}</td>
                            <td align="right"><strong>{active}</strong></td>
                        </tr>
                        <tr>
                            <td>{Online}</td>
                            <td align="right"><strong>{online}</strong></td>
                        </tr>
                    </table></td>
            </tr>
            <tr>
                <td height="20"></td>
            </tr>
            <tr>
                <td height="57" valign="top"><img src="images/en/t2/server2.jpg" width="281" height="52" /></td>
            </tr>
            <tr>
                <td><table border="0" cellspacing="1" cellpadding="0" class="p3" width="280">
                        <tr>
                            <td>{Total}</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>{Active}</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>{Online}</td>
                            <td>&nbsp;</td>
                        </tr>
                    </table></td>
            </tr>
        </table>

    </div>
</div>
<!--end right-->

</div>
