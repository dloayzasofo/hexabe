<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body style="background: #eaeced;">
    <!--[if (gte mso 9)|(IE)]>
    <style type="text/css">
    a{
    font-weight: normal !important;
    text-decoration: none !important;
    }
    </style>
    <![endif]-->
    <style>
      a{
        text-decoration: none;
      }
    </style>
    <table align="center" bgcolor="#EAECED" border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td height="60" style="width: 100%;">&nbsp;</td>
        </tr>
        <tr>
            <td>
                <table
                    id="centerTable"
                    border="0"
                    cellpadding="0"
                    cellspacing="0"
                    width="600"
                    align="center"
                    style="width:600px;text-align:center;margin:auto;background: #FFFFFF;"
                >
                    <tr>
                        <td>
                            <table
                                border="0"
                                cellpadding="0"
                                cellspacing="0"
                                align="center"
                                width="100%"
                                style="margin: 0px auto;"
                            >
                                <tr>
                                    <td height="50" style="height: 50px;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="center" style="text-align: center;">
                                        <img src="{{ env('APP_URL') }}/public/assets/img/logo.png" width="209" height="59" style="width:209px;height:59px;" />        
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table
                                border="0"
                                cellpadding="0"
                                cellspacing="0"
                                width="600"
                                style="max-width:600px;"
                            >
                                <tr>
                                    <td>
                                        <table
                                            border="0"
                                            cellpadding="0"
                                            cellspacing="0"
                                            width="85%"
                                            align="center"
                                            style="margin: auto;"
                                            >
                                            <tr>
                                                <td style="text-align:center;font-weight:normal;color:#313131;font-family:Arial,Helvetica,sans-serif;">
                                                    <h3 style="text-decoration:none;margin-bottom:10px;font-weight: bold;font-size:36px;">Restaura tu contraseña </h3>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="50" style="width: 100%;">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td style="text-align:justify;font-weight:normal;font-size: 18px;color:#313131;font-family:Arial,Helvetica,sans-serif;line-height:26px;">
                                                    <strong> Has solicitado restaurar tu contraseña,</strong> te hemos enviado un enlace de restablecimiento de contraseña.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="30" style="width: 100%;">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td style="text-align:center;font-weight:normal;font-size: 16px;color:#313131;font-family:Arial,Helvetica,sans-serif;line-height:26px;">
                                                    Haz clic en el botón para restaurar tu contraseña.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="30" style="width: 100%;">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td align="center">
                                                    <table
                                                    border="0"
                                                    cellpadding="0"
                                                    cellspacing="0"
                                                    width="250px"
                                                    align="center"
                                                    style="background:#1414B8;border-radius:5px;margin: auto;"
                                                    >
                                                        <tr>
                                                            <td align="center" style="padding:12px;">
                                                               <a href="{{ route('resetpassword.show', ['token'=> $user->remember_token]) }}"
                                                                style="text-align:center;font-weight:bold;font-size: 16px;color:#FFFFFF;font-family:Arial,Helvetica,sans-serif;line-height:26px;display:block;width:100%;">
                                                                    Restaurar contraseña 
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="25" style="width: 100%;">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td style="text-align:justify;font-weight:normal;font-size: 16px;color:#313131;font-family:Arial,Helvetica,sans-serif;line-height:26px;">
                                                    <p> Si tienes problemas haciendo clic en el botón de "Restaurar contraseña", prueba copiando y pegando este enlace en tu navegador: </p>
                                                    <a href="{{ route('resetpassword.show', ['token'=> $user->remember_token]) }}"
                                                    style="color:#1414B8;font-size:14px;">{{ route('resetpassword.show', ['token'=> $user->remember_token]) }}</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="15" style="width: 100%;">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td style="text-align:justify;font-weight:normal;font-size: 16px;color:#313131;font-family:Arial,Helvetica,sans-serif;line-height:26px;">
                                                    <p> Si no has solicitado restablecer tu contraseña, no tienes que hacer nada.</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="50" style="width: 100%;">&nbsp;</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td height="60" style="width: 100%;">&nbsp;</td>
        </tr>
    </table>
</body>
</html>