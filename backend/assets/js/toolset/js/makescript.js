var character_pages = 0;
var cur_character_page = 0;
var cur_edit_elem;

window.addEventListener('load',function(){
    generateCharacters();

    if(login_status=="1")
    {
        $('.save-wrap').show();
    }


});
function save_script()
{
    var filename = 'Tomorrow' + Math.round(new Date().getTime()) + courseware_id;
    $('#dbfilename').val( filename );
    $('#dbscriptModal').show();
}
function generateCharacters(){

    var elem = '';

    for( var i=0; i<characters.length; i++ ){
        if( characters.length>3 && (i%3 == 0) ){
            character_pages++;
            elem += '<div class="characters-page" style="display: none">';
        }

        var elem = elem + '<div class="character-elem" data-name="' + characters[i].name + '"><img src="' + characters[i].img + '"></div>';

        if( characters.length>3 && (i%3 == 2) ){
            elem += '</div>';
        }
    }

    var chrarcterImg = $( elem );
    $('#characters').append(chrarcterImg);


    $('.characters-page').hide();
    var pages = $('.characters-page');
    $(pages[cur_character_page]).show();

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

    $('#script_save_btn').click(function () {
        var filename = $('#dbfilename').val();
        var title = $('#script_name').val();
        var content = $('#content_wrap').html();
        ajax_url = base_url + 'contents/upload';
        script_text = {
            coursewareId: courseware_id,
            new_filename:filename,
            type: 'script',
            title: title,
            content: content
        };
        $.ajax({
            type:'post',
            url:ajax_url,
            dataType: "json",
            data:script_text,
            success:function(res){
                if(res.status=='success'){
                    $('#dbscriptModal').hide();
                }else{
                    $('#dbscriptModal').hide();
                    alert('无法保存脚本文件!');
                }
            }
        });
    });
    $('#script_save_btn').mouseenter(function () {
        $(this).find('img').attr('src', 'images/yes-btn-hover.png')
    });
    $('#script_save_btn').mouseleave(function () {
        $(this).find('img').attr('src', 'images/yes-btn.png')
    });
    $('#script_save_close_btn').click(function () {
        $('#dbscriptModal').hide();
    });
    $('#script_save_close_btn').mouseenter(function () {
        $(this).find('img').attr('src', 'images/no-btn-hover.png')
    });
    $('#script_save_close_btn').mouseleave(function () {
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

        var textarea;
        var elem_txt;
        var name = $(this).data('name');

        // var cursorPos = $('#script_content').prop('selectionStart');
        // var v = $('#script_content').val();
        // var textBefore = v.substring(0, cursorPos);
        // var textAfter  = v.substring(cursorPos, v.length);

        var content_elem = $('<div class="content-elem" onclick="clickElem(this)"></div>');
        var img_path = 'images/characters/'+name+'.png';
        var elem_img = $('<div class="elem-img" onmouseenter="mouseenterElemImg(this)" onmouseleave="mouseleveElemImg(this)"><img src="'+img_path+'"></div>');
        elem_txt = $('<div class="elem-txt" style="font-family: \'Comic Sans MS\';" onclick="clickElemText(this)"></div>');
        textarea = $('<textarea rows="5" style="display: inline-block; width: 85%;font-family: \'Comic Sans MS\';" onblur="leaveText(this)"></textarea>')
            .css({
                'border-radius': '5px',
                border: '2px solid #e9e6cf',
                'background-color': '#f8f8f1',
                'margin-left': '15px'
            });

        var div_clear = $('<div class="clearfix"></div>');
        content_elem.append(elem_img).append(elem_txt).append(textarea).append(div_clear);

        var script = $('<script>' +

            +'</script>');

        cur_edit_elem.after(content_elem).after(script);
        cur_edit_elem = content_elem;
        textarea.focus();
        // $('#script_content').val(textBefore + name.toUpperCase() + ': ' + textAfter);
    })

    $('.content-elem').click( function () {
        clickElem(this);
    } );

    $('.elem-txt').click( function () {
        clickElemText(this);
    } );

    $('.elem-img').mouseenter( function () {
        mouseenterElemImg(this);
    })

    $('.elem-img').mouseleave( function () {
        mouseleveElemImg(this);
    });
}

function clickElem( elem ){
    var text = $(elem).find('.elem-txt').text();
    var text1 = $(elem).find('textarea').val();
    if( text == '' && text1 == undefined  ){
        clickElemText($(elem).find('.elem-txt'));
    }
}

