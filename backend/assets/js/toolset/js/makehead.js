var character_pages = 0;
var cur_character_page = 0;
var cur_character = '';
var canvas;
var canvas1;
var ctx;
var drawing = false;
var drawingMode = "add";
var pencilMode = "pencil";
var pencilWidth;
var fillColor;
var curColor;
var posX, posY;
var cPushArray = new Array();
var cStep = -1;

var canvas_w = 0;
var canvas_h = 0;

// Bucket Tool
var outlineLayerData;
var colorLayerData;

var moveEvent = 'mousemove';
var mouseUpEvent = 'mouseup';
var mouseDownEvent = 'mousedown';
if(osStatus==='Android'||osStatus==='iOS')
{
    moveEvent = 'touchmove';
    mouseUpEvent = 'touchend';
    mouseDownEvent = 'touchstart';
}

window.addEventListener('resize',function(){

});

window.addEventListener('load',function(){
    canvas_w = $('#sheet').width();
    canvas_h = $('#sheet').height();
    $('#sheet').attr('width', canvas_w);
    $('#sheet').attr('height', canvas_h);
    $('#upper-sheet').attr('width', canvas_w);
    $('#upper-sheet').attr('height', canvas_h);

    generateCharacters();

    canvas = new fabric.Canvas('sheet');
    canvas.isDrawingMode = true;
    canvas.freeDrawingBrush.width = 5;
    canvas.freeDrawingBrush.color = "#ff0000";

    canvas1 = document.getElementById('upper-sheet');

    ctx = canvas1.getContext("2d");

    pencilWidth = 5;
    fillColor = "#ff0000";
    curColor = convertRGBColor(fillColor);
    changeCursor();

    cur_character = $('.character-elem');
    cur_character = $(cur_character[0]).data('name');

    // $('.character-name').text(cur_character);

    fabric.Image.fromURL('images/makehead/panel-bg.png', function(myImg) {
        console.log(myImg.width);

        $('#sheet').attr('width', canvas_w);
        $('#sheet').attr('height', canvas_h);

        var pos_x = (canvas_w-canvas_h*myImg.width/myImg.height)/2;
        var pos_y = 0/2;
        //i create an extra var for to change some image properties
        // var img = myImg.set({ left: pos_x, top: pos_y, width: canvas_h*myImg.width/myImg.height, height: canvas_h});
        var img = myImg.set({ left: 0, top: 0, width: canvas_w, height: canvas_h});
        canvas.add(img);

        // Bucket Tool
        var context = canvas.getContext("2d");
        outlineLayerData = context.getImageData(0, 0, canvas_w, canvas_h);
        var context1 = canvas1.getContext("2d");
        colorLayerData = context1.getImageData(0, 0, canvas_w, canvas_h);
    });

    $('#pagedown').click( function(){
        cur_character_page++;
        if( cur_character_page >= character_pages )
            cur_character_page = character_pages-1;

        $('.characters-page').hide();
        var pages = $('.characters-page');
        $(pages[cur_character_page]).show();
    } );

    $('#pageup').click( function(){
        cur_character_page--;
        if( cur_character_page < 0 )
            cur_character_page = 0;

        $('.characters-page').hide();
        var pages = $('.characters-page');
        $(pages[cur_character_page]).show();
    } );
    $('#head_save_btn').click(function () {
        var filename = $('#dbfilename').val();
        var dataURL = canvas.toDataURL();



        html2canvas($('.content-wrap'), {
            onrendered: function(canvas) {
                // canvas is the final rendered <canvas> element
                var dataURL = canvas.toDataURL("image/png");

                ajax_url = base_url + 'contents/upload';
                data = {
                    coursewareId: courseware_id,
                    type: 'head',
                    /*title: cur_character,*/
                    title:filename,
                    new_filename:filename,
                    imgBase64: dataURL
                };
                $.post(
                    ajax_url,
                    data,
                    function( data, status ){
                        if( status == 'success' && typeof(data) != 'undefined' ){
                            $('#dbheadModal').hide();
                        }else{
                            $('#dbheadModal').hide();
                            alert('无法保存脚本文件!');
                        }
                    }
                );
            }
        });
    });
    $('#head_save_btn').mouseenter(function () {
        $(this).find('img').attr('src', 'images/yes-btn-hover.png')
    });
    $('#head_save_btn').mouseleave(function () {
        $(this).find('img').attr('src', 'images/yes-btn.png')
    });
    $('#head_save_close_btn').click(function () {
        $('#dbheadModal').hide();
    });
    $('#head_save_close_btn').mouseenter(function () {
        $(this).find('img').attr('src', 'images/no-btn-hover.png')
    });
    $('#head_save_close_btn').mouseleave(function () {
        $(this).find('img').attr('src', 'images/no-btn.png')
    });

    $('#dbfilename').keyup(function(){

        if($(this).val()=='')
        {
            $(this).css({"border-color": "#f00",
                "border-width":"1px",
                "border-style":"solid"});
        }else
        {
            $(this).css({"border-color": "#ccc",
                "border-width":"1px",
                "border-style":"solid"});
        }
    });
    $('.character-elem').click(function(){
        cur_character = $(this).data('name');
        $('.character-name').text(cur_character);
///////////////////////////////////////////////////////////////////
        canvas.clear();
        ctx.clearRect(0, 0, canvas1.width, canvas1.height);
///////////////////////////////////////////////////////////////////
        fabric.Image.fromURL('images/characters/' + cur_character + '-bk.png', function(myImg) {
            var pos_x = (canvas_w-canvas_h*myImg.width/myImg.height)/2;
            var pos_y = 0/2;
            //i create an extra var for to change some image properties
            var img = myImg.set({ left: pos_x, top: pos_y, width: canvas_h*myImg.width/myImg.height, height: canvas_h});
            canvas.add(img);
            // Bucket Tool
            var context = canvas.getContext("2d");
            outlineLayerData = context.getImageData(0, 0, canvas_w, canvas_h);
            var context1 = canvas1.getContext("2d");
            colorLayerData = context1.getImageData(0, 0, canvas_w, canvas_h);
        });

    });

    $('#color_f54040').click(function(){
        fillColor = "#f54040";
        curColor = convertRGBColor(fillColor);
        drawingMode = "add";
        changeCursor();
    });
    $('#color_f5d540').click(function(){
        fillColor = "#f5d540";
        curColor = convertRGBColor(fillColor);
        drawingMode = "add";
        changeCursor();
    });
    $('#color_62f540').click(function(){
        fillColor = "#62f540";
        curColor = convertRGBColor(fillColor);
        drawingMode = "add";
        changeCursor();
    });
    $('#color_40eff5').click(function(){
        fillColor = "#40eff5";
        curColor = convertRGBColor(fillColor);
        drawingMode = "add";
        changeCursor();
    });
    $('#color_405ef5').click(function(){
        fillColor = "#405ef5";
        curColor = convertRGBColor(fillColor);
        drawingMode = "add";
        changeCursor();
    });
    $('#color_de40f5').click(function(){
        fillColor = "#de40f5";
        curColor = convertRGBColor(fillColor);
        drawingMode = "add";
        changeCursor();
    });
    $('#color_405ef4').click(function(){
        fillColor = "#405ef4";
        drawingMode = "add";
        changeCursor();
    });
    $('#color_000000').click(function(){
        fillColor = "#000000";
        curColor = convertRGBColor(fillColor);
        drawingMode = "add";
        changeCursor();
    });
    $('#color_fffffc').click(function(){
        fillColor = "#fffffc";
        curColor = convertRGBColor(fillColor);
        drawingMode = "add";
        changeCursor();
    });
    $('#pencil_light').click(function(){
        $('#upper-sheet').css({'cursor':'url(./images/makehead/pencil-light-cursor.cur),auto'});
        $('#pencil_back').find('img').attr('src', 'images/makehead/back.png');
        $('#pencil_erase').find('img').attr('src', 'images/makehead/erase.png');
        $('#pencil_bucket').find('img').attr('src', 'images/makehead/bucket.png');
        pencilWidth = 5;
        drawingMode = "add";
        pencilMode = "pencil";
    });
    $('#pencil_middle').click(function(){
        $('#upper-sheet').css({'cursor':'url(./images/makehead/pencil-middle-cursor.cur),auto'});
        $('#pencil_back').find('img').attr('src', 'images/makehead/back.png');
        $('#pencil_erase').find('img').attr('src', 'images/makehead/erase.png');
        $('#pencil_bucket').find('img').attr('src', 'images/makehead/bucket.png');
        pencilWidth = 10;
        drawingMode = "add";
        pencilMode = "pencil";
    });
    $('#pencil_weight').click(function(){
        $('#upper-sheet').css({'cursor':'url(./images/makehead/pencil-weight-cursor.cur),auto'});
        $('#pencil_back').find('img').attr('src', 'images/makehead/back.png');
        $('#pencil_erase').find('img').attr('src', 'images/makehead/erase.png');
        $('#pencil_bucket').find('img').attr('src', 'images/makehead/bucket.png');
        pencilWidth = 15;
        drawingMode = "add";
        pencilMode = "pencil";
    });
    $('#pencil_erase').click(function(){
        $('#upper-sheet').css({'cursor':'url(./images/makehead/eraser-cursor.cur),auto'});
        $('#pencil_back').find('img').attr('src', 'images/makehead/back.png');
        $('#pencil_erase').find('img').attr('src', 'images/makehead/erase_hover.png');
        $('#pencil_bucket').find('img').attr('src', 'images/makehead/bucket.png');
        // pencilWidth = 25;
        drawingMode = "delete";
        pencilMode = "pencil";
    });
    $('#pencil_bucket').click(function(){
        $('#upper-sheet').css({'cursor':'url(./images/makehead/bucket.cur),auto'});
        $('#pencil_back').find('img').attr('src', 'images/makehead/back.png');
        $('#pencil_erase').find('img').attr('src', 'images/makehead/erase.png');
        $('#pencil_bucket').find('img').attr('src', 'images/makehead/bucket_hover.png');
        drawingMode = "add";
        pencilMode = "bucket";
    });
    $('#pencil_back').click(function(){
        $('#pencil_back').find('img').attr('src', 'images/makehead/back_hover.png');
        $('#pencil_erase').find('img').attr('src', 'images/makehead/erase.png');
        $('#pencil_bucket').find('img').attr('src', 'images/makehead/bucket.png');
        cUndo();
    });
    // canvas1.on('mouse:down', function (e) {

    canvas1.addEventListener(mouseDownEvent,function (e) {
        if (drawing) return false;
        drawing = true;
        var mouse = getMouseCoordinate.call(this, e);

        ctx.globalCompositeOperation = drawingMode === "add" ? "source-over" : "destination-out";
        ctx.fillStyle = drawingMode === "add" ? fillColor : "rgba(0,0,0,1)";
        ctx.strokeStyle = ctx.fillStyle;

        ctx.beginPath();
        if( drawingMode === "add" ){
            if( pencilMode == "pencil" ){
                ctx.arc(mouse.x, mouse.y, pencilWidth/2, 0, 2*Math.PI, true);
            } else {
                var pixelPos = Math.floor(mouse.y * canvas_w + mouse.x) * 4,
                    r = colorLayerData.data[pixelPos],
                    g = colorLayerData.data[pixelPos + 1],
                    b = colorLayerData.data[pixelPos + 2],
                    a = colorLayerData.data[pixelPos + 3];
                floodFill( Math.floor(mouse.x), Math.floor(mouse.y), r, g, b );
                ctx.putImageData(colorLayerData,0,0);
                colorLayerData = ctx.getImageData(0, 0, canvas_w, canvas_h);
                drawing = false;
            }

        } else {
            ctx.arc(mouse.x, mouse.y, 25/2, 0, 2*Math.PI, true);
        }

        ctx.closePath();
        ctx.fill();

        posX = mouse.x; posY = mouse.y;
        ctx.moveTo(posX, posY);
        colorLayerData = ctx.getImageData(0, 0, canvas_w, canvas_h);

    });

    canvas1.addEventListener(moveEvent,function (e) {

        if (!drawing) return false;
        if( pencilMode == 'bucket' ) return false;

        var mouse = getMouseCoordinate.call(this, e);
        ctx.beginPath();
        if( drawingMode === "add" )
            ctx.lineWidth = pencilWidth;
        else
            ctx.lineWidth = 25;
        ctx.moveTo(posX, posY);
        ctx.lineTo(mouse.x,mouse.y);
        ctx.closePath();
        ctx.stroke();

        ctx.beginPath();
        if( drawingMode === "add" )
            ctx.arc(mouse.x, mouse.y, pencilWidth/2, 0, 2*Math.PI, true);
        else
            ctx.arc(mouse.x, mouse.y, 25/2, 0, 2*Math.PI, true);
        posX = mouse.x; posY = mouse.y;
        ctx.closePath();
        ctx.fill();
        colorLayerData = ctx.getImageData(0, 0, canvas_w, canvas_h);

    });
    canvas1.addEventListener(mouseUpEvent,function (e) {
        if (!drawing) return false;
        drawing = false;
        cPush();
    });
});

