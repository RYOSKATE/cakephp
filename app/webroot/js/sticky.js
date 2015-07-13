// forked from naga3's "クッキーに保存できる付箋" http://jsdo.it/naga3/iEvs

  function make(item) {
    var sticky = $('<div class="sticky"></div>');
    sticky.appendTo('body')
      .draggable()
      .mousedown(function() {
        $('.sticky').removeClass('selected');
        $(this).addClass('selected');
        document.getElementById("textarea").value=item.text.replace(/<br>/g,"\n")
        document.getElementById("id").value=item.id;
        document.getElementById("color").value=item.color;
      })
      .dblclick(function () {

      })
      .mouseup(function() {
        document.getElementById("left").value=$(this).context.offsetLeft
        document.getElementById("top").value=$(this).context.offsetTop;
      });
    return sticky;
  }

    function load() {
    var items = [];
    for(var i=0;i<stickies.length;++i)
    {
      items.push({
        css: {
          left: Number(stickies[i].left),
          top:  Number(stickies[i].top),
          backgroundColor: stickies[i].color,
        },
        html: "No:"+stickies[i].id+" "
           +"User:"+stickies[i].username+"<br>"
           +"Date:"+stickies[i].time+"<br>"
            +stickies[i].text,
        id : stickies[i].id,
        text :stickies[i].text,
        color:stickies[i].color
      });
    }
    if (!(0<items.length))
    {
      return;
    }
    $.each(items, function(i, item) {
      make(item).css(item.css).html(item.html);
    });
  }

  load();