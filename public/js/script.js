"use strict";

window.onload = function () {
  let form = document.querySelector('form');
  let saveBtn = document.getElementById('save');
  let unloadBtn = document.getElementById('unload');
  let first_name = document.getElementById('firstName');
  let last_name = document.getElementById('lastName');
  let age = document.getElementById('age');

  unloadBtn.addEventListener('click', (e) => {
    e.preventDefault();
    fetch('/api/unload', {
      method: 'POST',
      body: JSON.stringify({
        "token": '123',
      }),
      headers: {
        'content-type': 'application/json'
      }
    })
        .then(response => response.json())
        .then((data) => {
          if (data.status === 'OK') {
            window.location.href = 'https://docs.google.com/spreadsheets/d/12j5qPd6caB9_esazuYVywR-LmgC8lnIpiVC7uR3rESk/edit?usp=sharing';
          }
        });
  });

  saveBtn.addEventListener('click', (e) => {
    e.preventDefault();
    document.querySelector('.validation-required').style.display = 'none';
    document.querySelector('.validation-format').style.display = 'none';

    if (!first_name.value || !last_name.value || !age.value) {

      document.querySelector('.validation-required').style.display = 'block';

    } else if (!/^[А-ЯЁ][а-яё]+$/.test(first_name.value) || !/^[А-ЯЁ][а-яё]+$/.test(last_name.value)) {

        document.querySelector('.validation-format').style.display = 'block';

    } else {

      fetch('/api/save', {
        method: 'POST',
        body: JSON.stringify({
          "first_name": first_name.value,
          "last_name": last_name.value,
          "age": age.value,

        }),
        headers: {
          'content-type': 'application/json'
        }
      })
          .then(response => response.json())
          .then((data) => {
            if (data.status === 'OK') {
              first_name.value = '';
              last_name.value = '';
              age.value = '';
              document.querySelector('.validation-required').style.display = 'none';
              document.querySelector('.validation-format').style.display = 'none';
              form.insertAdjacentHTML('afterEnd', `<span style="color: green;" class="success-message">Данные успешно сохранены!</span>`);
              setTimeout(() => {
                document.querySelector('.success-message').remove();
              }, 3000)
            }
          });
    }
  });
};