function getMouseCoordinate(evt) {

    if(osStatus==='Android'||osStatus==='iOS')
    {
        if(('changedTouches' in evt)) evt = evt.changedTouches[0];
    }
    return {
        x : evt.pageX - this.offsetParent.offsetLeft,
        y : evt.pageY - this.offsetParent.offsetTop
    };

}
function changeCursor(){
    if( pencilMode == 'bucket' ){
        $('#upper-sheet').css({'cursor':'url(./images/makehead/bucket.cur),auto'});
        return;
    }
    switch (pencilWidth){
        case 5:
            $('#upper-sheet').css({'cursor':'url(./images/makehead/pencil-light-cursor.cur),auto'});
            break;
        case 10:
            $('#upper-sheet').css({'cursor':'url(./images/makehead/pencil-middle-cursor.cur),auto'});
            break;
        case 15:
            $('#upper-sheet').css({'cursor':'url(./images/makehead/pencil-weight-cursor.cur),auto'});
            break;
    }
}
function cPush() {
    cStep++;
    if (cStep < cPushArray.length) { cPushArray.length = cStep; }
    cPushArray.push(document.getElementById('upper-sheet').toDataURL());
}
function cUndo() {
    if (cStep > 0) {
        cStep--;
        var canvasPic = new Image();
        canvasPic.src = cPushArray[cStep];
        canvasPic.onload = function () {
            ctx.clearRect(0, 0, canvas1.width,canvas1.height);
            ctx.globalCompositeOperation = "source-over";
            ctx.drawImage(canvasPic, 0, 0); }
    } else {
        if( cStep < 0 )return;
        cStep--;
        ctx.clearRect(0, 0, canvas1.width,canvas1.height);
    }
}

