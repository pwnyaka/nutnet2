<form action="">
  <label for="firstName">Имя</label>
  <input type="text" name="first_name" id="firstName">

  <label for="lastName">Фамилия</label>
  <input type="text" name="last_name" id="lastName">

  <label for="age">Возраст</label>
  <input type="number" name="age" id="age">
  <input type="submit" id="save" value="Сохранить">
  <input type="submit" id="unload" value="Выгрузить">
</form>
<span style="display: none" class="validation-required">Заполните все поля!</span>
<span style="display: none" class="validation-format">Поля Имя и Фамилия должны состоять только из русских букв и начинаться с заглавной буквы!</span>
<script src="/js/script.js"></script>