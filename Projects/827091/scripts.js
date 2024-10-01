var audio = document.getElementById("myaudio");
var currentTimeElement = document.getElementById("currentTime");
var durationElement = document.getElementById("duration");
var seekToInput = document.getElementById("seekTo");

function pauseplay(){
    var btn = document.getElementById("btn-pause");

    if (btn.innerHTML == "Pause") {
        audio.pause();
        btn.innerHTML = "Play";
    } else {
        audio.play();
        btn.innerHTML = "Pause";
    }
  }

function rewind() {
    audio.currentTime -= 5;
}

function forward() {
    audio.currentTime += 5;
}

audio.addEventListener("timeupdate", function() {
    var currentTime = audio.currentTime;
    var duration = audio.duration;

    // Update progress bar
    var progress = (currentTime / duration) * 100;
    updateProgress(progress);

    // Update current time display
    currentTimeElement.textContent = formatTime(currentTime);

    // Update duration display
    if (!isNaN(duration)) {
        durationElement.textContent = formatTime(duration);
    }
});

function formatTime(time) {
    var minutes = Math.floor(time / 60);
    var seconds = Math.floor(time % 60);
    return minutes + ":" + (seconds < 10 ? "0" : "") + seconds;
}

function goToTime(time) {
    if (!isNaN(time) && isFinite(time)) {
        audio.currentTime = time;
    }
}

function updateProgress(percentage) {
    const progressBar = document.querySelector('.bar');
    progressBar.style.width = percentage + '%';
}

function addTitle() {
    var userInput = document.getElementById("add").value;
    var playlist = document.getElementById("playlist");
    var currentTime = audio.currentTime;
    var li = document.createElement("li");

    var btnTitle = document.createElement("button");
    var btnRemove = document.createElement("button");

    btnTitle.innerHTML = userInput;
    btnRemove.innerHTML = "-";

    btnTitle.id = currentTime;
    btnRemove.className = "btn-danger"

    btnRemove.onclick = function() {
        var currentTime = audio.currentTime;
        var btn = document.getElementById(currentTime);
        btn.remove();
    }

    li.appendChild(btnTitle);
    li.appendChild(btnRemove);

    playlist.appendChild(li);
}

function removeTitle(event) {
    var buttonClicked = event.target
    buttonClicked.parentElement.parentElement.remove()
    buttonClicked.parentElement.remove()
}