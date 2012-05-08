/* ----------------  end of document ready function  --------------------------*/
function assignSoloFeedback(meta) {	
    $('.soloFeedbackText').html(meta.text);	
    $('.soloFeedbackText').jScrollPane();
    $('.soloFeedbackAvatar').find('img').attr('src',meta.avatar);
    $('.soloFeedbackAuthorName').html(meta.name);
    $('.soloFeedbackAuthorCompany').html(meta.company);
    $('.soloFeedbackAuthorLocation').html(meta.location);
    $('.soloFeedbackDate').html(meta.date);
    $('.soloFeedbackAuthor').find('.flag').removeClass().addClass("flag flag-" + meta.flag);
}	
