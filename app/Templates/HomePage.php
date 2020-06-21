<!doctype html>
<html lang="en" class="h-100">

<head>
  <title>Data4Test</title>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="minimum-scale=1, initial-scale=1, width=device-width" />
  <base href="/" target="_blank">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
  <nav class="navbar navbar-expand-md navbar-light bg-light shadow-sm">
    <a class="navbar-brand d-flex" target="_self" href="/">
      <span class="text-success h2 my-auto">D</span>
      <span class="text-secondary mt-auto">ata</span>
      <span class="text-dark h2 my-auto">4</span>
      <span class="text-secondary mb-auto">tes</span>
      <span class="text-primary h2 my-auto">T</span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#documentation">Документация</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#sandbox">Песочница</a>
        </li>
      </ul>
    </div>
  </nav>

  <div class="tab-content mt-3">
    <div class="tab-pane container active" id="documentation">
      <h2>Сервер для генерации тестовых json данных</h2>
      <p>Построен с использованием библиотеки <a href="https://github.com/fzaninotto/Faker">Faker</a>. Поддерживает частичный набор типов библиотеки.</p>
      <div class="card shadow border-0 my-2">
        <div class="card-body">
          <h5 class="card-title">Упрощенный запрос</h5>
          <p class="card-text">
            <code>[GET] <span class="host">HOST</span>/api/simple/{locale}/{count}?{params}</code>
            <p>
              locale - локаль (ru_RU, en_US и т.д.)<br>
              count - количество строк результата<br>
              params - список полей и типов значений для заполнения
            </p>
          </p>
        </div>
      </div>
      <div class="card shadow border-0 my-2">
        <div class="card-body">
          <h5 class="card-title">Запрос с шаблоном</h5>
          <p class="card-text">
            <code>[POST] <span class="host">HOST</span>/api/template/{locale}</code>
            <p>
              locale - локаль (ru_RU, en_US и т.д.)<br><br>
              Структура шаблона:<br>
              <code>[<br>
                &nbsp;&nbsp;{ "key":keyName,"val": value, "count": count },<br>
                &nbsp;&nbsp;...<br>
                ]
              </code>
              <p>
                key - наименование поля результата
                val - наименование форматтера (если поддерживается) или вложенный шаблон
                count - счетчик для генерации результата (поддерживается только для объектов, где val является вложенным шаблоном)
              </p>

              <p>
                Шаблон поддерживает вложенность
              </p>
              <code>
                [<br>
                  &nbsp;&nbsp;{ "key": "company", "val": "company" },<br>
                  &nbsp;&nbsp;{<br>
                  &nbsp;&nbsp;&nbsp;&nbsp;"key": "data",<br>
                  &nbsp;&nbsp;&nbsp;&nbsp;"val": [<br>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{ "key": "name", "val": "name" },<br>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{ "key": "jobTitle", "val": "jobTitle" }<br>
                  &nbsp;&nbsp;&nbsp;&nbsp;],<br>
                  &nbsp;&nbsp;&nbsp;&nbsp;"count": 3<br>
                  &nbsp;&nbsp;}<br>
                ]
              </code>
            </p>
          </p>
        </div>
      </div>
      <div class="card shadow border-0 my-2">
        <div class="card-body">
        <h5 class="card-title">Список доступных форматтеров:</h5>
        <p class="card-text">
          <code class="d-flex flex-wrap">
            <?php
              foreach (\App\Utils\DataFiller::$fieldTypes as $val) {
                  echo '<span class="m-1">'.$val."</span>";
              }
            ?>
          </code>
        </p>
        </div>
      </div>
    </div>
    <div class="tab-pane container fade" id="sandbox">
      <div class="d-flex flex-wrap">
        <label class="my-auto">Локаль</label>
        <select class="form-control form-control-sm mx-2" id="locale" style="max-width: 120px">
          <?php
            foreach (getFileList(__DIR__."../../../vendor/fzaninotto/faker/src/Faker/Provider") as $dir) {
                $locale = basename($dir['name']);
                $sel = $locale == 'en_US' ? "selected" : null;
                echo "<option $sel>$locale</option>";
            }
          ?>
        </select>
        <div class="btn btn-sm btn-primary" onClick="getData()">Получить данные</div>
      </div>
      <div class="row" style="height: 70vh!important;">
        <div class="col-md-6 p-1">
          <div>Шаблон</div>
          <div id="editor" class="my-3 shadow h-100"></div>
        </div>
        <div class="col-md-6 p-1">
          <div>Ответ</div>
          <div id="editor-res" class="my-3 shadow h-100"></div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

  <!--script src="https://cdn.jsdelivr.net/npm/ace-min-noconflict@1.1.9/ace.js"></script-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.11/ace.min.js" integrity="sha256-qCCcAHv/Z0u7K344shsZKUF2NR+59ooA3XWRj0LPGIQ=" crossorigin="anonymous"></script>

  <script>
    $('.host').html(window.location.origin);

    var jsonData = [
      { "key": "company", "val": "company" },
      {
        "key": "data",
        "val": [
          { "key": "name", "val": "name" },
          { "key": "jobTitle", "val": "jobTitle" }
        ],
        "count": 3
      }
    ];

    ace.config.set("basePath", "https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.11/");

    var editor = ace.edit("editor");
    //editor.setTheme("ace/theme/monokai");
    editor.session.setMode("ace/mode/json");

    var editor_res = ace.edit("editor-res");
    editor_res.session.setMode("ace/mode/json");
    editor_res.setReadOnly(true);

    editor.setValue(JSON.stringify(jsonData, null, 2), 0);
    editor.clearSelection();

    var getData = function () {
      jsonData = editor.getValue();

      $.ajax({
        url: "api/template/"+$('#locale').val(),
        type: "POST",
        contentType:"application/json; charset=utf-8",
        dataType:"json",
        data: jsonData,
        success: function(data) {
          editor_res.setValue(JSON.stringify(data, null, 2), 0);
          editor_res.clearSelection();
        },
        error: function(data) {
          editor_res.setValue(JSON.stringify(data.responseJSON, null, 2), 0);
          editor_res.clearSelection();
        }
      });
    }
  </script>
</body>

</html>
