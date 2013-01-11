// convert \n to br tags.
function nl2br(s){
    return s.replace(/\n/g,'<br>');
}

// convert br tags to \n.
function br2nl(s){
    return s.replace(/<br ?\/?>/g,'\n');
}

// convert html to entities.
function html2entities(s){
    return s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}

// convert entities to html.
function entities2html(s){
    return s.replace(/&amp;/g,'&').replace(/&lt;/g,'<').replace(/&gt;/g,'>');
}