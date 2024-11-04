var tipoDocumento = "cpf";

$(document).ready(function () {
  ocultarCampos();

  $("#numrCpfCnpj").on("input", function () {
    valor = $(this).val().replace(/\D/g, ""); // Remove qualquer caractere que não seja dígito
    valor = valor.slice(0, 14);

    if (valor.length <= 11) {
      // CPF
      tipoDocumento = "cpf";
      valor = valor.replace(/(\d{3})(\d)/, "$1.$2");
      valor = valor.replace(/(\d{3})(\d)/, "$1.$2");
      valor = valor.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
    } else {
      // CNPJ
      tipoDocumento = "cnpj";
      valor = valor.replace(/^(\d{2})(\d)/, "$1.$2");
      valor = valor.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3");
      valor = valor.replace(/\.(\d{3})(\d)/, ".$1/$2");
      valor = valor.replace(/(\d{4})(\d)/, "$1-$2");
    }

    $(this).val(valor);

    ocultarCampos();
  });
});

function ocultarCampos() {
  switch (tipoDocumento) {
    case "cpf":
      $(".inputNomeCliente").show();
      $(".inputNomeFantasia").hide();
      $(".inputRazaoSocial").hide();
      $(".inputInscricaoEstadual").hide();
      $(".inputInscricaoMunicipal").hide();

      break;
    case "cnpj":
      $(".inputNomeCliente").hide();
      $(".inputNomeFantasia").show();
      $(".inputRazaoSocial").show();
      $(".inputInscricaoEstadual").show();
      $(".inputInscricaoMunicipal").show();
      break;
  }
}
