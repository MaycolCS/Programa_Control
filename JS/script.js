function pregunta(){
  if (confirm('¿Esta seguro de continuar?')){
    document.form.submit()
  }
}

function cambiarDatosCotizacion() {
  let precioItem1 = 0;
  let precioItem2 = 0;
  let precioItem3 = 0;
  let precioItem4 = 0;
  let precioItem5 = 0;
  let precioItem6 = 0;
  let precioItem7 = 0;
  let precioItem8 = 0;
  let precioItem9 = 0;
  let precioItem10 = 0;
  let precioItem11 = 0;
  let precioItem12 = 0;
  
  if (document.getElementById("valor_total_Item1")) {
    precioItem1 = parseInt($("#valor_total_Item1").text().replace(/[,]/g,''));
  }
  if (document.getElementById("valor_total_Item2")) {
    precioItem2 = parseInt($("#valor_total_Item2").text().replace(/[,]/g,''));
  }
  if (document.getElementById("valor_total_Item3")) {
    precioItem3 = parseInt($("#valor_total_Item3").text().replace(/[,]/g,''));
  }
  if (document.getElementById("valor_total_Item4")) {
    precioItem4 = parseInt($("#valor_total_Item4").text().replace(/[,]/g,''));
  }
  if (document.getElementById("valor_total_Item5")) {
    precioItem5 = parseInt($("#valor_total_Item5").text().replace(/[,]/g,''));
  }
  if (document.getElementById("valor_total_Item6")) {
    precioItem6 = parseInt($("#valor_total_Item6").text().replace(/[,]/g,''));
  }
  if (document.getElementById("valor_total_Item7")) {
    precioItem7 = parseInt($("#valor_total_Item7").text().replace(/[,]/g,''));
  }
  if (document.getElementById("valor_total_Item8")) {
    precioItem8 = parseInt($("#valor_total_Item8").text().replace(/[,]/g,''));
  }
  if (document.getElementById("valor_total_Item9")) {
    precioItem9 = parseInt($("#valor_total_Item9").text().replace(/[,]/g,''));
  }
  if (document.getElementById("valor_total_Item10")) {
    precioItem10 = parseInt($("#valor_total_Item10").text().replace(/[,]/g,''));
  }
  if (document.getElementById("valor_total_Item11")) {
    precioItem11 = parseInt($("#valor_total_Item11").text().replace(/[,]/g,''));
  }
  if (document.getElementById("valor_total_Item12")) {
    precioItem12 = parseInt($("#valor_total_Item12").text().replace(/[,]/g,''));
  }

  let cotizacion_subtotal = precioItem1+precioItem2+precioItem3+precioItem4+precioItem5+precioItem6+precioItem7+precioItem8+precioItem9+precioItem10+precioItem11+precioItem12;
  $("#valor_subtotal").text(new Intl.NumberFormat('en').format(Math.round(cotizacion_subtotal)));
  let cotizacion_porcentajeDescuento = parseInt($("#valor_porcentajedescuento").text().replace(/[,]/g,''))/100;
  let cotizacion_descuento = cotizacion_subtotal*(cotizacion_porcentajeDescuento);
  $("#valor_descuento").text(new Intl.NumberFormat('en').format(Math.round(cotizacion_descuento)));
  let cotizacion_iva = (cotizacion_subtotal-(cotizacion_subtotal*(cotizacion_porcentajeDescuento)))*0.19;
  $("#valor_iva").text(new Intl.NumberFormat('en').format(Math.round(cotizacion_iva)));
  let cotizacion_total = cotizacion_subtotal-cotizacion_descuento+cotizacion_iva;
  $("#valor_total").text(new Intl.NumberFormat('en').format(Math.round(cotizacion_total)));
}

