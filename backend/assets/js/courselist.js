var coursePDFImageList = [
    [['27.3%','41.7%','59.8%','76.5%'],['20%','34.4%','47.4%','65.5%','80%'],['13%','31%','47.9%','61.8%','75.8%']],
    [['30.1%','44.5%','65.3%','81.1%'],['14.3%','31%','42.7%','57.2%','76.7%'],['14.8%','29.2%','54.4%','74.3%'],['14.4%','39.4%','68.6%'],['17.1%','36.6%','51.9%']],
    [['26.9%','41.3%','63.7%','81.8%'],['31.5%','46%','71%'],['9.3%','23.7%','48.7%','68.7%','80.3%'],['25.5%','49.2%','64.5%','78.4%'],[]],
    [['27%','41.4%','66.3%'],['9.2%','23.7%','48.7%','69.6%','80.8%'],['28.2%','49.1%','64.5%','79.8%'],['35.2%','54.8%','70.1%','81.7%'],[]],
    [['30%','44.4%','69.5%'],['9.2%','23.7%','48.8%','68.8%','80.4%'],['23.1%','51%','70.4%','82.1%'],['18.7%']],
    [['30%','44.4%','69.5%'],['9.2%','22.4%','46%','66%','79%'],['20%','45.1%','63.1%','78.3%'],['13%']],
    [['27.3%','40.2%','63.8%'],['9.2%','23.6%','48.8%','68.8%','80.4%'],['23%','51%','71.9%'],['11.5%','26.8%']],
    [['27%','38.5%','60.8%','80.8%'],['11.5%','34%','56.6%','68.2%','80.8%'],['28.7%','40.5%','62.9%','82.8%'],['29.6%','54.8%','72.8%'],['10.2%']],
    [['26.8%','38.5%','51.1%','72%'],['9.2%','20.8%','33.4%','55.8%','74.3%'],['11.5%','24%','45%','71.5%'],['13%','28.4%','40.8%']],
    [['27%','38.5%','51.1%','72%'],['9.2%','21%','33.4%','55.7%','75.4%'],['11.5%','24%','44.9%','68.7%','81.9%'],['16%']],
    [['27%','38.5%','51%','71.8%'],['9.2%','20.9%','33.4%','58.4%','80%'],['11.6%','27%','47.9%','68.6%','81.9%'],['15.8%']],
    [['29.8%','41.4%','53.8%','73.2%'],['17.6%','29.3%','41.7%','62.8%','82.8%'],['11.5%','24%','44.9%','64.9%','76.6%'],['10%','31%','50.9%','62.8%','75.3%'],['20%','47.8%','71.3%'],['13%','27%']],
    [['30.6%','43%','55.8%','73.8%'],['18.5%','31.2%','43.7%','64.4%'],['9.2%','21%','33.4%','54.4%','75.2%'],['11.5%','24%','44.9%','68.9%','81.8%'],['24%','38%']]
];
var courseIDList = [1,2,3,4,5,6,7,8,9,10,11,12,13];
var courseNameList = ["aoe教学设计","iuüyw教学设计","bpmf教学设计","dtnl教学设计",
		"gkh教学设计","jqx教学设计","zcs教学设计","zh ch sh r教学设计",
		"ai ei ui教学设计","ao ou iu教学设计","ie üe er教学设计","an en in un ün教学设计","ang eng ing ong教学设计"];
