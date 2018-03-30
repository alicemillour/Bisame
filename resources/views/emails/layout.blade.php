<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
    <style>
        @media only screen and (max-width: 600px) {
            .inner-body {
                width: 100% !important;
            }

            .footer {
                width: 100% !important;
            }
        }

        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }
        .wrapper {
            color:#4a4a4a;font-family:'Museo Sans Rounded',Museo Sans Rounded,'Museo Sans',Museo Sans,'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:14px;line-height:20px;border-collapse:collapse;border-spacing:0;margin:0 auto;
            background-color: #f3f3f3;
        }
        .content-cell{
            border-radius: 15px;
            border: 1px solid white;
            background-color: white;
            padding: 0  15px;
        }
        .inner-body {
            margin:20px auto
        }
        .footer {
            padding:30px 0px;
            text-align: center;
            font-size: 12px;
            color: #bbbbbb;
        }
        h1 {
            text-align: center;
            padding: 10px 0;
        }
        a {
            text-decoration: none;
            color: #bbbbbb;
        }
    </style>

    <table class="wrapper" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table class="content" width="100%" cellpadding="0" cellspacing="0">
                    {{ $header or '' }}

                    <!-- Email Body -->
                    <tr>
                        <td class="body" width="100%" cellpadding="0" cellspacing="0">
                            <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0">

                                <!-- Body content -->
                                <tr>
                                    <td class="content-cell">
                                        <h1><a href="{{ url('/') }}">Corpus en sauce</a></h1>

                                        @yield('content')


                                        <p>

                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class="body" width="100%" cellpadding="0" cellspacing="0">
                            <div class="footer">
                                <a href="http://localhost/Bisame/public/home">Vous ne souhaitez plus recevoir de notifications de notre part ?</a>
                            </div>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>
</body>
</html>