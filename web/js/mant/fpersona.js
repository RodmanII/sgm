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

function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}
