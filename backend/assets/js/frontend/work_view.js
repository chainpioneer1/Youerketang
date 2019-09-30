/**
 * Created by Administrator on 7/8/2017.
 */
$(window).ready(function(){

    var imageDir = baseURL + "assets/images/frontend/mywork/";
    var shareBtn = $('.share_content_btn');
    var scriptPrintBtn = $('.scriptPrint_Icon');
    var headImgPrintBtn = $('.headImgPrint_Icon');

    shareBtn.mouseover(function(){
        $(this).css({"background":"url("+imageDir+"workshare_hover.png) no-repeat",'background-size' :'100% 100%'});
    });
    shareBtn.mouseout(function(){
        $(this).css({"background":"url("+imageDir+"workshare.png) no-repeat",'background-size' :'100% 100%'});
    });
    scriptPrintBtn.mouseover(function(){
        $(this).css({"background":"url("+imageDir+"scriptprint_hover.png) no-repeat",'background-size' :'100% 100%'});
    });
    scriptPrintBtn.mouseout(function(){
        $(this).css({"background":"url("+imageDir+"scriptprint.png) no-repeat",'background-size' :'100% 100%'});
    });
    headImgPrintBtn.mouseover(function(){
        $(this).css({"background":"url("+imageDir+"headprint_hover.png) no-repeat",'background-size' :'100% 100%'});
    });
    headImgPrintBtn.mouseout(function(){
        $(this).css({"background":"url("+imageDir+"headprint.png) no-repeat",'background-size' :'100% 100%'});
    });
    scriptPrintBtn.click(function () {
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

        // var doc = new jsPDF();
        // doc.addFont('yanhai.ttf', 'HanYiXiJianHeiJian', 'normal', 'Identity-H');
        //
        // //doc.setFont('MsGothic');        // set font
        // doc.setFontSize(20);
        // doc.setTextColor(255,0,0);
        // doc.setCharSpace(1);
        //
        // doc.setDefaultFonts(0, 'Times');    //English default
        // //doc.setDefaultFonts(1, 'MagicR');    //Korean default
        // doc.setDefaultFonts(3, 'HanYiXiJianHeiJian');         //Chinese default
        // // doc.setDefaultFonts(2, 'MsGothic');        //Japanese default
        // var scriptTitle = $('.scriptwork_title').text();
        // if(scriptTitle.length==0)
        // {
        //     alert('????!');
        //     return;
        // }
        // doc.drawText(80,15,scriptTitle);
        // doc.setTextColor(0,0,0);
        // doc.setFontSize(13);
        // var script_content = $('.scriptwork-content');
        // var linesRowCnt  = 3;
        // var onePageHeight = doc.internal.pageSize.height-20;
        // script_content.each(function(){
        //
        //     var lineScript = $(this).text();
        //     var tempScript = lineScript.trim();
        //     if(tempScript.length!=0)
        //     {
        //
        //         console.log(tempScript.length+tempScript);
        //         var pageHeight = linesRowCnt*10;
        //         if(pageHeight>onePageHeight)
        //         {
        //             doc.addPage();
        //             pageHeight = 20;
        //             linesRowCnt =2;
        //         }
        //         doc.drawText(10,pageHeight,tempScript);
        //         linesRowCnt++;
        //     }
        // });
        // doc.autoPrint();
        // window.open(doc.output('bloburl'), '_blank');
    });
    headImgPrintBtn.click(function(){

        html2canvas($("#headImage_wrapper"), {
            onrendered: function(canvas) {
                // canvas is the final rendered <canvas> element
                var myImage = canvas.toDataURL("image/png");
                // window.open(myImage);
                var doc = new jsPDF("l", "pt", "letter");
                doc.addImage(myImage, 'PNG',20,15);
                //doc.save(contentTitle+'.pdf');
                doc.autoPrint();
                window.open(doc.output('bloburl'), '_blank');
            }
        });
    });
    $('.shooting_share_content').mouseover(function(){
        $(this).css({"background":"url("+imageDir+"workshare_hover.png) no-repeat",'background-size' :'100% 100%'});
    });
    $('.shooting_share_content').mouseout(function(){
        $(this).css({"background":"url("+imageDir+"workshare.png) no-repeat",'background-size' :'100% 100%'});
    });
    $('.shooting_share_content').click(function(){
        showCustomModal();
    });

    function shareContent(contentId)
    {
        $.ajax({
            type: "post",
            url: base_url+"work/share_work",
            dataType: "json",
            data: {content_id: contentId},
            success: function(res) {
                if(res.status=='success') {
                    close_modal();
                }
                else//failed
                {
                    alert("Cannot Share Work.");
                }
            }
        });
    }
    shareBtn.click(function(){
        showCustomModal();
    });
    $('#content_share_btn').click(function () {
        var contentId = $(this).attr('content_id');
        shareContent(contentId);
    });
    $('.share_close_btn').click(function(){
        close_modal();
    });
    $('.share_close_btn').mouseover(function(){
        $(this).css({"background":"url("+imageDir+"no_sel.png) no-repeat",'background-size' :'100% 100%'});
    });
    $('.share_close_btn').mouseout(function(){
        $(this).css({"background":"url("+imageDir+"no.png) no-repeat",'background-size' :'100% 100%'});
    });
    $('#content_share_btn').mouseover(function(){
        $(this).css({"background":"url("+imageDir+"yes_sel.png) no-repeat",'background-size' :'100% 100%'});
    });
    $('#content_share_btn').mouseout(function(){
        $(this).css({"background":"url("+imageDir+"yes.png) no-repeat",'background-size' :'100% 100%'});
    });

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