$(document).ready(function() {

  var markdownize = function(content) {
    var html = content.split("\n").map($.trim).filter(function(line) { 
      return line != "";
    }).join("\n");
    return toMarkdown(html);
  };

  var converter = new Showdown.converter();
  var htmlize = function(content) {
    return converter.makeHtml(content);
  };

  // Method that converts the HTML contents to Markdown
  var showSource = function(content) {
    var markdown = markdownize(content);
    if ($('#feedbackText').get(0).value == markdown) {
      return;
    }
    $('#feedbackText').get(0).value = markdown;
  };


  var updateHtml = function(content) {
    if (markdownize($('#review-feedback-text').html()) == content) {
      return;
    }
    var html = htmlize(content);
    $('#review-feedback-text').html(html);
  };

  // Update Markdown every time content is modified
  $('#review-feedback-text').bind('hallomodified', function(event, data) {
    showSource(data.content);
  });
  $('#feedbackText').bind('keyup', function() {
    updateHtml(this.value);
  });
  showSource($('#review-feedback-text').html());
}); 