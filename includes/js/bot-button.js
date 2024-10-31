(function() {
    tinymce.create("tinymce.plugins.bot_slider_button", {

        //url argument holds the absolute url of our plugin directory
        init : function(ed, url) {

            //add new button    
            ed.addButton("blue", {
                title : "Rob-Bot Video Slider",
                cmd : "bot_add_slider",
                image : "http://robbotdev.com/wp-content/uploads/2017/04/1491526581_video.png"
            });

            //button functionality.
            ed.addCommand("bot_add_slider", function() {
                var selected_text = ed.selection.getContent();
                var return_text = '[slider width="100%" align="center"][video url="https://examplevideo.com/video"][video url="https://examplevideo.com/video"][/slider]';
                ed.execCommand("mceInsertContent", 0, return_text);
            });

        },

        createControl : function(n, cm) {
            return null;
        },

        getInfo : function() {
            return {
                longname : "Rob-Bot Video Slider",
                author : "Robert Crawford",
                version : "1"
            };
        }
    });

    tinymce.PluginManager.add("bot_slider_button", tinymce.plugins.bot_slider_button);
})();