/*! Javascript settings for erfurt-framework.org
 *
 *  Uses HeadJS to load all necessary core and plugin libraries, using different
 *  site scopes.
 *
 *  @since 1.0
 *  @package OWNET
 *  @subpackage WebsitePublic
 *
 *  @author Michael Haschke, http://48augen.de/
 */

/* scope:global
   include all core & plugin libs which are always necessary ---------------- */
head.js(
            // -- core libraries --
            "http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js",
            // -- plugin libraries --
            "http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js",
            // -- settings and configuration --
            //"./util/js/zettings/global.min.js"
            function()
            {

            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', '{{ site.googleanalytics }}']);
            _gaq.push(['_trackPageview']);

            (function() {
                 var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                 ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                 var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
             })();            }
       );
       
// check document and load dynamically all optional JS
head.ready(function()
{
    // scope: tabbing
    $('.tabcontainer').tabs();
    
});

/*
 * reverse lookup of the markdown source file
 */
function pageIdToGithubPath (id) {
    var regexp = /\/(....).(..).(..).(.+)/;
    var r = regexp.exec(id);
    var gitpath = '/_posts/' + r[1] + '-' + r[2] + '-' + r[3] + '-' + r[4] + '.md';
    return gitpath;
}


