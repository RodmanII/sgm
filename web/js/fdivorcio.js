(function (window, document, undefined) {
  'use strict'

  function Narrower(inp, sel, disp, list) {
    this.inp  = inp
    this.sel  = sel
    this.disp = disp
    this.list = list
    this.last = '' // last value on which we narrowed
  }
  Narrower.prototype = {
    init : function () {
      this.update('')
      this.addEvents()
    },
    addEvents : function () {
      var self
      self = this
      this.inp.addEventListener('keyup', function (e) {
        if (this.value !== self.last) {
          self.last = this.value
          self.update(this.value)
        }
      })
      this.inp.focus()
    },
    update : function (str) {
      var ulist, rgxp
      // optimization
      if (0 === str.length) {
        ulist = this.list
      }
      else {
        ulist = []
        // create rgxp
        rgxp = new RegExp(str, 'i') // note: not Unicode-safe!
        // keep items that match
        for (var i = this.list.length - 1; i > -1; --i) {
          if (null !== this.list[i][1].match(rgxp)) {
            ulist.push(this.list[i])
          }
        }
      }
      this.updateSelect(ulist.sort())
      this.updateMatches(ulist.length)
    },
    updateSelect : function (arr) {
      var self, opts
      self = this
      this.sel.options.length = 0
      opts = this.buildOpts(arr)
      opts.forEach(function (opt, idx) {
        self.sel.options[idx] = opt
      })
    },
    buildOpts : function (arr) {
      var opts
      opts = []
      arr.forEach(function (val) {
        opts.push(new Option(val[1],val[0]))
      })
      return opts
    },
    updateMatches : function (len) {
      this.disp.innerHTML = 1 === len ? '1 match' : len + ' matches'
    }
  }

  // initialization
  var inp1  = document.querySelector('#nrwr1')
  var sel1  = document.querySelector('#divorcio-cod_matrimonio')
  var disp1 = document.querySelector('#matches1')
  var elemento1 = document.getElementById('divorcio-cod_matrimonio');

  // kick it off
  var listado1 = []

  for(var i = 0;i<elemento1.length;i++){
    listado1.push([]);
    listado1[i].push(elemento1.options[i].value);
    listado1[i].push(elemento1.options[i].innerHTML);
  }

  var nrwr1 = new Narrower(inp1, sel1, disp1, listado1)

  nrwr1.init()

  function enviarParametros(archivo,ventana){
    archivo = typeof archivo !== 'undefined' ? archivo : false;
    ventana = typeof ventana !== 'undefined' ? ventana : true;
    var ddivorcio = $('[id^=divorcio]').serializeArray();
    var dpartida = $('[id^=partida]').serializeArray();
    var longdn = ddivorcio.length, longdp = dpartida.length;
    var cadena = "&parametros=";
    jQuery.each(ddivorcio, function(i, param){
      cadena+=param.name.slice(param.name.indexOf("[")+1, -1)+"*"+param.value+";";
    });
    jQuery.each(dpartida, function(i, param){
      cadena+=param.name.slice(param.name.indexOf("[")+1, -1)+"*"+param.value;
      if(i<longdp-1){
        cadena+=";";
      }
    });
    var gar = '&guardar=false';
    if(archivo){
      gar = '&guardar=true';
    }
    if(ventana){
      window.open('generar?tipo=divorcio'+gar+cadena);
    }else{
      $.get('generar','tipo=divorcio'+gar+cadena);
    }
  }

  $('#generar').click(function(){
    enviarParametros(false);
  });

  $('#guardar').click(function(){
    enviarParametros(true,false);
    $('#idivorcio').submit();
  });
}(this, this.document))
