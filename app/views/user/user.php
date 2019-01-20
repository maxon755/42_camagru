<?php echo 'page of ' . $parameters['username'] ?>

<div id="user__toolbar">
    <div>
        <img id="user__troll-face" src="/views/user/assets/troll-face.png" alt="Troll face" draggable="true">
        <img id="user__troll-face-red" src="/views/user/assets/troll-face-red.png" alt="Troll face" draggable="true">
    </div>
</div>

<div id="user__capture">
    <video id="user__video"></video>
    <canvas id="user__canvas"></canvas>
    <div id="user__filter-container"></div>
</div>

<button id="user__stop-button" class="user__button">
    <span class="fas fa-stop-circle fa-3x"></span>
</button>

<button id="user__start-button" class="user__button">
    <span class="fas fa-play-circle fa-3x"></span>
    <span class="fas fa-camera fa-3x"></span>
</button>

<button id="user__save-button" class="user__button" disabled>
    <span class="fas fa-save fa-3x"></span>
</button>

<div id="tmp-cont"></div>

<?php
    $this->registerJsFile('flexible/flexible.js');
    $this->registerCssFile('flexible/flexible.css');

    if (self::$auth->selfPage($parameters['username']))
    {
        echo 'self page';
    }
    else
    {
        echo 'Other page';
    };
