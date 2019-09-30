

// itbh comment   new file
function newKattDlg( out_type, load_kits, currency ) {
    console.log('newKattDlg');
    console.log(load_kits);

    render();
    var image = new Image();
    image.id = "pic"
    image.src = renderer.domElement.toDataURL();
    ////console.debug(image.src);
    //var pdf_frame = document.getElementById('pdf-3d-frame');
    //if(pdf_frame.hasChildNodes()) {
    //    pdf_frame.removeChild(pdf_frame.childNodes[0]);
    //}
    //pdf_frame.appendChild(image);
    //
    //var katt_logo = jQuery( '#katt-logo' );

    var katt_logo = new Image();
    katt_logo.id = "pic"
    katt_logo.src = "images/katt-logo.png";


    require(['libs/require/config'], function(){
        require(['pdf/js/test_harness', 'plugins/from_html'], function(){

            //var pdf = new jsPDF('p', 'pt', 'letter');
            //var ta = document.getElementById('three-pdf-frame');
            //pdf.fromHTML(ta.value, 0, 0);
            //pdf.save('test.pdf');

            //ta.onkeyup = function(){
            //    var pdf = new jsPDF('p', 'pt', 'letter');
            //    pdf.fromHTML(ta.value, 0, 0);
            //    harness.setPdf(pdf);
            //}
            //
            //var harness = pdf_test_harness_init(pdf);
            //harness.header.style.left='0';
            //harness.body.style.left='0';

            var doc = new jsPDF('p', 'pt', 'a4', false);

            doc.setDrawColor(0);
            doc.setFillColor(255, 255, 255);
            doc.rect(0, 0, 595.28,  841.89, 'F');

            doc.addImage(jQuery(katt_logo).get(0), 'png', 50, 35, 140, 60, undefined, 'SLOW');

            doc.addImage(image.src, 'png', 75, 120, 450, 251, undefined, 'SLOW');
            doc.rect(74, 119, 452,  253, 'S');

            doc.setFontSize(20);
            doc.text(75, 430, 'Katt-Tree Componemts');

            doc.setFontSize(12);
            //doc.text(75, 480, 'Name: ');
            //doc.text(195, 480, 'Count');
            //doc.text(300, 480, 'Price');

            doc.text(75, 460, 'Image');
            doc.text(150, 460, 'Name');
            doc.text(275, 460, 'SKU');
            doc.text(400, 460, 'Quantity');
            if( currency == 'cad' )
                doc.text(470, 460, 'Price(CAD)');
            else
                doc.text(470, 460, 'Price(USD)');

            doc.line(75, 470, 530, 470);

            var i = 0;
            var y_start = 510;
            var y_space = 40;
            var prevpage_last_index=0;
            var y_pos;
            var price = 0;

            for( var i=0; i<load_kits.length; i++ ){
                if( y_start+i*y_space > 800 ){
                    prevpage_last_index = i-1;
                    doc.addPage();
                    doc.addImage(jQuery(katt_logo).get(0), 'png', 50, 35, 140, 60, undefined, 'SLOW');

                    doc.text(75, 140, 'Image');
                    doc.text(150, 140, 'Name');
                    doc.text(325, 140, 'SKU');
                    doc.text(420, 140, 'Quantity');
                    doc.text(490, 140, 'Price');

                    doc.line(75, 150, 530, 150);

                    y_start = 150;
                }
                y_pos = y_start+(i-prevpage_last_index)*y_space;

                var katt_img = new Image();
                katt_img.id = "pic"
                katt_img.src = load_kits[i].image;

                if( load_kits[i].image != '' )
                    doc.addImage(jQuery(katt_img).get(0), 'png', 75, y_pos-y_space+20, y_space-5, y_space-5, undefined, 'SLOW');

                var name = load_kits[i].name;
                if( name.length > 22 ){
                    var str_arr = load_kits[i].name.split(' ');
                    var count = 0;
                    var str1 = '';
                    var str2 = '';
                    for(var j=0; j<str_arr.length; j++ ){
                        count += str_arr[j].length;
                        if( count > 22 ){
                            var str2 = str_arr.slice(j).join(' ');
                            break;
                        }
                        str1 += str_arr[j] + ' ';
                    }
                    doc.text(150, y_pos, str1);
                    doc.text(150, y_pos+20, str2);
                } else {
                    doc.text(150, y_pos, load_kits[i].name);
                }

                doc.text(325, y_pos, load_kits[i].sku);
                doc.text(420, y_pos, load_kits[i].quantity);
                doc.text(490, y_pos, load_kits[i].price.toString());

                price += parseInt(load_kits[i].price);
            }

            var end_ypos = y_pos+y_space-10;
            doc.line(75, end_ypos, 530, end_ypos);

            doc.setFontSize(16);
            doc.setFontType("bold");
            doc.text(370, end_ypos+40, 'Total Price:');

            doc.setFontSize(20);
            doc.text(475, end_ypos+40, price.toString());
            doc.text(510, end_ypos+40, '$');

            doc.setFontSize(12);
            doc.setFontType("regular");
            doc.text(355, end_ypos+60, '*Prices are subject to change without notice.');

            if( out_type == 'pdf' ){
                window.open(doc.output('datauristring'));
            } else if( out_type == 'print' ){
                doc.autoPrint();
                window.open(doc.output('bloburl'), '_blank');
            }
            //doc.save('test.pdf');

        }); //require
    }); //require
}
// itbh comment   new file
function printKattDlg() {
    alert('save file');
}