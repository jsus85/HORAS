
/*====================================
 Free To Use For Personal And Commercial Usage
Author: http://binarytheme.com
 Share Us if You Like our work 
 Enjoy Our Codes For Free always.
======================================*/

$(function () {
    

    // Script para Seleccionar los Checkbox 
    $('#selecctall').click(function(event) {  //on click 
                           
            if(this.checked) { // check select status
                $('.checkbox1').each(function() { //loop through each checkbox
                    this.checked = true;  //select all checkboxes with class "checkbox1"               
                });
            }else{
                $('.checkbox1').each(function() { //loop through each checkbox
                    this.checked = false; //deselect all checkboxes with class "checkbox1"                       
                });         
            }
            
     });// ENf function 


    // Script para Seleccionar los Checkbox 
    $('#selecCliente').click(function(event) {  //on click 
                           
            if(this.checked) { // check select status
                $('.checkboxClientes').each(function() { //loop through each checkbox
                    this.checked = true;  //select all checkboxes with class "checkbox1"               
                });
            }else{
                $('.checkboxClientes').each(function() { //loop through each checkbox
                    this.checked = false; //deselect all checkboxes with class "checkbox1"                       
                });         
            }
            
     });// ENf function 


    // Script para Seleccionar los Checkbox 
    $('#selectMantenimiento').click(function(event) {  //on click 
                           
            if(this.checked) { // check select status
                $('.checkboxMantenimiento').each(function() { //loop through each checkbox
                    this.checked = true;  //select all checkboxes with class "checkbox1"               
                });
            }else{
                $('.checkboxMantenimiento').each(function() { //loop through each checkbox
                    this.checked = false; //deselect all checkboxes with class "checkbox1"                       
                });         
            }
            
     });// ENf function 


    // tooltip demo
    $('.tooltip-demo').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    })

    // popover demo
    $("[data-toggle=popover]")
        .popover()
    ///calling side menu

    $('#side-menu').metisMenu();

    ///pace function for showing progress

    function load(time) {
        var x = new XMLHttpRequest()
        x.open('GET', "" + time, true);
        x.send();
    };

    load(20);
    load(100);
    load(500);
    load(2000);
    load(3000);
    setTimeout(function () {
        Pace.ignore(function () {
            load(3100);
        });
    }, 4000);

    Pace.on('hide', function () {
        console.log('done');
    });
    paceOptions = {
        elements: true
    };
   

});

//Loads the correct sidebar on window load, collapses the sidebar on window resize.
$(function() {
    $(window).bind("load resize", function() {
        console.log($(this).width())
        if ($(this).width() < 768) {
            $('div.sidebar-collapse').addClass('collapse')
        } else {
            $('div.sidebar-collapse').removeClass('collapse')
        }
    })
})
