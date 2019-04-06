<?php
/** @var string $link */
/** @var string $username */

return <<<MAIL
    <body>
        <h3>Hi, $username!</h3>
        <p>We have received a password restoration request</p>
        <p>Ignore this mail if it wasn`t you</p>
        <p>To restore your password press the button below</p>
        <div style=3D"margin-left: 100px;
                    margin-top:25px;">
            <a  href=3D"$link" 
                style=3D"display: table-cell;
                    height: 50px;
                    background-color: blue;
                    border: none;
                    border-radius: 10px;

                    text-decoration: none;

                    text-align: center;
                    vertical-align: middle;
                    color: white;
                    font-size: 1em;">
                    <div style=3D"width: 150px;">
                        Restore Password
                    </div>
            </a>
        </div>
    </body>
MAIL;
