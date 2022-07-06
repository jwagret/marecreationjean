let activer = document.querySelectorAll("[type=checkbox]");

  for (let btn of activer) {
    btn.addEventListener('click', function () {
      let xmlhttp = new XMLHttpRequest();
      xmlhttp.open("get", `/admin/crud/transporteur/activer/${this.dataset.id}`)
      xmlhttp.send();
    });
  }



