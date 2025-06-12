jQuery(function(){

    const toggleSidenavBtn = jQuery("button[data-toggle=sidenav]");
    
    if(_.isEmpty(toggleSidenavBtn)){
        return;
    }

    toggleSidenavBtn.on('click', function(){
        jQuery("aside.sidenav").toggleClass('show');
    })

    jQuery(document).on("click", "aside.sidenav", function(event){
        if(jQuery(event.target).hasClass('sidenav')){
            jQuery("aside.sidenav").toggleClass('show');
        }
    })
})