$.fn.serializeObject = function()
  {
    var o = {}, a = this.serializeArray();
    $.each(a, function() {

      if (/(\[\]$|\[.+\]$)/.test(this.name)) {

        var match = /(.+)(\[\]|\[(.+)\])/.exec(this.name);
        if (match[3] !== undefined)
        {
          var index = match[3];
          if (o[match[1]] === undefined)
            o[match[1]] = {};

          if (o[match[1]][index] === undefined)
            o[match[1]][index] = [o[match[1]][index]];

          o[match[1]][index] = this.value || '';

        } else {
          if (o[match[1]] === undefined)
            o[match[1]] = new Array;

          o[match[1]].push(this.value || '');
        }


      } else {
        if (o[this.name] !== undefined) {
          if (!o[this.name].push) {
            o[this.name] = [o[this.name]];
          }
          o[this.name].push(this.value || '');
        } else {
          o[this.name] = this.value || '';
        }
      }

    });

    return o;
  };