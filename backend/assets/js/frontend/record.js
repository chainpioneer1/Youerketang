var recordAudio;
var isAudioPlaying = false;
var playAudio;
var audioBlob;

function recordStart() {

    // if (osStatus == 'iOS') {
    //     sendCommand2APP('audiorecordstart', '1');
    //     return;
    // }

    !window.stream && navigator.getUserMedia({
        audio: true,
        video: false
    }, function (stream) {
        window.stream = stream;
        onstream();
    }, function (error) {
        alert(JSON.stringify(error, null, '\t'));
    });

    window.stream && onstream();

    function onstream() {

        recordAudio = RecordRTC(stream, {
            type: 'audio',
            bitsPerSecond: 128000,
            bufferSize: 512,
            numberOfAudioChannels: 1,
            recorderType: StereoAudioRecorder
            // bufferSize: 16384,

        });
        recordAudio.startRecording();
    }
}

function recordStop() {

    // if (osStatus == 'iOS') {
    //     sendCommand2APP('audiorecordstop', '1');
    //     return;
    // }

    if (recordAudio != undefined) {
        recordAudio.stopRecording(function () {
            audioBlob = recordAudio.getBlob();
        });
    }
}

function audioPlayToolset() {


    // if (osStatus == 'iOS') {
    //     sendCommand2APP('audioplay', '1');
    //     return;
    // }

    if (recordAudio != undefined && audioBlob != undefined) {
        playAudio = new Audio();
        playAudio.src = window.URL.createObjectURL(audioBlob);
        playAudio.play();
        isAudioPlaying = true;
    } else {
        alert('没有录音！');
    }
}

function audioDownloadToolset() {


    // if (osStatus == 'iOS') {
    //     sendCommand2APP('audiodownload', '1');
    //     return;
    // }

    if (recordAudio != undefined && audioBlob != undefined) {
        var audioURL;
        var a = document.createElement("a");
        document.body.appendChild(a);
        a.style = "display: none";
        audioURL = window.URL.createObjectURL(recordAudio.getBlob());
        a.href = audioURL;
        a.download = 'download.wav';
        a.click();
        a.remove();
    } else {
        alert('没有录音！');
    }

}

function audioPlayingStop() {

    // if (osStatus == 'iOS') {
    //     sendCommand2APP('audiostop', '1');
    //     return;
    // }
    if (recordAudio != undefined && audioBlob != undefined) {
        playAudio.pause();
        isAudioPlaying = true;
    }
}


