(function() {
    var canvas = document.getElementById('canvas');
    var context = canvas.getContext('2d');
    var video = document.getElementById('video');
    var save = document.getElementById('save');
    var classified = document.getElementById('classified');
    var oooh = document.getElementById('oooh');
    var pedobear = document.getElementById('pedobear');
    var photo = new Image();
    
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices.getUserMedia({
            video: true 
        }).then(function(stream) {
            video.srcObject = stream;
            video.play();
        });
    }

    document.getElementById('capture').addEventListener('click', function()
    {
        context.drawImage(video, 0, 0, 400, 300);
    })

    classified.addEventListener('click', function()
    {
        context.drawImage(classified, 30, 60, 350, 175);
    })

    oooh.addEventListener('click', function()
    {
        context.drawImage(oooh, 290, 10, 105, 100);
    })

    pedobear.addEventListener('click', function()
    {
        context.drawImage(pedobear, 20, 190, 140, 100);
    })

    save.addEventListener('click', function()
    {
        photo.setAttribute(‘src’, canvas.toDataURL());
        document.getElementById('dataURL').value = canvas.toDataURL();
        console.log(document.getElementById('dataURL').value);
    })
})();
