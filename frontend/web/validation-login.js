$(document).ready(function() {
  $('#form-login').submit(function(event) {
    event.preventDefault();
    // Получаем объект формы
    var loginForm = $(this);
    // отправляем данные на сервер
    $.ajax({
      // Метод отправки данных (тип запроса)
      type : loginForm.attr('method'),
      // URL для отправки запроса
      url : loginForm.attr('action'),
      // Данные формы
      data : loginForm.serializeArray()
    }).done(function(data) {
      if (data.error == null) {
        // Если ответ сервера успешно получен
        var countErrors = Object.keys(data).length;
        var errEmail = '';
        if (typeof(data['formlogin-email']) !== 'undefined') {
          errEmail = data['formlogin-email'][0];
        }
        $(".help-block:first").text(errEmail);

        var errPass = '';
        if (typeof(data['formlogin-password']) !== 'undefined') {
          errPass = data['formlogin-password'][0];
        }
        $(".help-block:last").text(errPass);

        if (countErrors === 0) {
          loginForm.unbind('submit').submit();
        }
      } else {
        // Если при обработке данных на сервере произошла ошибка
        $(".help-block:last").text(data.error)
      }
    }).fail(function() {
      // Если произошла ошибка при отправке запроса
      $(".help-block:last").text("Ошибка обработки запроса");
    })
  })
})
