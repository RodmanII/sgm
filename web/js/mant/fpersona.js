$('#procesar').click(function(){
  var reg = /^\d+$/;
  var firmac = $('input:radio[name="informante"]:checked').val();
  if(firmac == 'Si'){
    var firma = $('#firin').val();
    if(firma == ''){
      alert("Debe especificar el archivo de firma");
      return;
    }else{
      var ext = firma.split('.').pop().toLowerCase();
      if($.inArray(ext, ['png','jpg','jpeg']) == -1) {
        alert('La extensión del archivo es inválida, solo se admite png y jpg');
        return;
      }
    }
  }
  if(firmac == 'Si'){
    if($('#persona-dui').val() == '' && $('#persona-carnet_minoridad').val() == ''){
      alert('Debe especificar DUI o Carnet de Minoridad');
      return;
    }
  }
  $('#personafrm').submit();
});

$('#persona-genero').change(function(){
  var valor = $('input:radio[name="Persona[genero]"]:checked').val();
  if(valor == 'Femenino'){
    //Si es mujer debo habilitar el apelldio de casada
    $('#persona-apellido_casada').prop('readonly', false);
  }else{
    $('#persona-apellido_casada').prop('readonly', true);
    $('#persona-apellido_casada').val('');
  }
});
