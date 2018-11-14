<?php
return <<<MAIL
    <body>
        <h3>Thank you for the registration</h3>
        <p>To activate your account press the button below</p>
        <div style=3D"width:100px; margin-left: 100px; margin-top:25px;">
            <a href=3D"$link">
                <button style=3D"width: 100%;height: 50px;
                    background-color: green;
                    border: none;
                    border-radius: 10px;
                    color: white;
                    font-size: 1em;">
                        Activate
                </button>
            </a>
        </div>
    </body>
MAIL;