$(document).ready(function () {

  /*$("#nitCliente").keyup(function () {
    this.value = (this.value + "").replace(/[^0-9]/g, "");
    if (this.value != "" && !isNaN(this.value)) {
      let number = this.value;
      document.getElementById("nitCliente").value = new Intl.NumberFormat('en').format(number);
    }
  });

  $("#nitTercero").keyup(function () {
    this.value = (this.value + "").replace(/[^0-9]/g, "");
    if (this.value != "" && !isNaN(this.value)) {
      let number = this.value;
      document.getElementById("nitTercero").value = new Intl.NumberFormat('en').format(number);
    }
  });*/

  $("#dvTercero").keyup(function () {
    this.value = (this.value + "").replace(/[^0-9]/g, "");
    if (this.value != "" && !isNaN(this.value)) {
      let number = this.value;
      document.getElementById("dvTercero").value = new Intl.NumberFormat('en').format(number);
    }
  });

  if (!isNaN($("#PreItem").val())) {
    if ($("#PreItem").val() != "") {
      let number = $("#PreItem").val();
      document.getElementById("PreItem").value = new Intl.NumberFormat('en').format(number);
    }
  }

  $("#PreItem").keyup(function () {
    this.value = (this.value + "").replace(/[^0-9]/g, "");
    if (this.value != "" && !isNaN(this.value)) {
      let number = this.value;
      document.getElementById("PreItem").value = new Intl.NumberFormat('en').format(number);
    }
  });

  $("#CantItem").keyup(function () {
    this.value = (this.value + "").replace(/[^0-9]/g, "");
    if (this.value != "" && !isNaN(this.value)) {
      let number = this.value;
      document.getElementById("CantItem").value = new Intl.NumberFormat('en').format(number);
    }
  });

  $("#IvaItem").keyup(function () {
    this.value = (this.value + "").replace(/[^0-9]/g, "");
    if (this.value != "" && !isNaN(this.value)) {
      let number = this.value;
      document.getElementById("IvaItem").value = new Intl.NumberFormat('en').format(number);
    }
  });

  $("#Departamento").change(function () {
    $("#Departamento option:selected").each(function () {
      id_Departamento = $(this).val();
      $.post("../../JS/Funciones_JS.php", { id_Departamento: id_Departamento }, function(data) {
        $("#ciudadTercero").html(data);
      });
      $.post("../../JS/Funciones_JS.php", { id_Departamento: id_Departamento }, function(data) {
        $("#ciudadPlantaTercero").html(data);
      });
    });
  });

  if ($("#Departamento").val() != "") {
    if (!isNaN($("#Departamento").val())) {
      id_Departamento = $("#Departamento").val();
      if ($("#ciudadTercero").val() != "" && !isNaN($("#ciudadTercero").val())) {
        id_CiudadTercero = $("#ciudadTercero").val();
        $.post("../../JS/Funciones_JS.php", { id_Departamento: id_Departamento, id_CiudadTercero: id_CiudadTercero}, function(data) {
          $("#ciudadTercero").html(data);
        });
      }
      if ($("#ciudadPlantaTercero").val() != "" && !isNaN($("#ciudadPlantaTercero").val())) {
        id_CiudadTercero = $("#ciudadPlantaTercero").val();
        $.post("../../JS/Funciones_JS.php", { id_Departamento: id_Departamento, id_CiudadTercero: id_CiudadTercero}, function(data) {
          $("#ciudadPlantaTercero").html(data);
        });
      }
    }
  }

  $("#formaPagoTercero").change(function () {
    let formaPago = $("#formaPagoTercero").val();
    $("#diasPago").show();
    $("#label_diasPago").show();
    if (formaPago == "1") {
      document.getElementById("diasPago").value = 5;
    } else if (formaPago == "2") {
      document.getElementById("diasPago").value = 30;
    } else if (formaPago == "3") {
      document.getElementById("diasPago").value = 0;
    } else if (formaPago == "") {
      $("#diasPago").hide();
      $("#label_diasPago").hide();
    }
  });

  if ($("#formaPagoTercero").val() != "") {
    $("#diasPago").show();
    $("#label_diasPago").show();
  } else {
    $("#diasPago").hide();
    $("#label_diasPago").hide();
  }

  $("#nitTercero").change(function () {
    id_Tercero = $(this).val().replace(/[,]/g,'');
    $.post("../../JS/Funciones_JS.php", { id_Tercero: id_Tercero }, function(data) {
      $("#PTercero").html(data);
    });
  });

  $("#contraseña").change(function () {
    if ($("#contraseña").val() != "") {
      $("#contraseña_validacion").change(function () {
        if ($("#contraseña").val() != "") {
          if ($("#contraseña").val() != $("#contraseña_validacion").val()) {
            document.getElementById("contraseña").value = "";
            document.getElementById("contraseña_validacion").value = "";
            alert("Las contraseñas ingresadas no coinciden");
          }
        }
      });
    }
  });

  $("#item1").change(function () {
    var isChecked = document.getElementById('item1').checked;
    if(isChecked) {
      document.querySelector("#cantidad1").required = true;
    } else {
      document.querySelector("#cantidad1").required = false;
    }
  });

  $("#item2").change(function () {
    var isChecked = document.getElementById('item2').checked;
    if(isChecked) {
      document.querySelector("#cantidad2").required = true;
    } else {
      document.querySelector("#cantidad2").required = false;
    }
  });

  $("#item3").change(function () {
    var isChecked = document.getElementById('item3').checked;
    if(isChecked) {
      document.querySelector("#cantidad3").required = true;
    } else {
      document.querySelector("#cantidad3").required = false;
    }
  });

  $("#item4").change(function () {
    var isChecked = document.getElementById('item4').checked;
    if(isChecked) {
      document.querySelector("#cantidad4").required = true;
    } else {
      document.querySelector("#cantidad4").required = false;
    }
  });

  $("#item5").change(function () {
    var isChecked = document.getElementById('item5').checked;
    if(isChecked) {
      document.querySelector("#cantidad5").required = true;
    } else {
      document.querySelector("#cantidad5").required = false;
    }
  });

  $("#item6").change(function () {
    var isChecked = document.getElementById('item6').checked;
    if(isChecked) {
      document.querySelector("#cantidad6").required = true;
    } else {
      document.querySelector("#cantidad6").required = false;
    }
  });

  $("#item7").change(function () {
    var isChecked = document.getElementById('item7').checked;
    if(isChecked) {
      document.querySelector("#cantidad7").required = true;
    } else {
      document.querySelector("#cantidad7").required = false;
    }
  });

  $("#item8").change(function () {
    var isChecked = document.getElementById('item8').checked;
    if(isChecked) {
      document.querySelector("#cantidad8").required = true;
    } else {
      document.querySelector("#cantidad8").required = false;
    }
  });

  $("#item9").change(function () {
    var isChecked = document.getElementById('item9').checked;
    if(isChecked) {
      document.querySelector("#cantidad9").required = true;
    } else {
      document.querySelector("#cantidad9").required = false;
    }
  });

  $("#item10").change(function () {
    var isChecked = document.getElementById('item10').checked;
    if(isChecked) {
      document.querySelector("#cantidad10").required = true;
    } else {
      document.querySelector("#cantidad10").required = false;
    }
  });

  $("#item11").change(function () {
    var isChecked = document.getElementById('item11').checked;
    if(isChecked) {
      document.querySelector("#cantidad11").required = true;
    } else {
      document.querySelector("#cantidad11").required = false;
    }
  });

  $("#item12").change(function () {
    var isChecked = document.getElementById('item12').checked;
    if(isChecked) {
      document.querySelector("#cantidad12").required = true;
    } else {
      document.querySelector("#cantidad12").required = false;
    }
  });

  //Actualización cotización

  $("#CantItem1").keyup(function () {
    this.value = (this.value + "").replace(/[^0-9]/g, "");
    if (this.value != "" && !isNaN(this.value)) {
      let number = this.value;
      document.getElementById("CantItem1").value = new Intl.NumberFormat('en').format(number);
      let cantidad = $("#CantItem1").val().replace(/[,]/g,'');
      let valorUnitario = $("#PreItem1").val().replace(/[,]/g,'');
      let valorTotal = cantidad*valorUnitario;    
      $("#valor_total_Item1").text(new Intl.NumberFormat('en').format(valorTotal));
    }
  });

  $("#PreItem1").keyup(function () {
    this.value = (this.value + "").replace(/[^0-9]/g, "");
    if (this.value != "" && !isNaN(this.value)) {
      let number = this.value;
      document.getElementById("PreItem1").value = new Intl.NumberFormat('en').format(number);
      let cantidad = $("#CantItem1").val().replace(/[,]/g,'');
      let valorUnitario = $("#PreItem1").val().replace(/[,]/g,'');
      let valorTotal = cantidad*valorUnitario;
      $("#valor_total_Item1").text(new Intl.NumberFormat('en').format(valorTotal));
    }
  });

  $("#CantItem2").keyup(function () {
    this.value = (this.value + "").replace(/[^0-9]/g, "");
    if (this.value != "" && !isNaN(this.value)) {
      let number = this.value;
      document.getElementById("CantItem2").value = new Intl.NumberFormat('en').format(number);
      let cantidad = $("#CantItem2").val().replace(/[,]/g,'');
      let valorUnitario = $("#PreItem2").val().replace(/[,]/g,'');
      let valorTotal = cantidad*valorUnitario;
      $("#valor_total_Item2").text(new Intl.NumberFormat('en').format(valorTotal));
    }
  });

  $("#PreItem2").keyup(function () {
    this.value = (this.value + "").replace(/[^0-9]/g, "");
    if (this.value != "" && !isNaN(this.value)) {
      let number = this.value;
      document.getElementById("PreItem2").value = new Intl.NumberFormat('en').format(number);
      let cantidad = $("#CantItem2").val().replace(/[,]/g,'');
      let valorUnitario = $("#PreItem2").val().replace(/[,]/g,'');
      let valorTotal = cantidad*valorUnitario;
      $("#valor_total_Item2").text(new Intl.NumberFormat('en').format(valorTotal));
    }
  });

  $("#CantItem3").keyup(function () {
    this.value = (this.value + "").replace(/[^0-9]/g, "");
    if (this.value != "" && !isNaN(this.value)) {
      let number = this.value;
      document.getElementById("CantItem3").value = new Intl.NumberFormat('en').format(number);
      let cantidad = $("#CantItem3").val().replace(/[,]/g,'');
      let valorUnitario = $("#PreItem3").val().replace(/[,]/g,'');
      let valorTotal = cantidad*valorUnitario;
      $("#valor_total_Item3").text(new Intl.NumberFormat('en').format(valorTotal));
    }
  });

  $("#PreItem3").keyup(function () {
    this.value = (this.value + "").replace(/[^0-9]/g, "");
    if (this.value != "" && !isNaN(this.value)) {
      let number = this.value;
      document.getElementById("PreItem3").value = new Intl.NumberFormat('en').format(number);
      let cantidad = $("#CantItem3").val().replace(/[,]/g,'');
      let valorUnitario = $("#PreItem3").val().replace(/[,]/g,'');
      let valorTotal = cantidad*valorUnitario;
      $("#valor_total_Item3").text(new Intl.NumberFormat('en').format(valorTotal));
    }
  });

  $("#CantItem4").keyup(function () {
    this.value = (this.value + "").replace(/[^0-9]/g, "");
    if (this.value != "" && !isNaN(this.value)) {
      let number = this.value;
      document.getElementById("CantItem4").value = new Intl.NumberFormat('en').format(number);
      let cantidad = $("#CantItem4").val().replace(/[,]/g,'');
      let valorUnitario = $("#PreItem4").val().replace(/[,]/g,'');
      let valorTotal = cantidad*valorUnitario;
      $("#valor_total_Item4").text(new Intl.NumberFormat('en').format(valorTotal));
    }
  });

  $("#PreItem4").keyup(function () {
    this.value = (this.value + "").replace(/[^0-9]/g, "");
    if (this.value != "" && !isNaN(this.value)) {
      let number = this.value;
      document.getElementById("PreItem4").value = new Intl.NumberFormat('en').format(number);
      let cantidad = $("#CantItem4").val().replace(/[,]/g,'');
      let valorUnitario = $("#PreItem4").val().replace(/[,]/g,'');
      let valorTotal = cantidad*valorUnitario;
      $("#valor_total_Item4").text(new Intl.NumberFormat('en').format(valorTotal));
    }
  });

  $("#CantItem5").keyup(function () {
    this.value = (this.value + "").replace(/[^0-9]/g, "");
    if (this.value != "" && !isNaN(this.value)) {
      let number = this.value;
      document.getElementById("CantItem5").value = new Intl.NumberFormat('en').format(number);
      let cantidad = $("#CantItem5").val().replace(/[,]/g,'');
      let valorUnitario = $("#PreItem5").val().replace(/[,]/g,'');
      let valorTotal = cantidad*valorUnitario;
      $("#valor_total_Item5").text(new Intl.NumberFormat('en').format(valorTotal));
    }
  });

  $("#PreItem5").keyup(function () {
    this.value = (this.value + "").replace(/[^0-9]/g, "");
    if (this.value != "" && !isNaN(this.value)) {
      let number = this.value;
      document.getElementById("PreItem5").value = new Intl.NumberFormat('en').format(number);
      let cantidad = $("#CantItem5").val().replace(/[,]/g,'');
      let valorUnitario = $("#PreItem5").val().replace(/[,]/g,'');
      let valorTotal = cantidad*valorUnitario;
      $("#valor_total_Item5").text(new Intl.NumberFormat('en').format(valorTotal));
    }
  });
  
  $("#CantItem6").keyup(function () {
    this.value = (this.value + "").replace(/[^0-9]/g, "");
    if (this.value != "" && !isNaN(this.value)) {
      let number = this.value;
      document.getElementById("CantItem6").value = new Intl.NumberFormat('en').format(number);
      let cantidad = $("#CantItem6").val().replace(/[,]/g,'');
      let valorUnitario = $("#PreItem6").val().replace(/[,]/g,'');
      let valorTotal = cantidad*valorUnitario;
      $("#valor_total_Item6").text(new Intl.NumberFormat('en').format(valorTotal));
    }
  });

  $("#PreItem6").keyup(function () {
    this.value = (this.value + "").replace(/[^0-9]/g, "");
    if (this.value != "" && !isNaN(this.value)) {
      let number = this.value;
      document.getElementById("PreItem6").value = new Intl.NumberFormat('en').format(number);
      let cantidad = $("#CantItem6").val().replace(/[,]/g,'');
      let valorUnitario = $("#PreItem6").val().replace(/[,]/g,'');
      let valorTotal = cantidad*valorUnitario;
      $("#valor_total_Item6").text(new Intl.NumberFormat('en').format(valorTotal));
    }
  });

  $("#CantItem7").keyup(function () {
    this.value = (this.value + "").replace(/[^0-9]/g, "");
    if (this.value != "" && !isNaN(this.value)) {
      let number = this.value;
      document.getElementById("CantItem7").value = new Intl.NumberFormat('en').format(number);
      let cantidad = $("#CantItem7").val().replace(/[,]/g,'');
      let valorUnitario = $("#PreItem7").val().replace(/[,]/g,'');
      let valorTotal = cantidad*valorUnitario;
      $("#valor_total_Item7").text(new Intl.NumberFormat('en').format(valorTotal));
    }
  });

  $("#PreItem7").keyup(function () {
    this.value = (this.value + "").replace(/[^0-9]/g, "");
    if (this.value != "" && !isNaN(this.value)) {
      let number = this.value;
      document.getElementById("PreItem7").value = new Intl.NumberFormat('en').format(number);
      let cantidad = $("#CantItem7").val().replace(/[,]/g,'');
      let valorUnitario = $("#PreItem7").val().replace(/[,]/g,'');
      let valorTotal = cantidad*valorUnitario;
      $("#valor_total_Item7").text(new Intl.NumberFormat('en').format(valorTotal));
    }
  });

  $("#CantItem8").keyup(function () {
    this.value = (this.value + "").replace(/[^0-9]/g, "");
    if (this.value != "" && !isNaN(this.value)) {
      let number = this.value;
      document.getElementById("CantItem8").value = new Intl.NumberFormat('en').format(number);
      let cantidad = $("#CantItem8").val().replace(/[,]/g,'');
      let valorUnitario = $("#PreItem8").val().replace(/[,]/g,'');
      let valorTotal = cantidad*valorUnitario;
      $("#valor_total_Item8").text(new Intl.NumberFormat('en').format(valorTotal));
    }
  });

  $("#PreItem8").keyup(function () {
    this.value = (this.value + "").replace(/[^0-9]/g, "");
    if (this.value != "" && !isNaN(this.value)) {
      let number = this.value;
      document.getElementById("PreItem8").value = new Intl.NumberFormat('en').format(number);
      let cantidad = $("#CantItem8").val().replace(/[,]/g,'');
      let valorUnitario = $("#PreItem8").val().replace(/[,]/g,'');
      let valorTotal = cantidad*valorUnitario;
      $("#valor_total_Item8").text(new Intl.NumberFormat('en').format(valorTotal));
    }
  });

  $("#CantItem9").keyup(function () {
    this.value = (this.value + "").replace(/[^0-9]/g, "");
    if (this.value != "" && !isNaN(this.value)) {
      let number = this.value;
      document.getElementById("CantItem9").value = new Intl.NumberFormat('en').format(number);
      let cantidad = $("#CantItem9").val().replace(/[,]/g,'');
      let valorUnitario = $("#PreItem9").val().replace(/[,]/g,'');
      let valorTotal = cantidad*valorUnitario;
      $("#valor_total_Item9").text(new Intl.NumberFormat('en').format(valorTotal));
    }
  });

  $("#PreItem9").keyup(function () {
    this.value = (this.value + "").replace(/[^0-9]/g, "");
    if (this.value != "" && !isNaN(this.value)) {
      let number = this.value;
      document.getElementById("PreItem9").value = new Intl.NumberFormat('en').format(number);
      let cantidad = $("#CantItem9").val().replace(/[,]/g,'');
      let valorUnitario = $("#PreItem9").val().replace(/[,]/g,'');
      let valorTotal = cantidad*valorUnitario;
      $("#valor_total_Item9").text(new Intl.NumberFormat('en').format(valorTotal));
    }
  });

  $("#CantItem10").keyup(function () {
    this.value = (this.value + "").replace(/[^0-9]/g, "");
    if (this.value != "" && !isNaN(this.value)) {
      let number = this.value;
      document.getElementById("CantItem10").value = new Intl.NumberFormat('en').format(number);
      let cantidad = $("#CantItem10").val().replace(/[,]/g,'');
      let valorUnitario = $("#PreItem10").val().replace(/[,]/g,'');
      let valorTotal = cantidad*valorUnitario;
      $("#valor_total_Item10").text(new Intl.NumberFormat('en').format(valorTotal));
    }
  });

  $("#PreItem10").keyup(function () {
    this.value = (this.value + "").replace(/[^0-9]/g, "");
    if (this.value != "" && !isNaN(this.value)) {
      let number = this.value;
      document.getElementById("PreItem10").value = new Intl.NumberFormat('en').format(number);
      let cantidad = $("#CantItem10").val().replace(/[,]/g,'');
      let valorUnitario = $("#PreItem10").val().replace(/[,]/g,'');
      let valorTotal = cantidad*valorUnitario;
      $("#valor_total_Item10").text(new Intl.NumberFormat('en').format(valorTotal));
    }
  });

  $("#CantItem11").keyup(function () {
    this.value = (this.value + "").replace(/[^0-9]/g, "");
    if (this.value != "" && !isNaN(this.value)) {
      let number = this.value;
      document.getElementById("CantItem11").value = new Intl.NumberFormat('en').format(number);
      let cantidad = $("#CantItem11").val().replace(/[,]/g,'');
      let valorUnitario = $("#PreItem11").val().replace(/[,]/g,'');
      let valorTotal = cantidad*valorUnitario;
      $("#valor_total_Item11").text(new Intl.NumberFormat('en').format(valorTotal));
    }
  });

  $("#PreItem11").keyup(function () {
    this.value = (this.value + "").replace(/[^0-9]/g, "");
    if (this.value != "" && !isNaN(this.value)) {
      let number = this.value;
      document.getElementById("PreItem11").value = new Intl.NumberFormat('en').format(number);
      let cantidad = $("#CantItem11").val().replace(/[,]/g,'');
      let valorUnitario = $("#PreItem11").val().replace(/[,]/g,'');
      let valorTotal = cantidad*valorUnitario;
      $("#valor_total_Item11").text(new Intl.NumberFormat('en').format(valorTotal));
    }
  });

  $("#CantItem12").keyup(function () {
    this.value = (this.value + "").replace(/[^0-9]/g, "");
    if (this.value != "" && !isNaN(this.value)) {
      let number = this.value;
      document.getElementById("CantItem12").value = new Intl.NumberFormat('en').format(number);
      let cantidad = $("#CantItem12").val().replace(/[,]/g,'');
      let valorUnitario = $("#PreItem12").val().replace(/[,]/g,'');
      let valorTotal = cantidad*valorUnitario;
      $("#valor_total_Item12").text(new Intl.NumberFormat('en').format(valorTotal));
    }
  });

  $("#PreItem12").keyup(function () {
    this.value = (this.value + "").replace(/[^0-9]/g, "");
    if (this.value != "" && !isNaN(this.value)) {
      let number = this.value;
      document.getElementById("PreItem12").value = new Intl.NumberFormat('en').format(number);
      let cantidad = $("#CantItem12").val().replace(/[,]/g,'');
      let valorUnitario = $("#PreItem12").val().replace(/[,]/g,'');
      let valorTotal = cantidad*valorUnitario;
      $("#valor_total_Item12").text(new Intl.NumberFormat('en').format(valorTotal));
    }
  });

});