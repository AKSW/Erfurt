/*
 * fetch font information from google web fonts
 */
google.setOnLoadCallback(function() {
    WebFont.load({
        google: {
                    families: [ 'Ubuntu', 'Inconsolata', 'Rock+Salt' ]
                }});
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

/*
 * Here be dragons
 */
$(document).ready(function() {

});

