<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<div style="font-family: Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;">
    <table style="width: 100%;">
        <tr>
            <td></td>
            <td bgcolor="#FFFFFF ">
                <div style="padding: 15px; max-width: 600px;margin: 0 auto;display: block; border-radius: 0px;padding: 0px; border: 1px solid lightseagreen;">
                    <table style="width: 100%;background: rgb(29,230,185);">
                        <tr>
                            <td></td>
                            <td>
                                <div>
                                    <table width="100%">
                                        <tr>
                                            <td rowspan="2" style="text-align:center;padding:10px;">
                                                <span style="color:white;font-size: 13px;margin-top: 00px; padding:10px; font-size: 14px; font-weight:normal;">
                                                    <strong>Complete Athlete Team</strong><span></span>
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                            <td></td>
                        </tr>
                    </table>
                    <table style="padding: 10px;font-size:14px; width:100%;">
                        <tr>
                            <td style="padding:10px;font-size:14px; width:100%;">
                                <p>Hi {{ $username }},</p>
                                 <p><br /> We have received your request to reset your password. Please click below link  to change your password.</p>
                                 <p>
                                 {{$url}}
                                 </p>
                                Please ignore this email if you did not request a password change.
                                </p>
                                <p> </p>
                                <p>Best Regards,</p>
                                <p>Complete Athlete Team</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div align="center" style="font-size:12px; margin-top:20px; padding:5px; width:100%; background:#eee;">
                                    © {{ now()->year }} <a href="http://seedoconline.com" target="_blank" style="color:#333; text-decoration: none;">Complete Athlete Team</a>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
</div>