function cRedo() {
    if (cStep < cPushArray.length-1) {
        cStep++;
        var canvasPic = new Image();
        canvasPic.src = cPushArray[cStep];
        canvasPic.onload = function () { ctx.drawImage(canvasPic, 0, 0); }
    }
}

function generateCharacters(){

    var elem = '';

    for( var i=1; i<characters.length; i++ ){
        if( characters.length>3 && ((i-1)%3 == 0) ){
            character_pages++;
            elem += '<div class="characters-page" style="display: none">';
        }

        var elem = elem + '<div class="character-elem" data-name="' + characters[i].name + '"><img src="' + characters[i].img + '"></div>';

        if( characters.length>3 && ((i-1)%3 == 2) ){
            elem += '</div>';
        }
    }
    var chrarcterImg = $( elem );
    $('#characters').append(chrarcterImg);

    $('.characters-page').hide();
    var pages = $('.characters-page');
    $(pages[cur_character_page]).show();
}

function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function save_head()
{
    var result_canvas = document.getElementById('upper-sheet');
    var spiriteURL = result_canvas.toDataURL("image/png");
    var elem = document.createElement('a');
    elem.href = spiriteURL;
    elem.download = "paintimage.png";
    elem.style.height = "0";
    elem.innerHTML = "Click here to download the file";
    $('body')[0].appendChild(elem);
    elem.click();
    setTimeout(function () {
        $('body')[0].removeChild(elem);
    }, 50);

    return;
    var filename = 'Tomorrow' + Math.round(new Date().getTime()) + courseware_id;
    $('#dbfilename').val(filename);
    $('#dbheadModal').show();
}
$('#makehead_print').click(function () {


    html2canvas($('.content-wrap'), {
        onrendered: function(canvas) {
            // canvas is the final rendered <canvas> element
            var myImage = canvas.toDataURL("image/png");
            // window.open(myImage);
            var doc = new jsPDF('p', 'mm', [280, 260]);
            doc.addImage(myImage, 'PNG', 5,5);
            /*doc.save('head.pdf');*/
            doc.autoPrint();
            window.open(doc.output('bloburl'), '_blank');

        }
    });

});


