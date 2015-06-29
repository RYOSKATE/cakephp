<h1>Welcome to Visualize Tool</h1>

<!-- <head>
<script type="text/javascript" src="jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="jquery.ui-1.7.2.custom.min.js"></script>
<script type="text/javascript" src="jquery.stickynotes.js"></script>
<link rel="stylesheet" href="jquery.stickynotes.css" type="text/css">
<script type="text/javascript">
// wait for the DOM to be loaded
$(document).ready(function() {
$('#notes').stickyNotes();
});
</script>
</head>

<div id="notes" style="width:800px;height:600px;"></div> -->
<style>
.sticky {
  width: 250px;
  height: 50px;
  position: absolute;
  cursor: pointer;
  border: 1px solid #aaa;
}
textarea {
  width: 100%;
  height: 100%;
}
.selected {border-color: #f44;}

</style>
<script>
// forked from naga3's "クッキーに保存できる付箋" http://jsdo.it/naga3/iEvs
$(function() {
  $('#new').click(function() {
    make();
    save();
  });

  $('#del').click(function() {
    $('.selected').remove();
    save();
  });

  function make() {
    var sticky = $('<div class="sticky">Drag & Double Click!</div>');
    sticky.appendTo('body')
      .css('background-color', $('#color').val())
      .draggable({stop: save})
      .dblclick(function() {
        $(this).html('<textarea>' + $(this).html() + '</textarea>')
          .children()
          .focus()
          .blur(function() {
            $(this).parent().html($(this).val());
            save();
          });
      }).mousedown(function() {
        $('.sticky').removeClass('selected');
        $(this).addClass('selected');
      });
    return sticky;
  }

  function save() {
    var items = [];
    $('.sticky').each(function() {
      items.push({
        css: {
          left: $(this).css('left'),
          top: $(this).css('top'),
          backgroundColor: $(this).css('background-color')
        },
        html: $(this).html()
      });
    });
    localStorage.sticky = JSON.stringify(items);
  }

  function load() {
    if (!localStorage.sticky) return;
    var items = JSON.parse(localStorage.sticky);
    $.each(items, function(i, item) {
      make().css(item.css).html(item.html);
    });
  }
  load();
});

</script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
<select id="color">
<option value="#C869FF">紫色</option>
<option value="#6BCDFF">水色</option>
<option value="#71FD5E">緑色</option>
<option value="#FECA61">黄色</option>
<option value="#FA6565">赤色</option>
</select>
<input id="new" type="button" value="new">
<input id="del" type="button" value="del">
