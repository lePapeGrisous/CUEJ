 
const video = document.getElementById('video');

const PlayPauseBtn = document.getElementById('PlayPauseBtn');
const playIcon = document.getElementById('playIcon');
const pauseIcon = document.getElementById('pauseIcon');

const MuteUnmuteBtn = document.getElementById('MuteUnmuteBtn');
const muteIcon = document.getElementById('muteIcon');
const unmuteIcon = document.getElementById('unmuteIcon');


document.addEventListener('DOMContentLoaded', () => playIcon.classList.add("hidden"));
document.addEventListener('DOMContentLoaded', () => muteIcon.classList.add("hidden"));

PlayPauseBtn.addEventListener('click', function() {
    if (video.paused || video.ended) {
        video.play();
        pauseIcon.classList.remove("hidden");
        playIcon.classList.add("hidden");
    } else {
        video.pause();
        pauseIcon.classList.add("hidden");
        playIcon.classList.remove("hidden");
    }
});

MuteUnmuteBtn.addEventListener('click', function() {
    if (video.muted) {
        video.muted = false;
        muteIcon.classList.remove("hidden");
        unmuteIcon.classList.add("hidden");
    } else {
        video.muted = true;
        muteIcon.classList.add("hidden");
        unmuteIcon.classList.remove("hidden");
    }
});

