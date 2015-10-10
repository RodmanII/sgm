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
  var sel1  = document.querySelector('#defuncion-cod_difunto')
  var disp1 = document.querySelector('#matches1')
  var elemento1 = document.getElementById('defuncion-cod_difunto');

  var inp2  = document.querySelector('#nrwr2')
  var sel2  = document.querySelector('#defuncion-cod_causa')
  var disp2 = document.querySelector('#matches2')
  var elemento2 = document.getElementById('defuncion-cod_causa');

  var inp3  = document.querySelector('#nrwr3')
  var sel3  = document.querySelector('#partida-cod_informante')
  var disp3 = document.querySelector('#matches3')
  var elemento3 = document.getElementById('partida-cod_informante');

  // kick it off
  var listado1 = []
  var listado2 = []
  var listado3 = []

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

  var nrwr1 = new Narrower(inp1, sel1, disp1, listado1)
  var nrwr2 = new Narrower(inp2, sel2, disp2, listado2)
  var nrwr3 = new Narrower(inp3, sel3, disp3, listado3)

  nrwr1.init()
  nrwr2.init()
  nrwr3.init()

  $("#edit-difunto").click(function(){
    window.open('/sgm/web/persona/index');
  });

  $("#edit-causa").click(function(){
    window.open('/sgm/web/causa/index');
  });

  $("#edit-informante").click(function(){
    window.open('/sgm/web/informante/index');
  });

  function enviarParametros(archivo,ventana){
    archivo = typeof archivo !== 'undefined' ? archivo : false;
    ventana = typeof ventana !== 'undefined' ? ventana : true;
    var dnacimiento = $('[id^=defuncion]').serializeArray();
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
    //Obtener los familiares
    var familiares = ';familiares*';
    var long = $("#tfamiliares tbody").children().length;
    $("#tfamiliares > tbody > tr").each(function(index, element){
      var elemento = $(this);
      var anex = '-';
      if(index == long-1){
        anex = '';
      }
      familiares += elemento.find(".nom").html()+':'+elemento.find(".rel").html()+anex;
    });
    var gar = '&guardar=false';
    if(archivo){
      gar = '&guardar=true';
    }
    if(ventana){
      window.open('generar?tipo=defuncion'+gar+cadena+familiares);
    }else{
      $.get('generar','tipo=defuncion'+gar+cadena+familiares);
    }
  }

  $('#generar').click(function(){
    var tbody = $("#tfamiliares tbody");
    if(tbody.children().length > 0){
      enviarParametros(false);
    }else{
      alert('Tiene que especificar a al menos un familiar');
    }
  });

  $('#guardar').click(function(){
    var tbody = $("#tfamiliares tbody");
    if(tbody.children().length > 0){
      $('#idefuncion').submit();
      enviarParametros(true,false);
    }else{
      alert('Tiene que especificar a al menos un familiar');
    }
  }
);

$('#reload-difunto').click(function(){
  location.reload();
  window.sessionStorage.setItem('recargado',true);
  window.sessionStorage.setItem('destino','nrwr1');
});

$('#reload-causa').click(function(){
  location.reload();
  window.sessionStorage.setItem('recargado',true);
  window.sessionStorage.setItem('destino','nrwr2');
});

$('#reload-informante').click(function(){
  location.reload();
  window.sessionStorage.setItem('recargado',true);
  window.sessionStorage.setItem('destino','nrwr3');
});

if(window.sessionStorage.getItem('recargado')=='true'){
  $('#'+window.sessionStorage.getItem('destino')).focus();
  window.sessionStorage.setItem('recargado',false);
}

$('#agfamiliar').click(function(){
  var nombre = $('#nomfamiliar').val();
  var genero = $('input[name=gen_familiar]:checked', '#idefuncion').val();
  var relacion = $('#relfamiliar').val();
  var trel = '';
  var seguir = true;
  if(nombre != ''){
    if(genero == 'Masculino'){
      trel = relacion+'o';
    }else{
      trel = relacion+'a';
    }
    if(genero == 'Masculino' && relacion == 'dre'){
      trel = 'Pa'+relacion;
    }else if(genero == 'Femenino' && relacion == 'dre'){
      trel = 'Ma'+relacion;
    }
    var tbody = $("#tfamiliares tbody");
    if(tbody.children().length > 0) {
      $("#tfamiliares > tbody > tr").each(function() {
        var elemento = $(this);
        if(trel == elemento.find(".rel").html()){
          alert('El familiar ya ha sido especificado');
          seguir = false;
          return false;
        }
        if(nombre.toLowerCase() == elemento.find(".nom").html().toLowerCase()){
          alert('El nombre ya ha sido especificado');
          seguir = false;
          return false;
        }
      });
    }
    if(seguir){
      $('#tfamiliares > tbody:last-child').append('<tr><td class="nom">'+nombre+'</td><td class="rel">'+trel+'</td><td><span class="glyphicon glyphicon-trash" onClick=$(this).closest("tr").remove() style="color:#337ab7;"></span></td></td></tr>');
    }
  }else{
    alert('El nombre no puede estar vacio');
  }
});

}(this, this.document))
