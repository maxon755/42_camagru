<?php
return <<<MAIL
    <body>
        <h3>Thank you for the registration</h3>
        <p>To activate your account press the button below</p>
        <div style=3D"margin-left: 100px;
                    margin-top:25px;">
            <a  href=3D"$link" 
                style=3D"display: table-cell;
                    height: 50px;
                    background-color: green;
                    border: none;
                    border-radius: 10px;

                    text-decoration: none;

                    text-align: center;
                    vertical-align: middle;
                    color: white;
                    font-size: 1em;">
                    <div style=3D"width: 100px;">
                        Activate
                    </div>
            </a>
        </div>
    </body>
MAIL;


