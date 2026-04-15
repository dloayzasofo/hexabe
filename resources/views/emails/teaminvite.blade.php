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
                                    <td align="left" style="text-align: left;">
                                        <table>
                                            <tr>
                                                <td width="300">
                                                    <img src="{{ env('APP_URL') }}/assets/img/safi-mercantil-santa-cruz-logo.png" width="250" height="85" style="width:250px;height:85px;" />
                                                </td>
                                                <td width="300" style="font-size:20px;font-weight:bold;text-align:right;color:#434343;font-family:Arial,Helvetica,sans-serif;line-height:28px;padding-right:15px;">
                                                    Invitación al equipo {{ $teamInvitation->team->name }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height: 10px;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="border-bottom:1px solid #979797;height:12px;"></td>
                                </tr>
                                <tr>
                                    <td height="10" style="width: 100%;">&nbsp;</td>
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
                                                <td style="text-align:justify;font-weight:normal;color:#434343;font-family:Arial,Helvetica,sans-serif;">
                                                    <h3 style="text-decoration:none;margin-bottom:10px;font-weight: bold;font-size: 18px;"> Invitación: </h3>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="20" style="width: 100%;">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td style="text-align:justify;font-weight:normal;font-size: 14px;color:#434343;font-family:Arial,Helvetica,sans-serif;line-height:16px;">
                                                    El equipo {{ $teamInvitation->team->name }} te ha invitado a unirte a su equipo en Hexabe. Para aceptar la invitación, haz clic en el siguiente enlace:
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="20" style="width: 100%;">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="{{ env('APP_URL') }}/team-invitations/accept/{{ $teamInvitation->token }}" style="display: inline-block; padding: 10px 20px; background-color: #007BFF; color: #FFFFFF; text-decoration: none; border-radius: 5px;">Aceptar Invitación</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="30" style="width: 100%;">&nbsp;</td>
                                            </tr>
                                        </table>
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
                                align="center"
                                width="100%"
                                style="margin: 0px auto;background: #fafafa;"
                            >
                                <tr>
                                    <td height="30" style="width: 100%;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="text-align:center;border-radius:14px;overflow:hidden;">
                                        <table
                                            border="0"
                                            cellpadding="0"
                                            cellspacing="0"
                                            align="center"
                                            width="85%"
                                            style="display:inline-block;"
                                        >
                                            <tr>
                                                <td style="text-align:left;font-weight:normal;font-size: 12px;color:#797979;font-family:Arial,Helvetica,sans-serif;line-height:12px;">
                                                    Datos enviados desde <a href="{{ env('APP_URL') }}" style="color:#797979;">{{ env('APP_URL') }}</a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="30" style="width: 100%;">&nbsp;</td>
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