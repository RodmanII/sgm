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
  var inp  = document.querySelector('#nrwr')
  var sel  = document.querySelector('#nacimiento-cod_madre')
  var disp = document.querySelector('#matches')
  var elemento = document.getElementById('nacimiento-cod_madre');

  var inp1  = document.querySelector('#nrwr1')
  var sel1  = document.querySelector('#nacimiento-cod_asentado')
  var disp1 = document.querySelector('#matches1')
  var elemento1 = document.getElementById('nacimiento-cod_asentado');

  var inp2  = document.querySelector('#nrwr2')
  var sel2  = document.querySelector('#nacimiento-cod_padre')
  var disp2 = document.querySelector('#matches2')
  var elemento2 = document.getElementById('nacimiento-cod_padre');

  var inp3  = document.querySelector('#nrwr3')
  var sel3  = document.querySelector('#partida-cod_informante')
  var disp3 = document.querySelector('#matches3')
  var elemento3 = document.getElementById('partida-cod_informante');

  var inp4  = document.querySelector('#nrwr4')
  var sel4  = document.querySelector('#nacimiento-cod_hospital')
  var disp4 = document.querySelector('#matches4')
  var elemento4 = document.getElementById('nacimiento-cod_hospital');

  // kick it off
  var listado = []
  var listado1 = []
  var listado2 = []
  var listado3 = []
  var listado4 = []

  for(var i = 0;i<elemento.length;i++){
    listado.push([]);
    listado[i].push(elemento.options[i].value);
    listado[i].push(elemento.options[i].innerHTML);
  }
  for(var i = 0;i<elemento1.length;i++){
    listado1.push([]);
    listado1[i].push(elemento1.options[i].value);
    listado1[i].push(elemento1.options[i].innerHTML);
  }
  for(var i = 0;i<elemento2.length;i++){
    listado2.push([]);
    listado2[i].push(elemento2.options[i].value);
    listado2[i].push(elemento2.options[i].innerHTML);
  }
  for(var i = 0;i<elemento3.length;i++){
    listado3.push([]);
    listado3[i].push(elemento3.options[i].value);
    listado3[i].push(elemento3.options[i].innerHTML);
  }
  for(var i = 0;i<elemento4.length;i++){
    listado4.push([]);
    listado4[i].push(elemento4.options[i].value);
    listado4[i].push(elemento4.options[i].innerHTML);
  }

  var nrwr = new Narrower(inp, sel, disp, listado)
  var nrwr1 = new Narrower(inp1, sel1, disp1, listado1)
  var nrwr2 = new Narrower(inp2, sel2, disp2, listado2)
  var nrwr3 = new Narrower(inp3, sel3, disp3, listado3)
  var nrwr4 = new Narrower(inp4, sel4, disp4, listado4)

  nrwr.init()
  nrwr1.init()
  nrwr2.init()
  nrwr3.init()
  nrwr4.init()

  $("#edit-asentado").click(function(){
    window.open('/sgm/web/persona/index');
  });

  $("#edit-madre").click(function(){
    window.open('/sgm/web/persona/index');
  });

  $("#edit-padre").click(function(){
    window.open('/sgm/web/persona/index');
  });

  $("#edit-informante").click(function(){
    window.open('/sgm/web/informante/index');
  });

  $("#edit-hospital").click(function(){
    window.open('/sgm/web/hospital/index');
  });

  $('#generar').click(function(){
    var dnacimiento = $('[id^=nacimiento]').serializeArray();
    var dpartida = $('[id^=partida]').serializeArray();
    var longdn = dnacimiento.length, longdp = dpartida.length;
    var cadena = "&parametros=";
    jQuery.each(dnacimiento, function(i, param){
      cadena+=param.name.slice(param.name.indexOf("[")+1, -1)+"*"+param.value+";";
    });
    jQuery.each(dpartida, function(i, param){
      cadena+=param.name.slice(param.name.indexOf("[")+1, -1)+"*"+param.value;
      if(i<longdp-1){
        cadena+=";";
      }
    });
    window.open('generar?tipo=nacimiento'+cadena);
  });

  $('#reload-asentado').click(function(){
    location.reload();
    window.sessionStorage.setItem('recargado',true);
    window.sessionStorage.setItem('destino','nrwr1');
  });

  $('#reload-madre').click(function(){
    location.reload();
    window.sessionStorage.setItem('recargado',true);
    window.sessionStorage.setItem('destino','nrwr');
  });

  $('#reload-padre').click(function(){
    location.reload();
    window.sessionStorage.setItem('recargado',true);
    window.sessionStorage.setItem('destino','nrwr2');
  });

  $('#reload-informante').click(function(){
    location.reload();
    window.sessionStorage.setItem('recargado',true);
    window.sessionStorage.setItem('destino','nrwr3');
  });

  $('#reload-hospital').click(function(){
    location.reload();
    window.sessionStorage.setItem('recargado',true);
    window.sessionStorage.setItem('destino','nrwr4');
  });

  if(window.sessionStorage.getItem('recargado')=='true'){
    $('#'+window.sessionStorage.getItem('destino')).focus();
    window.sessionStorage.setItem('recargado',false);
  }
}(this, this.document))