function floodFill(startX, startY, startR, startG, startB) {

    var newPos,
        x,
        y,
        pixelPos,
        reachLeft,
        reachRight,
        drawingBoundLeft = 0,
        drawingBoundTop = 0,
        drawingBoundRight = 0 + canvas_w - 1,
        drawingBoundBottom = 0 + canvas_h - 1,
        pixelStack = [[startX, startY]];

    console.log('mouse x:'+startX+' mouse Y:'+startY);

    pixelPos = (startY * (canvas_w) + startX) * 4;
    if( matchCurrentColor( pixelPos, startR, startG, startB ) ){
        return;
    }

    while (pixelStack.length) {

        newPos = pixelStack.pop();
        x = newPos[0];
        y = newPos[1];
        // Get current pixel position
        pixelPos = (y * canvas_w + x) * 4;
        var y1 = y, pixelPos1 = pixelPos;
        while (y1 <= drawingBoundBottom && matchStartColor(pixelPos1, startR, startG, startB)) {
            y1 += 1;
            pixelPos1 += canvas_w * 4;
        }
        if( y1>drawingBoundBottom ){
            continue;
        }
        // Go up as long as the color matches and are inside the canvas
        while (y >= drawingBoundTop && matchStartColor(pixelPos, startR, startG, startB)) {
            y -= 1;
            pixelPos -= canvas_w * 4;
        }
        if( y<drawingBoundTop )
            continue;

        pixelPos += canvas_w * 4;
        y += 1;
        reachLeft = false;
        reachRight = false;

        // Go down as long as the color matches and in inside the canvas
        while (y <= drawingBoundBottom && matchStartColor(pixelPos, startR, startG, startB)) {
            y += 1;

            colorPixel(pixelPos, curColor.r, curColor.g, curColor.b);

            if (x > drawingBoundLeft) {
                if (matchStartColor(pixelPos - 4, startR, startG, startB)) {
                    if (!reachLeft) {
                        // Add pixel to stack
                        pixelStack.push([x - 1, y]);
                        reachLeft = true;
                    }
                } else if (reachLeft) {
                    reachLeft = false;
                }
            }

            if (x < drawingBoundRight) {
                if (matchStartColor(pixelPos + 4, startR, startG, startB)) {
                    if (!reachRight) {
                        // Add pixel to stack
                        pixelStack.push([x + 1, y]);
                        reachRight = true;
                    }
                } else if (reachRight) {
                    reachRight = false;
                }
            }

            pixelPos += canvas_w * 4;
        }
    }
}

