
window.addEventListener('load',function(){

    var leftBlock = $('.left-block');
    var rightBlock = $('.right-block');

    for( var i=0; i<new_words.words.length; i++ ){
       var dashStr='';
       if(new_words.words[i].word.length!=0&&new_words.words[i].comment!='')
       {
           dashStr='</span> - <span>';
       }
       var wordItem ='<p><span style="font-weight: bold">' + new_words.words[i].word +dashStr+ new_words.words[i].comment + '</span></p>';
       if(i%2==0)
       {
           leftBlock.append(wordItem);
       }else{
           rightBlock.append(wordItem);
       }
    }

    $('#words_close').click(function(){
        hideWords();
    })
});

function showWords(){
    $('.word-wrap').show();
}

function hideWords(){
    $('.word-wrap').hide();
}


