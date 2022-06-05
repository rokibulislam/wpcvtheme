jQuery(document).ready(function($) {
	
	$(document).on( 'click', 'a.attachment-delete', function(e) {
        e.preventDefault();
            
        var self = this,
        
        el = $(e.currentTarget);
        
        let data = {
            'attach_id' : el.data('attachment_id'),
            'nonce' : checkout_admin_custom_upload.nonce,
            'action' : 'file_del'
        };

        jQuery.post( checkout_admin_custom_upload.ajaxurl, data, function() {
            el.parent().parent().remove();
        });

    });
});