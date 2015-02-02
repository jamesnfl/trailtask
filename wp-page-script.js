var pageid = 0;

jQuery(document).ready(function(){
    if(jQuery('#page_id').size()==0){
        jQuery('#page_ids').append('<select id="page_id" name="page_id"><option value="">(No Parent)</option></select>');
    }
    

    
    jQuery('#wp-page-name, #page_ids').keypress(function(event){
        if(event.which==13){
            if(jQuery('#wp-page-name').val()!=''){
                sc_add_page();
            }
        }
    });
    
    //get the draft pages
    var valDrafts = jQuery('#pagesDraft').val();
    if(valDrafts && valDrafts!=''){
        if(valDrafts.match(',')){
            //its an array
            var arrDrafts = valDrafts.split(",");
            for(idraft=0;idraft<arrDrafts.length;idraft++){
                if(jQuery('ul.np_pages li.page-item-' + arrDrafts[idraft]).children('ul').size()>0){
                   jQuery('ul.np_pages li.page-item-' + arrDrafts[idraft]).children('ul').before(' - <b style="font-size:12px;color:red;">draft</b>'); 
                }else{
                    jQuery('ul.np_pages li.page-item-' + arrDrafts[idraft]).append(' - <b style="font-size:12px;color:red;">draft</b>');   
                }
            }
        }else{
            if(jQuery('ul.np_pages li.page-item-' + valDrafts).children('ul').size()>0){
                jQuery('ul.np_pages li.page-item-' + valDrafts).children('ul').before(' - <b style="font-size:12px;color:red;">draft</b>'); 
            }else{
                jQuery('ul.np_pages li.page-item-' + valDrafts).append(' - <b style="font-size:12px;color:red;">draft</b>');   
            }
        }
    }

    jQuery('form#wp-add-pages').on('submit', function(e){
        return jQuery('#wp-page-name').val().length>0 ? sc_add_page() : true;
    });
});

function sc_add_page(){
    //wp-page-name
    //page_id
    var chkfrm = '';
    if(jQuery('#wp-page-name').val()=='') chkfrm += 'Please enter a page name\n';
    
    if(chkfrm==''){
        
        var parent = jQuery('#page_id').val();
        var template = jQuery('#page_template').val();
        var template_text = jQuery('#page_template option[value="'+ template +'"]').text();
        if(!template) template = '';
        if(!template_text) template_text = '';
        
        if(parent==''){
            parent = -1;
            jQuery('ul.np_pages').append('<li class="page-item-new' + pageid + '">' + jQuery('#wp-page-name').val() + (template!='' ? ' (' + template_text + ')' : '') + ' <a href="JavaScript:sc_del_page(' + pageid + ');">Remove</a></li>');
            jQuery('#page_id').append('<option value="new' + pageid + '">' + jQuery('#wp-page-name').val() + '</option>');
        }else{
            var parentname = jQuery('#page_id option[value=' + parent + ']').html();
            var parentspace = '&nbsp;&nbsp;&nbsp;';
            if(parentname.match(/&nbsp;/g)){
                var nums = parentname.match(/&nbsp;/g).length;
                for(inums=0;inums<nums;inums++){
                    parentspace += '&nbsp;';
                }
            }
            jQuery('li.page-item-' + parent).append('<li class="page-item-new' + pageid + '">' + jQuery('#wp-page-name').val() + (template!='' ? ' (' + template_text + ')' : '') + ' <a href="JavaScript:sc_del_page(' + pageid + ');">Remove</a></li>');
            jQuery('#page_id option[value=' + parent + ']').after('<option class="p_' + parent + '" value="new' + pageid + '">' + parentspace + jQuery('#wp-page-name').val() + '</option>');
        }
        jQuery('#np_pages').val(jQuery('#np_pages').val() + pageid + '|' + parent + '|' + jQuery('#wp-page-name').val() + '|' + template + '\n');
                
        //reset the form
        pageid++;
        jQuery('#wp-page-name').val('');
        jQuery('#page_id').attr('selectedIndex', 0);
    }else{
        alert(chkfrm);
    }
}
