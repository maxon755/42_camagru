<?php
    /** @var \app\base\View $this */
?>

<div id="camera__toolbar">
    <div>
        <img id="camera__troll-face" src="/views/user/assets/troll-face.png" alt="Troll face" draggable="true">
        <img id="camera__troll-face-red" src="/views/user/assets/troll-face-red.png" alt="Troll face" draggable="true">
    </div>
</div>

<div id="camera__capture">
    <video id="camera__video"></video>
    <canvas id="camera__canvas"></canvas>
    <div id="camera__filter-container"></div>
</div>

<div class="camera__buttons">
    <button id="camera__stop-button" class="camera__button">
        <span class="fas fa-stop-circle fa-3x"></span>
    </button>

    <button id="camera__start-button" class="camera__button">
        <span class="fas fa-play-circle fa-3x"></span>
        <span class="fas fa-camera fa-3x"></span>
    </button>

    <button id="camera__save-button" class="camera__button" disabled>
        <span class="fas fa-save fa-3x"></span>
    </button>
</div>

<div id="tmp-cont"></div>

<?php
    $this->registerJsFile('camera');
    $this->registerCssFile('camera');