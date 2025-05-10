<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="color-scheme" content="light" />
        <meta name="supported-color-schemes" content="light" />
        <title>{{$data['subject']}}</title>
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
        </style>
    </head>
    <body
        style="
            box-sizing: border-box;
            font-family:  Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
            position: relative;
            -webkit-text-size-adjust: none;
            background-color: #ffffff;
            color: #718096;
            height: 100%;
            line-height: 1.4;
            margin: 0;
            padding: 0;
            width: 100% !important;
        "
    >
        <table
            class="wrapper"
            width="100%"
            cellpadding="0"
            cellspacing="0"
            role="presentation"
            style="
                box-sizing: border-box;
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
                position: relative;
                -premailer-cellpadding: 0;
                -premailer-cellspacing: 0;
                -premailer-width: 100%;
                background-color: #edf2f7;
                margin: 0;
                padding: 0;
                width: 100%;
            "
        >
            <tr>
                <td
                    align="center"
                    style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative;"
                >
                    <table
                        class="content"
                        width="100%"
                        cellpadding="0"
                        cellspacing="0"
                        role="presentation"
                        style="
                            box-sizing: border-box;
                            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
                            position: relative;
                            -premailer-cellpadding: 0;
                            -premailer-cellspacing: 0;
                            -premailer-width: 100%;
                            margin: 0;
                            padding: 0;
                            width: 100%;
                        "
                    >
                        <tr>
                            <td
                                class="header"
                                style="
                                    box-sizing: border-box;
                                    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
                                    position: relative;
                                    padding: 20px 0;
                                    text-align: center;
                                    background:#000;
                                "
                            >
                                <a
                                    href="{{route('index')}}"
                                    style="
                                        box-sizing: border-box;
                                        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
                                        position: relative;
                                        color: #3d4852;
                                        font-size: 19px;
                                        font-weight: bold;
                                        text-decoration: none;
                                        display: inline-block;
                                    "
                                >
                                     <img src="{{my_asset(get_setting('logo'))}}" width="55%" /> 
                                </a>
                            </td>
                        </tr>

                        <!-- Email Body -->
                        <tr>
                            <td
                                class="body"
                                width="100%"
                                cellpadding="0"
                                cellspacing="0"
                                style="
                                    box-sizing: border-box;
                                    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
                                    position: relative;
                                    -premailer-cellpadding: 0;
                                    -premailer-cellspacing: 0;
                                    -premailer-width: 100%;
                                    background-color: #edf2f7;
                                    border-bottom: 1px solid #edf2f7;
                                    border-top: 1px solid #edf2f7;
                                    margin: 0;
                                    padding: 0;
                                    width: 100%;
                                "
                            >
                                <table
                                    class="inner-body"
                                    align="center"
                                    width="570"
                                    cellpadding="0"
                                    cellspacing="0"
                                    role="presentation"
                                    style="
                                        box-sizing: border-box;
                                        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
                                        position: relative;
                                        -premailer-cellpadding: 0;
                                        -premailer-cellspacing: 0;
                                        -premailer-width: 570px;
                                        background-color: #ffffff;
                                        border-color: #e8e5ef;
                                        border-radius: 2px;
                                        border-width: 1px;
                                        box-shadow: 0 2px 0 rgba(0, 0, 150, 0.025), 2px 4px 0 rgba(0, 0, 150, 0.015);
                                        margin: 0 auto;
                                        padding: 0;
                                        width: 570px;
                                    "
                                >
                                    <!-- Body content -->
                                    <tr>
                                        <td
                                            class="content-cell"
                                            style="
                                                box-sizing: border-box;
                                                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
                                                position: relative;
                                                max-width: 100vw;
                                                padding: 32px;
                                            "
                                        >
                                            
                                             <h1
                                                style="
                                                    box-sizing: border-box;
                                                    font-family:  Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
                                                    position: relative;
                                                        font-weight: 700;
                                                        font-size: 30px;                      letter-spacing: -1px;
                                                             padding-top: 20px;
                                                            color: #221f1f;
                                                    text-align: left;
                                                "
                                            >
                                               
                                            </h1>

                                            <table
                                                class="action"
                                                align="center"
                                                width="100%"
                                                cellpadding="0"
                                                cellspacing="0"
                                                role="presentation"
                                                style="
                                                    box-sizing: border-box;
                                                    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
                                                    position: relative;
                                                    -premailer-cellpadding: 0;
                                                    -premailer-cellspacing: 0;
                                                    -premailer-width: 100%;
                                                    margin: auto;
                                                    padding: 0;
                                                    text-align: center;
                                                    width: 100%;
                                                "
                                            >
                                            </table>
                                            <p
                                                style="
                                                    box-sizing: border-box;
                                                    font-family: Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
                                                    position: relative;
                                                    font-weight: 400;
                                                    font-size: 18px;
                                                    line-height: 21px;
                                                    color: #221f1f;
                                                    text-align: left;
                                                "
                                            >
                                                {!! $data['message'] !!}
                                            </p><br>
                                            <p
                                                style="
                                                    box-sizing: border-box;
                                                    font-family: Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
                                                    position: relative;
                                                    font-size: 17px;
                                                    line-height: 0;
                                                    margin-bottom: -4px;
                                                    text-align: left;
                                                "
                                            >
                                                Regards,
                                            </p>
                                            <p
                                                style="
                                                    box-sizing: border-box;
                                                    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
                                                    position: relative;
                                                    font-size: 16px;
                                                    line-height: 1.5em;
                                                    margin-top: 0;
                                                    text-align: left;
                                                "
                                            >
                                               <strong>The {{get_setting('title')}} Team.</strong>

                                            <table
                                                class="subcopy"
                                                width="100%"
                                                cellpadding="0"
                                                cellspacing="0"
                                                role="presentation"
                                                style="
                                                    box-sizing: border-box;
                                                    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
                                                    position: relative;
                                                    border-top: 1px solid #e8e5ef;
                                                    margin-top: 25px;
                                                    padding-top: 25px;
                                                "
                                            >
                                                <tr>
                                                    <td
                                                        style="
                                                            box-sizing: border-box;
                                                            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
                                                            position: relative;
                                                        "
                                                    >
                                                        <p
                                                            style="
                                                                box-sizing: border-box;
                                                                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
                                                                position: relative;
                                                                line-height: 1.5em;
                                                                margin-top: 0;
                                                                text-align: left;
                                                                font-size: 14px;
                                                            "
                                                        >Have questions or need help? Kindly respond to this email or open a support ticket on our website.
                                                           
                                                            <span
                                                                class="break-all"
                                                                style="
                                                                    box-sizing: border-box;
                                                                    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
                                                                    position: relative;
                                                                    word-break: break-all;
                                                                "
                                                            >

                                                            </span>
                                                        </p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative;">
                                <table
                                    class="footer"
                                    align="center"
                                    width="570"
                                    cellpadding="0"
                                    cellspacing="0"
                                    role="presentation"
                                    style="
                                        box-sizing: border-box;
                                        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
                                        position: relative;
                                        -premailer-cellpadding: 0;
                                        -premailer-cellspacing: 0;
                                        -premailer-width: 570px;
                                        margin: 0 auto;
                                        padding: 0;
                                        text-align: center;
                                        width: 570px;
                                    "
                                >
                                    <tr>
                                        <td
                                            class="content-cell"
                                            align="center"
                                            style="
                                                box-sizing: border-box;
                                                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
                                                position: relative;
                                                max-width: 100vw;
                                                padding: 32px;
                                            "
                                        >
                                            <p
                                                style="
                                                    box-sizing: border-box;
                                                    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
                                                    position: relative;
                                                    line-height: 1.5em;
                                                    margin-top: 0;
                                                    color: #b0adc5;
                                                    font-size: 13px;
                                                    text-align: center;
                                                "
                                            >
                                               Copyright © {{ date('Y') }} {{get_setting('title')}}. All rights reserved.
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>