function matchCurrentColor(pixelPos, startR, startG, startB){
    var r = colorLayerData.data[pixelPos],
        g = colorLayerData.data[pixelPos + 1],
        b = colorLayerData.data[pixelPos + 2];

    if (r === curColor.r && g === curColor.g && b === curColor.b) {
        return true;
    }

    return false;
}

function matchStartColor(pixelPos, startR, startG, startB) {

    var r = outlineLayerData.data[pixelPos],
        g = outlineLayerData.data[pixelPos + 1],
        b = outlineLayerData.data[pixelPos + 2],
        a = outlineLayerData.data[pixelPos + 3];

    // If current pixel of the outline image is black
    if (matchOutlineColor(r, g, b, a)) {
        return false;
    }

    r = colorLayerData.data[pixelPos];
    g = colorLayerData.data[pixelPos + 1];
    b = colorLayerData.data[pixelPos + 2];

    // If the current pixel matches the clicked color
    if (r === startR && g === startG && b === startB) {
        return true;
    }
    // If current pixel matches the new color
    // if (r === curColor.r && g === curColor.g && b === curColor.b) {
    //     return false;
    // }
    return false;
}
function matchOutlineColor(r, g, b, a) {

    return (r<100 && g<100 && b<100 && a > 100);
}
function colorPixel(pixelPos, r, g, b, a) {
    colorLayerData.data[pixelPos] = r;
    colorLayerData.data[pixelPos + 1] = g;
    colorLayerData.data[pixelPos + 2] = b;
    colorLayerData.data[pixelPos + 3] = a !== undefined ? a : 255;
}
function convertRGBColor( hex ){
    var r = hex.substring(1,3);
    var g = hex.substring(3,5);
    var b = hex.substring(5);

    var rgb = {
        r: parseInt(r,16),
        g: parseInt(g,16),
        b: parseInt(b,16)
    };
    return rgb;
}