(function() {
    tinymce.create('tinymce.plugins.ikshortcodes', {
        init : function(ed, url) {
              
 
        },
        createControl : function(n, cm) {
            if(n=="ikshortcodes"){
            var mlb = cm.createListBox('ikshortcodeslist', {
                     title : 'Shortcodes',
                     onselect : function(v) { //Option value as parameter
                        if(tinyMCE.activeEditor.selection.getContent() !== ''){
                            tinyMCE.activeEditor.selection.setContent('[' + v + ']' + tinyMCE.activeEditor.selection.getContent() + '[/' + v + ']');
                        }
                        else{
                            tinyMCE.activeEditor.selection.setContent('[' + v + ']');
                        }
                     }
                });
			mlb.add('Column', 'column');
			mlb.add('Clear', 'clear');
			mlb.add('Horizontal line', 'hline');
			mlb.add('Tab Group', 'tabs');
			mlb.add('Tab', 'tab');
            mlb.add('Vimeo', 'vimeo');
            mlb.add('Youtube', 'youtube');
			
            
            return mlb
            }
        }
    });
    tinymce.PluginManager.add('ikshortcodes', tinymce.plugins.ikshortcodes);
})();