<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>BitRegion Email</title>
</head>

<body bgcolor="#EEEEEE"; style=" margin: 0; padding: 0; line-height: 1.6; width: 100% !important; height: 100%;">
<div style="background-color:#eeeeee; background-image:url('http://s7.postimg.org/rvamfe3yj/200black.png'); background-repeat: repeat-x;">
    <table style="max-width:700px;" align="center" width="100%" cellpading="0" cellspacing="0">
        <tr>
            <td>&nbsp;</td>
            <td bgcolor="black" width="90%" height="50" valign="bottom"><br><img src="http://s9.postimg.org/6eesqjzf3/logo.png" width="300" style="margin-bottom:5px;"/></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>
                <div style="padding:30px; background-color:#FFF; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; font-size:14px; font-family: sans-serif; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; color:#999;">
                    <p>Dear member,</p>
                    <p>You have requested to reset a password for email address <strong style="color:#000;">{{ $email }}</strong> registered to your account.</p>
                    <p>To confirm and to perform this action, please click the button below:<br/><br/>

                        <!--[if mso]>
                        <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="{{ URL::route('password-reset',['data'=>$data]) }}" style="height:40px;v-text-anchor:middle;width:200px;" arcsize="10%" stroke="f" fillcolor="#e2a029">
                            <w:anchorlock/>
                            <center>
                        <![endif]-->
                        <a href="{{ URL::route('password-reset',['data'=>$data]) }}"
                           style="background-color:#e2a029;border-radius:4px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:13px;font-weight:bold;line-height:40px;text-align:center;text-decoration:none;width:200px;-webkit-text-size-adjust:none;">Reset Password</a>
                        <!--[if mso]>
                        </center>
                        </v:roundrect>
                        <![endif]-->
                        <br><br>
                    </p>
                    <p>You will be redirected to a reset password page.</p>
                    <p>Thank you.</p>


                    <p>Kind regards,<br/>
                        <strong style="color:#000;">Team {{ env('SITE_NAME') }}</strong></p>
                    <br><br>
                    <div style="font-size:12px; color:#999; border-top:thin solid #CCC; padding-top:10px;">You have received this email to {{ $email }} because you are a registered bitregion.com member.<br>
                        <a href="{{ env('SITE_URL') }}/members/manage-emails" style="text-decoration:none; color:#999; font-weight:bold;">Manage Email Notification</a></div>
                </div>
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td height="40" valign="middle" style="font-size:12px; color:#999; font-family: sans-serif; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none;">
                <table width="100%">
                    <tr>
                        <td align="left">Los Angeles, CA 90069</td>
                        <td align="right"><strong>2015 &copy; BitRegion.com</strong></td>
                    </tr>
                </table>
            </td>
            <td>&nbsp;</td>
        </tr>
    </table>
</div>
</body>
</html>
