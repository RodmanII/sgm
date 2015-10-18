$('#procesar').click(function(){
  var reg = /^\d+$/;
  if($('#numdoca').val()!=''){
    if (!reg.test($('#numdoca').val())){
      alert("El documento alternativo solo debe contener números");
      return;
    }
  }
  if($('#esinfor').val() == 'Si'){
    if($('#persona-dui').val() == '' && ($('#nomdoca').val() == '' || $('#numdoca').val() == '')){
      alert('Debe especificar DUI o un Documento Alternativo');
      return;
    }
  }
    $('#personafrm').submit();
});

$('#persona-genero').change(function(){
  var valor = $('#persona-genero:checked').val();
  if(valor == 'Femenino'){
    //Si es mujer debo habilitar el apelldio de casada
    $('#persona-apellido_casada').prop('disabled', false);
  }else{
    $('#persona-apellido_casada').prop('disabled', true);
    $('#persona-apellido_casada').val('');
  }
});
