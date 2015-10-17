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
  var sel1  = document.querySelector('#matrimonio-codconhom')
  var disp1 = document.querySelector('#matches1')
  var elemento1 = document.getElementById('matrimonio-codconhom');

  var inp2  = document.querySelector('#nrwr2')
  var sel2  = document.querySelector('#matrimonio-codconmuj')
  var disp2 = document.querySelector('#matches2')
  var elemento2 = document.getElementById('matrimonio-codconmuj');

  // kick it off
  var listado1 = []
  var listado2 = []

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

  var nrwr1 = new Narrower(inp1, sel1, disp1, listado1)
  var nrwr2 = new Narrower(inp2, sel2, disp2, listado2)

  nrwr1.init()
  nrwr2.init()

  $("#edit-hombre").click(function(){
    window.open('/sgm/web/persona/index');
  });

  $("#edit-mujer").click(function(){
    window.open('/sgm/web/persona/index');
  });

  function enviarParametros(archivo,ventana){
    archivo = typeof archivo !== 'undefined' ? archivo : false;
    ventana = typeof ventana !== 'undefined' ? ventana : true;
    var dmatrimonio = $('[id^=matrimonio]').serializeArray();
    var dpartida = $('[id^=partida]').serializeArray();
    var longdn = dmatrimonio.length, longdp = dpartida.length;
    var gen_notario = $('input[name=gen_notario]:checked').val();
    var cadena = "&parametros=gen_notario*"+gen_notario+';';
    jQuery.each(dmatrimonio, function(i, param){
      cadena+=param.name.slice(param.name.indexOf("[")+1, -1)+"*"+param.value+";";
    });
    jQuery.each(dpartida, function(i, param){
      cadena+=param.name.slice(param.name.indexOf("[")+1, -1)+"*"+param.value;
      if(i<longdp-1){
        cadena+=";";
      }
    });
    //Obtener los testigos
    var testigos = ';testigos*';
    var long = $("#ttestigos tbody").children().length;
    $("#ttestigos > tbody > tr").each(function(index, element){
      var elemento = $(this);
      var anex = '-';
      if(index == long-1){
        anex = '';
      }
      testigos += elemento.find(".nom").html()+anex;
    });
    var gar = '&guardar=false';
    if(archivo){
      gar = '&guardar=true';
    }
    if(ventana){
      window.open('generar?tipo=matrimonio'+gar+cadena+testigos);
    }else{
      $.get('generar','tipo=matrimonio'+gar+cadena+testigos);
    }
  }

  $('#generar').click(function(){
    var tbody = $("#ttestigos tbody");
    if(tbody.children().length > 0){
      enviarParametros(false);
    }else{
      alert('Tiene que especificar a al menos un testigo');
    }
  });

  $('#guardar').click(function(){
    var madrehom = $('#matrimonio-madre_contrayente_h').val();
    var padrehom = $('#matrimonio-padre_contrayente_h').val();
    var madremuj = $('#matrimonio-madre_contrayente_m').val();
    var padremuj = $('#matrimonio-padre_contrayente_m').val();
    var seguir = false;
    var long = $("#ttestigos tbody").children().length;
    var contenido = '';
    if(madrehom != '' || padrehom != ''){
      if(madremuj != '' || padremuj != ''){
        if(long == 2){
          $("#ttestigos > tbody > tr").each(function(index, element){
            var elemento = $(this);
            var anex = '-';
            if(index == long-1){
              anex = '';
            }
            contenido += elemento.find(".nom").html()+anex;
          });
          $('#ites').val(contenido);
          enviarParametros(true,false);
          $('#imatrimonio').submit();
        }else{
          alert('Tiene que especificar a dos testigos');
        }
      }else{
        alert('Tiene que especificar padre, madre u ambos para la contrayente');
      }
    }else{
      alert('Tiene que especificar padre, madre u ambos para el contrayente');
    }
  }
);

$('#reload-hombre').click(function(){
  location.reload();
  window.sessionStorage.setItem('recargado',true);
  window.sessionStorage.setItem('destino','nrwr1');
});

$('#reload-mujer').click(function(){
  location.reload();
  window.sessionStorage.setItem('recargado',true);
  window.sessionStorage.setItem('destino','nrwr2');
});

if(window.sessionStorage.getItem('recargado')=='true'){
  $('#'+window.sessionStorage.getItem('destino')).focus();
  window.sessionStorage.setItem('recargado',false);
}

$('#matrimonio-ape').change(function(){
  var valor = $('input[name=adop_casada]:checked').val();
  if(valor == 'Si'){
    $("#matrimonio-acas").prop('readonly', false);
  }else{
    $("#matrimonio-acas").prop('readonly', true);
    $("#matrimonio-acas").val('');
  }
});

$('#agtestigo').click(function(){
  var nombre = $('#nomtestigo').val();
  var seguir = true;
  if(nombre != ''){
    var tbody = $("#ttestigos tbody");
    if(tbody.children().length > 0) {
      $("#ttestigos > tbody > tr").each(function() {
        var elemento = $(this);
        if(nombre.toLowerCase() == elemento.find(".nom").html().toLowerCase()){
          alert('El testigo ya ha sido especificado');
          seguir = false;
          return false;
        }
      });
    }
    if(tbody.children().length == 2) {
      alert('Ya se han especificado dos testigos');
      seguir = false;
    }
    if(seguir){
      $('#ttestigos > tbody:last-child').append('<tr><td class="nom">'+nombre+'</td><td><span class="glyphicon glyphicon-trash" onClick=$(this).closest("tr").remove() style="color:#337ab7;"></span></td></td></tr>');
      $('#nomtestigo').val('');
    }
  }else{
    alert('El nombre no puede estar vacio');
  }
});

}(this, this.document))
