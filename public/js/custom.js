function submitLogin(idForm, btn) {
    console.log('oi');
  if ($("." + btn).attr("disabled") !== "disabled") {
    //Travar o duplo click
    $("." + btn).attr("disabled", true);
    $(".loading").show();

    var objAjax = {
      url: $("#" + idForm).attr("url"),
      method: $("#" + idForm).attr("method"),
      data: $("#" + idForm).serialize(),
      dataType: "json",
    };
    $.ajax(objAjax)
      .done(function (data) {
        console.log(data);
        // limpaMensagem();
        $(".alert").hide();
        $(".msgAlert").html("");
        //Habilita botão
        $("." + btn).attr("disabled", false);
        if (data.url == "") {
          if (data.resetFormulario == true) {
            $(":input", "#" + idForm)
              .not(":button, :submit, :reset, :hidden")
              .val("")
              .removeAttr("checked")
              .removeAttr("selected");
          }
          $(".alert")
            .attr({
              class: "alert " + data.class + " alert-dismissible ",
              role: "alert",
            })
            .slideDown();
          $(".msgAlert").html(data.msg);
          $(".loading").hide();
        } else {
          if (data.msg != "") {
            $(".alert")
              .attr({
                class: "alert " + data.class + " alert-dismissible ",
                role: "alert",
              })
              .slideDown();
            $(".msgAlert").html(data.msg);
            $(".loading").hide();
          }
          window.location = data.url;
        }
      })
      .fail(function (settings) {
        // limpaMensagem();
        $("." + btn).attr("disabled", false);
        if (settings.status === 400) {
          if (settings.responseJSON.return !== "error") {
            $(".alert")
              .attr({
                class: "alert alert-danger alert-dismissible ",
                role: "alert",
              })
              .slideDown();
            $(".msgAlert").html(
              '<strong><i class="fa fa-warning"></i> Erro!</strong> Não foi possível enviar a informação verifique os itens destacados:'
            );
            var i = 1;
            $.each(settings.responseJSON, function (index, value) {
              //Seta o foco no primeiro elemento encontrado
              if (i === 1) {
                /**
                 * Se for abas procurar o pai para marcar
                 */
                $("#" + index).focus();
              }
              $("#" + index + "Error").addClass("has-error");
              var mensagem = "";
              $.each(value, function (indexMs, ms) {
                mensagem += "- " + ms + "<br>";
              });
              $("#" + index + "MsgError").html(mensagem);
              i++;
            });
          } else {
            $(".alert")
              .attr({
                class:
                  "alert " +
                  settings.responseJSON.class +
                  " alert-dismissible ",
                role: "alert",
              })
              .slideDown();
            $(".msgAlert").html(settings.responseJSON.msg);
          }
        } else if (settings.status === 500) {
          $(".alert")
            .attr({
              class: "alert alert-danger alert-dismissible ",
              role: "alert",
            })
            .slideDown();
          $(".msgAlert").html(
            "<strong>Erro Interno!</strong> Não foi possível enviar os dados."
          );
        }
        $(".loading").hide();
      });
  }
}

function submitForm(idForm, btn) {
  if ($("." + btn).attr("disabled") !== "disabled") {
    //Travar o duplo click
    $("." + btn).attr("disabled", true);
    $(".loading").show();
    $(".editor").each(function () {
      var $textarea = $(this);
      $textarea.val(CKEDITOR.instances[$textarea.attr("id")].getData());
    });
    if ($("#" + idForm).attr("enctype") == "multipart/form-data") {
      var objAjax = {
        url: $("#" + idForm).attr("url"),
        method: $("#" + idForm).attr("method"),
        data: new FormData($("#" + idForm).get(0)),
        dataType: "json",
        contentType: false,
        processData: false,
      };
    } else {
      var objAjax = {
        url: $("#" + idForm).attr("url"),
        method: $("#" + idForm).attr("method"),
        data: $("#" + idForm).serialize(),
        dataType: "json",
      };
    }
    $.ajax(objAjax)
      .done(function (data) {
        // limpaMensagem();
        //Habilita botão
        $("." + btn).attr("disabled", false);
        if (data.url == "") {
          if (data.resetFormulario == true) {
            $(":input", "#" + idForm)
              .not(":button, :submit, :reset, :hidden")
              .val("")
              .removeAttr("checked")
              .removeAttr("selected");
          }
          /**
           * Notification
           */
          var notice = new PNotify({
            title: "<b>" + data.title + "</b>",
            text: data.msg,
            type: data.class,
            addclass: "stack-bar-top",
            stack: stack_bar_top,
            width: "100%",
          });
          $(".loading").hide();
        } else {
          if (data.msg != "") {
            window.sessionStorage.setItem("titleAlertMs", data.title);
            window.sessionStorage.setItem("msgClass", data.class);
            window.sessionStorage.setItem("msgAlertMs", data.msg);
            $(".loading").hide();
          }
          window.location = data.url;
        }
      })
      .fail(function (settings) {
        // limpaMensagem();
        $("." + btn).attr("disabled", false);
        if (settings.status === 400) {
          if (settings.responseJSON.return !== "error") {
            /**
             * Notification
             */
            var notice = new PNotify({
              title: "<b>Erro!</b>",
              text: "Não foi possível enviar a informação verifique os itens destacados:",
              type: "error",
              addclass: "stack-bar-top",
              stack: stack_bar_top,
              width: "100%",
            });
            var i = 1;
            $.each(settings.responseJSON, function (index, value) {
              //Seta o foco no primeiro elemento encontrado
              if (i === 1) {
                /**
                 * Se for abas procurar o pai para marcar
                 */
                var aba = $("#" + index)
                  .closest(".tab-pane")
                  .attr("id");
                if (aba != undefined) {
                  $("#btn" + aba).trigger("click");
                }
                /**
                 * Se for abas procurar o pai para marcar
                 */
                $("#" + index).focus();
              }
              $("#" + index + "Error").addClass("has-error");
              var mensagem = "";
              $.each(value, function (indexMs, ms) {
                mensagem += "- " + ms + "<br>";
              });
              $("#" + index + "MsgError").html(mensagem);
              i++;
            });
          } else {
            var notice = new PNotify({
              title: "<b>" + settings.responseJSON.title + "</b>",
              text: settings.responseJSON.msg,
              type: settings.responseJSON.class,
              addclass: "stack-bar-top",
              stack: stack_bar_top,
              width: "100%",
            });
          }
        } else if (settings.status === 401) {
          window.location = "/401";
        } else if (settings.status === 403) {
          window.location = "/403";
        } else if (settings.status === 404) {
          window.location = "/404";
        } else if (settings.status >= 500) {
          window.location = "/500";
        } else if (settings.status === 500) {
          var notice = new PNotify({
            title: "<b>Erro Interno!</b>",
            text: "Não foi possível enviar os dados",
            type: "error",
            addclass: "stack-bar-top",
            stack: stack_bar_top,
            width: "100%",
          });
        }
        $(".loading").hide();
      });
  }
}
