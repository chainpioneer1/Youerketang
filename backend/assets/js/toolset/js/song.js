window.addEventListener('load',function(){
    vplayer = videojs('videoPlayer1',{controls:true,width:1280,height:720,pxpreload:'auto',loop:false},function(){
        vplayer.on('play', function(){
            console.log('play');
        });
        vplayer.on("pause",function(){
            console.log('stop');
        });
    });

    vplayer.src({type:'video/mp4',src:song_video});
    vplayer.play();
});

jQuery('#btn_print').click(function()
{
    var song_title = $('#song_title').html();
    song_title = song_title.replace(/\r?\n|\r/g,"");

    var song_content = $('#song_text').text();
    console.log(typeof (song_content));

    var doc = new jsPDF();
    doc.addFont('yanhai.ttf', 'HanYiXiJianHeiJian', 'normal', 'Identity-H');

    //doc.setFont('MsGothic');        // set font
    doc.setFontSize(20);
    doc.setTextColor(0,0,0);
    doc.setCharSpace(1);


    doc.setDefaultFonts(0, 'Times');    //English default
    //doc.setDefaultFonts(1, 'MagicR');    //Korean default
    doc.setDefaultFonts(3, 'HanYiXiJianHeiJian');         //Chinese default
    // doc.setDefaultFonts(2, 'MsGothic');        //Japanese default

    doc.drawText(80,20,song_title);
    doc.setFontSize(13);

    var song_content_lines = song_content.split('\n');
    for(var i=0;i<song_content_lines.length;i++)
    {
        var linesStr = song_content_lines[i];
        doc.text(10,40+10*i,linesStr);
    }
    doc.autoPrint();
    window.open(doc.output('bloburl'), '_blank');


});
