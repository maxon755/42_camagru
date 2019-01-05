<?php echo 'page of ' . $parameters['username'] ?>

<div>
    <div>
        <img src="/views/user/assets/troll-face.png" alt="Troll face">
    </div>
</div>

<div id="user__capture">
    <video id="user__video"></video>
    <canvas id="user__canvas"></canvas>
</div>

<button id="user__start-button" class="user__button">
    <span class="fas fa-play-circle fa-3x"></span>
    <span class="fas fa-camera fa-3x"></span>
</button>
<button id="user__stop-button" class="user__button">
    <span class="fas fa-stop-circle fa-3x"></span>
</button>
