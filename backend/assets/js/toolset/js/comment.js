var selection;
var sel_text = '';
var is_commentopen = false;
var current_comment = '';
var current_note;
var modal;
var pos = {left:0, top:0};
var comment_load = true;

window.addEventListener('load',function(){
    rangy.init();
    highlighter = rangy.createHighlighter();
    highlighter.addClassApplier(rangy.createClassApplier("highlight", {
        ignoreWhiteSpace: true,
        tagNames: ["span", "a"]
    }));
    highlighter.addClassApplier(rangy.createClassApplier("note", {
        ignoreWhiteSpace: true,
        elementTagName: "a",
        elementProperties: {
            onmouseup: function(e) {

                e.preventDefault();
                is_commentopen = true;
                current_note = $(this);
                current_note = current_note[0];
                selection = rangy.getSelection();
                $('#old_selected_text').text($(this).text());
                $('#modal_text').val($(this).attr('data-comment'));
                var pos_x = e.clientX;
                var pos_y = e.clientY;
                pos = getModalPos( pos_x, pos_y );
                openModal();
            }
        },
        elementAttributes: {
            'data-comment':''
        }
    }));
    var serializedHighlights = localStorage.getItem('kbjComment_' + login_username);
    console.log('comment ' + login_username);
    displayPage(0);
    modal = document.getElementById('comment_modal');
    $('.dialog_text').mouseup(function(e){

        if(cur_language=='_cn') return;
        if( is_commentopen == true ) return;
        var pos_x = e.clientX;
        var pos_y = e.clientY;

        pos = getModalPos( pos_x, pos_y );

        openModal();
        //noteSelectedText();
    });
    var close = document.getElementById("comment_close");
    close.onclick = function() {
        modal.style.display = "none";
        saveComment();
        is_commentopen = false;
    }
});
function displayPage(i){
    var pages = $('.page');
    if( i >= pages.length )
        return;
    $('.page').hide();
    $(pages[i]).show();
    displayBackVideo();
    soundIconLoacte();

    if( comment_load ==true ){
        if ( current_mode == 'comment' && typeof(Storage) !== "undefined") {
            var serializedHighlights = localStorage.getItem('kbjComment_' + login_username);
            if (serializedHighlights != undefined && serializedHighlights != null) {
                highlighter.deserialize(serializedHighlights);
            }
        }
    }
}
function openModal(){
    var d_id = $(this).attr('id');
    if( current_mode == 'comment' ){
        if( is_commentopen == false ){
            if( !isValidationSelect())
                return;
            sel_text = snapSelectionToWord();
            $('#old_selected_text').text(sel_text);
            $('#modal_text').val('');
        }
        var commentModalW = ($('#comment_modal .modal-content').width())/2;
        var commentModalH =  $('.modal-body').height();

        var curPageW = $('#page_'+current_page).width();
        var curPageH = $('#page_'+current_page).height();

        if(curPageW<(pos.left+commentModalW))
        {
            pos.left = curPageW-50-commentModalW;
        }else{
            pos.left = pos.left - commentModalW;
        }
        if(curPageH<(pos.top+200))
        {
            pos.top = pos.top - 300;

        }else{
            pos.top = pos.top +20;
        }
        modal.style.display = "block";
        $('#comment_modal').css({left: pos.left+'px', top: pos.top+'px'});
    }
}
function isValidationSelect(){
    var sel = rangy.getSelection();
    var sel_string = sel.toString();
    if( sel_string == '')
        return false;

    return true;
}

function snapSelectionToWord() {
    selection = rangy.getSelection();
    selection.expand("word");
    noteSelectedText();
    return selection.toString();
}
function getModalPos( pos_x, pos_y ){

    return {left:pos_x, top:pos_y};
    //return {left:left, top:top}
}
function saveComment(){
    current_comment = $('#modal_text').val();
    var node = current_note;
    $(node).attr('data-comment', current_comment);

    if( sel_text == '' || current_comment == '' ){
        if( is_commentopen == true && sel_text == '' && current_comment != '' ){
            console.log('skip');
        } else {
            var sel = localStorage.getItem('kbjSelection');
            highlighter.unhighlightSelection(selection);
            return;
        }
    }
    if (typeof(Storage) !== "undefined") {
        localStorage.setItem('kbjComment_' + login_username, highlighter.serialize());
    } else {
        // Sorry! No Web Storage support..
    }
}

function noteSelectedText() {
    highlighter.highlightSelection("note");
    current_note = selection.getRangeAt(0).getNodes([1], function(el) {
        return el.tagName == "A" && el.className == "note";
    });
    current_note = current_note[0];
}