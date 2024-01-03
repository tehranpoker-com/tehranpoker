<div id="sound-player" class="jp-jplayer"></div>
<div id="sound-container" class="jp-audio top-player">
    <div class="player-nine">
        <div class="jp-type-single">
            <div class="jp-gui jp-interface">
                <div class="player-container-left">
                    <div class="player-buttons">
                        <a class="jp-play" tabindex="1" title="Play"></a>
                        <a class="jp-pause" tabindex="1" title="Pause"></a>
                    </div>
                    <div class="player-repeat">
                        <a class="jp-repeat" tabindex="1" title="Repeat" onclick="repeatSong(1)"></a>
                        <a class="jp-repeat-off" tabindex="1" title="Repeat Off" onclick="repeatSong(0)"></a>
                        <div class="d-none" id="repeat-song">0</div>
                    </div>
                </div>
                <div class="player-container-middle">
                    <div class="jp-current-time" id="current-time"></div>
                    <div class="jp-progress"><div class="jp-seek-bar"><div class="jp-play-bar"></div></div></div>
                    <div class="jp-duration" id="duration-time"></div>
                </div>
                <div class="player-container-right">
                    <a class="jp-mute" tabindex="1" title="Mute"></a>
                    <a class="jp-unmute" tabindex="1" title="Unmute"></a>
                    <div class="jp-volume-bar" onclick="playerVolume()" title="Volume"><div class="jp-volume-bar-value"></div></div>
                </div>
            </div>
        <div class="jp-no-solution"></div>
        </div>
    </div>
</div>