function mouseenterElemImg( elem ) {
    var close_btn = $('<div class="elem-close-btn" onclick="deleteElem(this);"></div>')
        .css({
            position: 'absolute',
            width: '100%',
            height: '100%',
            left: '0',
            top: '0'
        });
    var close_img = $('<img src="images/characters/close-btn.png">')
        .css({
            width: '100%',
            height: '100%'
        });
    close_btn.append(close_img);
    $(elem).append(close_btn);
}

function mouseleveElemImg( elem ){
    $(elem).find('.elem-close-btn').remove();
}

function deleteElem( elem ){
    cur_edit_elem = $(elem).parent().parent().prev();
    $(elem).parent().parent().remove();
}

function clickElemText( elem ){
    var textarea;
    cur_edit_elem = $(elem).parent();
    var text = $(elem).text();
    $(elem).text('');
    var isNarrator = $(elem).attr('isNarrator');
    textarea = $('<textarea rows="5" style="display:inline-block; width: 85%;font-family: \'Comic Sans MS\'" onblur="leaveText(this)">'+text+'</textarea>')
        .css({
            'border-radius': '5px',
            border: '2px solid #e9e6cf',
            'background-color': '#f8f8f1',
            'margin-left': '15px'
        });
    $(elem).after(textarea);
    textarea.focus();
}

function leaveText( elem ){
    if( cur_edit_elem != undefined ){
        var text = cur_edit_elem.find('textarea').val();
        text = text.replace(/(?:\r\n|\r|\n)/g, '<br />\r\n');
        cur_edit_elem.find('.elem-txt').html(text);
        cur_edit_elem.find('textarea').remove();
    }
}
$('#makescript_print').click(function () {

    var print_dom = $('<div class="content-wrap" id="print_dom">')
        .css({
            width:'830px',
            height:'auto',
            overflow:'visible',
            border: 'none',
            background: '#fff',
            top: '2000px'
        });
    var print_elems = $('.content-elem');
    var print_page = $('<div class="print-page" style="height: 1080px; min-height: 1080px"></div>');
    print_dom.append(print_page);
    $('body').append(print_dom);
    var h = 0;
    for( var i=0; i<print_elems.length; i++ ){
        var append_dom = print_elems[i];

        console.log( h );
        console.log( $(append_dom).outerHeight() );
        if( h + $(append_dom).outerHeight() >= 1080 ){
            print_page = $('<div class="print-page" style="height: 1080px; min-height: 1080px;"></div>');
            print_dom.append(print_page);
            h=0;

        }

        print_page.append(append_dom);
        h += $(append_dom).outerHeight();
    }


    makePDF();
});


function makePDF(){
    var quotes = document.getElementById('print_dom');


    html2canvas(quotes, {
        onrendered: function(canvas) {

            //! MAKE YOUR PDF
            var pdf = new jsPDF('p', 'pt', 'a4');
            // var print_pages = $('.print_page');
            // for (var i=0; i<print_pages.length; i++){}
            for (var i = 0; i <= quotes.clientHeight/1080; i++) {
                //! This is all just html2canvas stuff
                var srcImg  = canvas;
                var sX      = 0;
                var sY      = 1080*i; // start 1080 pixels down for every new page
                var sWidth  = 830;
                var sHeight = 1080;
                var dX      = 0;
                var dY      = 0;
                var dWidth  = 830;
                var dHeight = 1080;

                window.onePageCanvas = document.createElement("canvas");
                onePageCanvas.setAttribute('width', 830);
                onePageCanvas.setAttribute('height', 1080);
                var ctx = onePageCanvas.getContext('2d');
                // details on this usage of this function:
                // https://developer.mozilla.org/en-US/docs/Web/API/Canvas_API/Tutorial/Using_images#Slicing
                ctx.drawImage(srcImg,sX,sY,sWidth,sHeight,dX,dY,dWidth,dHeight);

                // document.body.appendChild(canvas);
                var canvasDataURL = onePageCanvas.toDataURL("image/png", 1.0);

                var width         = onePageCanvas.width;
                var height        = onePageCanvas.clientHeight;

                //! If we're on anything other than the first page,
                // add another page
                if (i > 0) {
                    pdf.addPage(612, 865); //8.5" x 11" in pts (in*72)
                }
                //! now we declare that we're working on that page
                pdf.setPage(i+1);
                //! now we add content to that page!
                pdf.addImage(canvasDataURL, 'PNG', 40, 80, (width*.62), (height*.62));

            }

            // $("#content_wrap").css({overflow: 'hidden',width:'49.37%', height:'69.06%'});
            var print_elems = $('.content-elem');
            $('#content_wrap').append(print_elems);
            $('#print_dom').remove();

            //! after the for loop is finished running, we save the pdf.
            pdf.save('Test.pdf');
            pdf.autoPrint();
        }
    });
}

