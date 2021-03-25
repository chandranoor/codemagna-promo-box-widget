var custom_uploader;

function codemagna_widget_promo_box_upload_image_button(obj){

        var parent_form = jQuery(obj).parentsUntil(".widget-inside");

        // Get parent ID
        var image_target_id = parent_form.find('input.codemagna_widget_promo_box_image_url').attr("id");

        // Get image URL from ID
        var image_url = jQuery('#' + image_target_id);
        
        // Get ID image preview
        var image_preview = jQuery('#' + image_target_id + '_preview');

        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {

            custom_uploader.close()

        }
        
        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({

            title: 'Choose Image',
            
            button: {
                text: 'Choose Image'
            },
            
            multiple: false
        });
        
        //Open the uploader dialog
        custom_uploader.open();
        
        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            
            var submit_button = parent_form.find(".widget-control-save");
            
            image_url.val( attachment.url );
            
            image_preview.attr("src", attachment.url );
            
            submit_button.prop('disabled',false);               
        });
}

jQuery(document).ready(function($){

    "use strict";

    $('.widget').on('click', '.codemagna_widget_promo_box_upload_image_button', function (e) {
        codemagna_widget_promo_box_upload_image_button(this)
    })

})



// OneTrick's
// https://wordpress.stackexchange.com/a/37707
jQuery( document ).ajaxComplete( function( event, XMLHttpRequest, ajaxOptions ) {
    var request = {}, pairs = ajaxOptions.data.split('&'), i, split, widget;
    for( i in pairs ) {
        split = pairs[i].split( '=' );
        request[decodeURIComponent( split[0] )] = decodeURIComponent( split[1] );
    }

    if( request.action && ( request.action === 'save-widget' ) ) {
        widget = jQuery('input.widget-id[value="' + request['widget-id'] + '"]').parents('.widget');
        if( !XMLHttpRequest.responseText ) {
            wpWidgets.save(widget, 0, 1, 0);
        }
        else{
            jQuery('.widget').on('click', '.codemagna_widget_promo_box_upload_image_button', function (e) {
                codemagna_widget_promo_box_upload_image_button(this)
            })
        }
            
    }
});