var courseDestId =[
    [['0_1','34_0','0_2','28_0'],['0_3','9_1','9_2','9_3','17_1'],['17_2','17_3','90_0','100_0','27_0']],
    [['0_1','0_2','0_3','9_1'],['9_2','9_3','17_1','17_2','17_3'],['25_1','25_2','25_3','34_1'],['34_2','34_3','46_0'],['90_0','100_0','45_0']],
    [['0_1','0_2','43_0','0_3'],['11_1','11_2','11_3'],['21_1','21_2','21_3','31_1','31_2'],['31_3','90_0','100_0','45_0'],[]],
    [['0_1','0_2','0_3'],['10_1','10_2','10_3','19_1','19_2'],['19_3','28_1','28_2','28_3'],['39_0','90_0','100_0','45_0'],[]],
    [['0_1','0_2','0_3'],['10_1','10_2','10_3','19_1','19_2'],['19_3','30_0','90_0','100_0'],['32_0']],
    [['0_1','0_2','0_3'],['10_1','10_2','10_3','19_1','19_2'],['19_3','30_0','90_0','100_0'],['32_0']],
    [['0_1','0_2','0_3'],['10_1','10_2','10_3','19_1','19_2'],['19_3','30_0','90_0'],['100_0','30_0']],
    [['0_1','0_2','0_3','11_1'],['11_2','11_3','21_1','21_2','21_3'],['31_1','31_2','31_3','43_0'],['30_0','90_0','100_0'],['GameHdGame_0']],
    [['0_1','0_2','0_3','0_4'],['15_1','15_2','15_3','15_4','29_1'],['29_2','29_3','29_4','43_0'],['90_0','100_0','47_0']],
    [['0_1','0_2','0_3','0_4'],['10_1','10_2','10_3','10_4','19_1'],['19_2','19_3','19_4','90_0','100_0'],['30_0']],
    [['0_1','0_2','0_3','0_4'],['11_1','11_2','11_3','11_4','21_1'],['21_2','21_3','30_0','90_0','100_0'],['27_0']],
    [['0_1','0_2','0_3','0_4'],['10_1','10_2','10_3','10_4','19_1'],['19_2','19_3','19_4','28_1','28_2'],['28_3','28_4','37_1','37_2','37_3'],['37_4','30_0','90_0'],['100_0','47_0']],
    [['0_1','0_2','0_3','0_4'],['11_1','11_2','11_3','11_4'],['21_1','21_2','21_3','21_4','31_1'],['31_2','31_3','31_4','30_0','90_0'],['100_0','43-_0']]
];
var index = 0;
var coursePDFImageItem = [];
$('.bg').css({background: 'url(' + baseURL + 'assets/images/resource/education/courselist/bg.png) no-repeat'});
$('.frame').css({background: 'url(' + baseURL + 'assets/images/resource/education/courselist/frame.png) no-repeat'});
$('.frame_download').css({background: 'url(' + baseURL + 'assets/images/resource/education/courselist/download.png) no-repeat'});
$(function () {

    $('#resource-nav-item' + (selectedIndex + 1)).css({background: 'url(' + baseURL + '/assets/images/resource/education/menu' + (selectedIndex + 1) + '_clicked.png)'});

    $('#resource-nav-item' + (selectedIndex + 1)).on('mouseout', function (object) {
        var id = $(this).attr('itemid');
        $(this).css({background: 'url(' + baseURL + '/assets/images/resource/education/menu' + (selectedIndex + 1) + '_clicked.png)'});
    })

    $('#resource-nav-item' + (selectedIndex + 1)).on('mouseover', function (object) {
        var id = $(this).attr('itemid');
        $(this).css({background: 'url(' + baseURL + '/assets/images/resource/education/menu' + (selectedIndex + 1) + '_clicked.png)'});
    })

    index = courseIDList.indexOf(parseInt(lessonItem.id));
    coursePDFImageItem = coursePDFImageList[index];
    var content_html = "";
    for (var i = 0; i < coursePDFImageItem.length; i++) {
        content_html += '<div class="course_list_container" item_id="' + (i + 1) + '"' +
        'style="background:url(' + baseURL + '/uploads/education/pdftoimage/' + lessonItem.id + '/' + lessonItem.id + '-' + (i + 1) + '.jpg);">';
        var subcontent_html = "";
        for (var j = 0 ; j < coursePDFImageItem[i].length ; j++){
            subcontent_html += '<div class="list_item" item_id="' + (j + 1) + '" style="top:' + coursePDFImageItem[i][j] + ';"></div>'
        }
        content_html += subcontent_html;
        content_html += '</div>';
    }
    $('.course_container').html(content_html);

    $('.pdf_embed').attr('src', baseURL + 'uploads/education/pdf/' + lessonItem.id + '.pdf');
    $('.frame_download').attr('href',baseURL + 'uploads/education/pdf/' + lessonItem.id + '.pdf');
    $('.frame_download').attr('download',courseNameList[lessonItem.id-1] + '.pdf');

    $('.frame_download').on('click', function (object) {
        makePDF();
    })
    
    $('.list_item').on('click',function () {
        var parentContainer = $(this).parent();
        var containerItemId = parentContainer.attr("item_id");
        var itemId = $(this).attr("item_id");
        var pId = courseDestId[index][parseInt(containerItemId) - 1][parseInt(itemId) - 1];
        console.log(pId);
        window.open(baseURL + '/uploads/class/kuaile_'+lessonItem.id +'/package/index.html?pId='+pId);
    })
});
