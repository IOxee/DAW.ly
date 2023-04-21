<?php $this->extend('layout/home') ?>

<?php $this->section('style') ?>
    <style>
        .canvas-container {
            position: relative;
            height: 200px;
            margin-bottom: 20px;
        }

        #chartDate {
            position: absolute;
            top: 0;
            right: 0;
            writing-mode: vertical-rl;
            text-orientation: mixed;
            transform: rotate(180deg);
            transform-origin: top right;
            padding: 10px;
            font-weight: bold;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }
    </style>
<?= $this->endSection() ?>

<?php $this->section('content') ?>
<div class="d-flex flex-column flex-shrink-0 bg-body-tertiary"
    style="width: 4.5rem; position: fixed; top: 10vh; left: 0; bottom: 0;">
    <ul class="nav nav-pills nav-flush flex-column mb-auto text-center">
        <li class="nav-item">
            <!-- button or a with create new -->
            <a href="<?= base_url('createnew') ?>" class="nav-link py-3 border-bottom rounded-0" aria-current="page"
                title="Create New" data-bs-toggle="tooltip" id="createnew">
                <i class="bi bi-plus-lg"></i>
                <span class="visually-hidden">Create New</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('dashboard') ?>" class="nav-link active py-3 border-bottom rounded-0"
                aria-current="page" title="Dashboard" data-bs-toggle="tooltip" data-bs-placement="right" id="dashboard">
                <i class="bi bi-house-door-fill"></i>
            </a>
        </li>
        <li>
            <a href="<?= base_url('manage') ?>" class="nav-link py-3 border-bottom rounded-0" title="Links"
                data-bs-toggle="tooltip" data-bs-placement="right" id="links">
                <i class="bi bi-link-45deg"></i>
            </a>
        </li>
        <li>
            <a href="<?= base_url('folders') ?>" class="nav-link py-3 border-bottom rounded-0" title="El Finder" data-bs-toggle="tooltip"
                data-bs-placement="right">
                <i class="bi bi-folder"></i>
            </a>
        </li>
        <li>
            <a href="#" class="nav-link py-3 border-bottom rounded-0" title="Link in Bio" data-bs-toggle="tooltip"
                data-bs-placement="right">
                <i class="bi bi-person-badge"></i>
            </a>
        </li>
        <?php if ($role >= 10): ?>
            <li>
                <a href="<?= base_url('users') ?>" class="nav-link py-3 border-bottom rounded-0" title="Usuarios" id="administration" data-bs-toggle="tooltip"
                    data-bs-placement="right">
                    <i class="bi bi-people"></i>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</div>
<div style="margin-left: 4.5rem;">
    <?php if ($setActive == 'dashboard'): ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-center">Dashboard</h1>
                </div>
            </div>
        </div>
    <?php elseif ($setActive == 'createnew'): ?>
        <div class="create-link-page" style="display: flex; flex-direction: column; overflow: auto;">
            <div class="create-link-page-container"
                style="align-self: center; width: 100%; max-width: 76.8rem; padding: 2.4rem 2.4rem;">
                <form action='<?= base_url('shorten') ?>' method="post">
                    <?= csrf_field() ?>
                    <div class="title-wrapper" style="margin: 0 0 2.2rem 0;">
                        <h1 class="custom_font" style="font-size: 2.2rem; line-height: 4rem;">Create New
                            <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary" tabindex="14">Create</button>
                        </h1>
                    </div>
                    <!-- Div de botoen centrado al medio 1 que ponga url y otro archivo -->
                    <div class="d-flex justify-content-center">
                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                            <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off"
                                checked>
                            <label class="btn btn-outline-primary" for="btnradio1">URL</label>

                            <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
                            <label class="btn btn-outline-primary" for="btnradio2">File</label>
                        </div>
                    </div>
                    <div style="margin-bottom: 1.6rem; width: 100%;" id="destinationContainer">
                        <label for="link" class="form-label">Destination</label>
                        <input type="domain" class="form-control" id="link" name="domain" placeholder="https://example.com">
                        <div id="elfinder" class="hidden" name="domain"></div>
                    </div>
                    <div style="margin-bottom: 1.6rem; width: 100%;" id="div_title">
                        <label for="createnew_title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="createnew_title" name="title" required>
                    </div>
                    <div style="margin-bottom: 1.6rem; width: 100%;">
                        <label for="createnew_description" class="form-label">Description (optional) <small><a
                                    class="text-dark" href="https://ckeditor.com">Ballon Editor</a></small></label>
                        <p class="form-control" id="createnew_description" name="description"
                            style="border: 1px solid lightgray; border-radius: 5px"></p>

                    </div>
                    <!-- Futuramente google analytics -->
                    <hr>
                    <h1 class="custom_font" style="font-size: 1.8rem; line-height: 3.6rem;">Ways to share</h1>
                    <span class="custom_font" style="font-size: 1.4rem; line-height: 2.8rem; display: block;">Short
                        Link</span>
                    <div
                        style="display:flex; justify-content: space-between align-items: flex-start; margin-bottom: 1.6rem;">
                        <div style="display:flex; flex-direction:column;">
                            <span>Domain <i class="bi bi-lock-fill"></i></span>
                            <select class="form-select" aria-label="Default select example" disabled style="width: 27.5rem">
                                <option selected disabled>https://dawly.com</option>
                            </select>
                        </div>
                        <div style="display:flex; flex-direction:column;" class="text-center">
                            <div style="width: 10rem"> </div>
                            <span style="font-size: 1.4rem; line-height: 2.8rem; display: block; width: 15rem"> / </span>
                        </div>
                        <div style="display:flex; flex-direction:column;">
                            <span>Custom URL</span>
                            <input type="text" class="form-control" id="custom_url" name="custom_url" style="width: 30rem">
                        </div>
                    </div>
                    <hr>
                    <h1 class="custom_font" style="font-size: 1.8rem; line-height: 3.6rem;">Advanced</h1>
                    <span class="custom_font" style="font-size: 1.2rem; line-height: 2.8rem; display: block;">Time Limit</span>
                    <div
                        style="display:flex; justify-content: space-between align-items: flex-start; margin-bottom: 1.6rem;">
                        <div style="display:flex; flex-direction:column;">
                            <span>Publish Date</span>
                            <input type="datetime-local" class="form-control" id="publish_date" name="publish_date"
                                style="width: 27.5rem" value="<?= date('Y-m-d\TH:i') ?>">
                        </div>
                        <div style="display:flex; flex-direction:column;" class="text-center">
                            <div style="width: 10rem"> </div>
                            <span style="font-size: 1.4rem; line-height: 2.8rem; display: block; width: 15rem"> / </span>
                        </div>
                        <div style="display:flex; flex-direction:column;">
                            <span>Limit Date</span>
                            <!-- 1 month -->
                            <input type="datetime-local" class="form-control" id="limit_date" name="limit_date"
                                style="width: 30rem" value="<?= date('Y-m-d\TH:i', strtotime('+1 month')) ?>">
                        </div>
                    </div>
                </form>
            </div>
        </div>

    <?php elseif ($setActive == 'links'): ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-start custom_font" style="padding: 3.4rem 2.4rem 0 15.4rem">Links</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div style="height: 1.6rem"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <form action="<?= base_url('show_link') ?>" method="get">
                        <ul class="nav flex-column" style="padding: 0 2.4rem 0 14.4rem;">
                            <?php foreach($links as $key => $link): ?>
                                <li class="nav-item mb-3">
                                    <button type="submit" class="btn" name="link_code" value="<?= $link['link_code'] ?>">
                                        <div class="card" style="width: 90rem; height: 10rem">
                                            <div class="card-body">
                                                <span class="badge bg-secondary" name="link_code" style="font-size: 0.8rem; line-height: 0.8rem; padding: 0.4rem 0.8rem;"><?= $link['link_code'] ?></span>  
                                                <h5 class="card-title"><?= $link['title'] ?></h5>
                                                <p class="card-text"><?= date('M d', strtotime($link['publish_date'])) ?></p>
                                            </div>
                                        </div>
                                    </button>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </form>
                </div>
            </div>
        </div>
    <?php elseif ($setActive == 'administration'): ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-start custom_font" style="padding: 3.4rem 2.4rem 0 15.4rem">Users</h1>
                </div>
            </div>
            <?php if (isset($kpaUsers)): ?>
                <?= $kpaUsers ?>
            <?php endif; ?>
            <div class="row">
                <div class="col-12">
                    <div style="height: 1.6rem;"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h1 class="text-start custom_font" style="padding: 3.4rem 2.4rem 0 15.4rem">Roles</h1>
                </div>
            </div>
            <?php if (isset($kpaRoles)): ?>
                <?= $kpaRoles ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>


<!-- Modal linkModal -->
<div class="modal fade" id="linkModal" tabindex="-1" aria-labelledby="linkModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="linkModalLabel">Detalles del enlace</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex justify-content-center flex-lg-column">
                <div class="row">
                    <button type="button" class="btn btn-outline-info" id="editButton"><i class="bi bi-pen-fill"></i> Editar</button>
                    <form action="<?= base_url('delete') ?>" method="post" class="d-flex flex-column">
                        <?= csrf_field() ?>
                        <?php if (isset($linkdata)): ?>
                            <button type="submit" class="btn btn-outline-danger text-center"><i class="bi bi-trash-fill"></i> Eliminar</button>
                            <input type="hidden" class="hide" name="link_code" value="<?= $linkdata['link_code'] ?>">
                        <?php endif; ?>
                    </form>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div style="height: 1.6rem"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th scope="col">Link</th>
                                    <th scope="col">Código</th>
                                    <th scope="col">Fecha de publicación</th>
                                    <th scope="col">Fecha límite</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php if (isset($linkdata)): ?>
                                        <td><a href="<?= $linkdata['link'] ?>"><?= $linkdata['link'] ?></a></td>
                                        <td><?= $linkdata['link_code'] ?></td>
                                        <td><?= date('d M Y', strtotime($linkdata['publish_date'])) ?></td>
                                        <td><?= date('d M Y', strtotime($linkdata['limit_date'])) ?></td>
                                    <?php else: ?>
                                        <td>No hay data</td>
                                    <?php endif; ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col-12">
                        <div class="canvas-container">
                            <canvas id="chart"></canvas>
                            <div id="chartDate">
                                <?php if (isset($linkdata)): ?>
                                    <span><?= date('M d', strtotime($linkdata['publish_date'])) ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<?php $this->endSection() ?>

<?php $this->section('scripts') ?>
    <script src="<?=base_url('assets/js/ckeditor/ckeditor.js')?>"></script>
    <script>
        setActive = '<?= $setActive ?>';
        document.querySelectorAll('.nav-link').forEach((e) => {
            e.classList.remove('active');
        });
        if (setActive) {
            document.getElementById(setActive).classList.add('active');
        }

        window.addEventListener("load", (e) => {
            if (document.querySelector('#createnew_description')) {
                BalloonEditor.create(document.querySelector('#createnew_description')).then(editor => {
                    console.log("CKEditor Balloon Editor created");
                });
            }
            $('#elfinder').hide();
        })

        let short_url = '<?= session()->get('short_url') ?>';
        if (short_url) {
            Swal.fire({
                icon: 'success',
                title: 'Short URL created',
                text: "<?php echo session()->get('short_url');
                session()->remove('short_url'); ?>",
                footer: '<a href="<?= base_url('dashboard') ?>">Go to dashboard</a>'
            })
        }

        $(document).ready(function() {
            <?php if ($linkdata): ?>
                $('#linkModal').modal('show');
            <?php endif; ?>
        
        });

        // Datos del gráfico
        <?php if (isset($linkdata)): ?>
            var linkVisitsData = <?= json_encode($linkdata['linkVisits']) ?>;
            var chartDate = '<?= date('M d', strtotime($linkdata['publish_date'])) ?>';
        <?php else: ?>
            var linkVisitsData = [];
            var chartDate = '';
        <?php endif; ?>

        // Configuración del gráfico
        var chartConfig = {
            type: 'bar',
            data: {
                labels: linkVisitsData.map(function (visit) {
                    return visit.date;
                }),
                datasets: [{
                    label: 'Visitas',
                    data: linkVisitsData.map(function (visit) {
                        return visit.clicks;
                    }),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        max: Math.max.apply(Math, linkVisitsData.map(function (visit) {
                            return visit.clicks;
                        })) + 10
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        };

        // Crear el gráfico
        var ctx = document.getElementById('chart').getContext('2d');
        var myChart = new Chart(ctx, chartConfig);
        // Actualizar el texto de la fecha en el gráfico
        document.getElementById('chartDate').innerHTML = '<span>' + chartDate + '</span>';

        // Obtener el botón de edición
        var editButton = document.getElementById('editButton');

        // Agregar un event listener al botón de edición
        editButton.addEventListener('click', function() {
            // Obtener el elemento td de la tabla
            var tdElement = document.querySelector('table tbody tr td');
            var link = tdElement.textContent;
            var code = tdElement.nextElementSibling.textContent;
            var publish_date = tdElement.nextElementSibling.nextElementSibling.textContent;
            var limit_date = tdElement.nextElementSibling.nextElementSibling.nextElementSibling.textContent;

            // crear un input element
            var inputElement = document.createElement('input');
            inputElement.setAttribute('type', 'text');
            inputElement.setAttribute('value', link);
            tdElement.innerHTML = '';
            tdElement.appendChild(inputElement);

            var inputElement2 = document.createElement('input');
            inputElement2.setAttribute('type', 'text');
            inputElement2.setAttribute('value', code);
            tdElement.nextElementSibling.innerHTML = '';
            tdElement.nextElementSibling.appendChild(inputElement2);

            var inputElement3 = document.createElement('input');
            inputElement3.setAttribute('type', 'text');
            inputElement3.setAttribute('value', publish_date);
            tdElement.nextElementSibling.nextElementSibling.innerHTML = '';
            tdElement.nextElementSibling.nextElementSibling.appendChild(inputElement3);

            var inputElement4 = document.createElement('input');
            inputElement4.setAttribute('type', 'text');
            inputElement4.setAttribute('value', limit_date);
            tdElement.nextElementSibling.nextElementSibling.nextElementSibling.innerHTML = '';
            tdElement.nextElementSibling.nextElementSibling.nextElementSibling.appendChild(inputElement4);


            // Crear un botón de confirmación
            var confirmButton = document.createElement('button');
            confirmButton.setAttribute('type', 'button');
            confirmButton.setAttribute('class', 'btn btn-primary');
            confirmButton.textContent = 'Confirmar';

            // Agregar un event listener al botón de confirmación
            confirmButton.addEventListener('click', function() {
                // Obtener el valor del input
                var inputValue = inputElement.value;

                // Crear un nuevo elemento td con el valor del input
                var newTdElement = document.createElement('td');
                newTdElement.textContent = inputValue;

                // Reemplazar el input element con el nuevo td
                tdElement.innerHTML = '';
                tdElement.appendChild(newTdElement);

                // Eliminar el botón de confirmación
                confirmButton.parentNode.removeChild(confirmButton);

                <?php if (isset($linkdata)): ?>
                    $.ajax({
                        url: '<?= base_url('dashboard/updateLink') ?>',
                        type: 'POST',
                        data: {
                            link: inputValue,
                            code: inputElement2.value,
                            publish_date: inputElement3.value,
                            limit_date: inputElement4.value,
                            id: <?= $linkdata['id'] ?>
                            <?php csrf_field() ?>
                        },
                        success: function(data) {
                            console.log(data);
                        }
                    });
                <?php endif; ?>
            });

            // Crear un div para contener el botón de confirmación
            var buttonContainer = document.createElement('div');
            buttonContainer.appendChild(confirmButton);

            // Agregar el div con el botón de confirmación debajo de la tabla
            var tableElement = document.querySelector('table');
            tableElement.parentNode.insertBefore(buttonContainer, tableElement.nextSibling);
        });

        $('#deleteButton').on('click', function(e) {
            e.preventDefault(); // Evitar que el formulario se envíe

            if (confirm('¿Estás seguro de que deseas eliminar este enlace?')) {
                $('#deleteForm').submit();
            }
        });


        $('#linkModal').on('hidden.bs.modal', function (e) {
            window.location.href = '<?= base_url('manage') ?>';
        })

        $('#btnradio1').on('click', function() {
            $('#div_title').css('margin-top', '0');
            $('#link').attr('placeholder', 'https://www.example.com');
            $('#elfinder').hide();
        });
        
        $('#btnradio2').on('click', function() {
            $('#elfinder').show();
            $('#div_title').css('margin-top', '6rem');
            $('#link').attr('placeholder', 'Put here the name of document (example.png)');
        });

    </script>
<?= $this->endSection() ?>

<?php $this->section('scripts') ?>
<!-- Require JS (REQUIRED) -->
<script src="//cdnjs.cloudflare.com/ajax/libs/require.js/2.3.2/require.min.js"></script>
<script>
    define('elFinderConfig', {
        // elFinder options (REQUIRED)
        // Documentation for client options:
        // https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
        defaultOpts: {
            <?php if (isset($connector)): ?>
                url: '<?php echo $connector ?>', // connector URL (REQUIRED)
            <?php endif; ?>
            commandsOptions: {
                edit: {
                    extraOptions: {
                        // set API key to enable Creative Cloud image editor
                        // see https://console.adobe.io/
                        creativeCloudApiKey: '',
                        // browsing manager URL for CKEditor, TinyMCE
                        // uses self location with the empty value
                        managerUrl: ''
                    }
                },
                quicklook: {
                    // to enable preview with Google Docs Viewer
                    googleDocsMimes: ['application/pdf', 'image/tiff', 'application/vnd.ms-office', 'application/msword', 'application/vnd.ms-word', 'application/vnd.ms-excel', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']
                }
            }
            // bootCalback calls at before elFinder boot up
            ,
            bootCallback: function(fm, extraObj) {
                /* any bind functions etc. */
                fm.bind('init', function() {
                    // any your code
                });
                // for example set document.title dynamically.
                var title = document.title;
                fm.bind('open', function() {
                    var path = '',
                        cwd = fm.cwd();
                    if (cwd) {
                        path = fm.path(cwd.hash) || null;
                    }
                    document.title = path ? path + ':' + title : title;
                }).bind('destroy', function() {
                    document.title = title;
                });
            }
        },
        managers: {
            // 'DOM Element ID': { /* elFinder options of this DOM Element */ }
            'elfinder': {}
        }
    });
    define('returnVoid', void 0);
    (function() {
        var // elFinder version
            elver = '<?php echo elFinder::getApiFullVersion() ?>',
            // jQuery and jQueryUI version
            jqver = '3.2.1',
            uiver = '1.12.1',

            // Detect language (optional)
            lang = (function() {
                var locq = window.location.search,
                    fullLang, locm, lang;
                if (locq && (locm = locq.match(/lang=([a-zA-Z_-]+)/))) {
                    // detection by url query (?lang=xx)
                    fullLang = locm[1];
                } else {
                    // detection by browser language
                    fullLang = (navigator.browserLanguage || navigator.language || navigator.userLanguage);
                }
                lang = fullLang.substr(0, 2);
                if (lang === 'ja') lang = 'jp';
                else if (lang === 'pt') lang = 'pt_BR';
                else if (lang === 'ug') lang = 'ug_CN';
                else if (lang === 'zh') lang = (fullLang.substr(0, 5).toLowerCase() === 'zh-tw') ? 'zh_TW' : 'zh_CN';
                return lang;
            })(),

            // Start elFinder (REQUIRED)
            start = function(elFinder, editors, config) {
                // load jQueryUI CSS
                elFinder.prototype.loadCss('//cdnjs.cloudflare.com/ajax/libs/jqueryui/' + uiver + '/themes/smoothness/jquery-ui.css');

                $(function() {
                    var optEditors = {
                            commandsOptions: {
                                edit: {
                                    editors: Array.isArray(editors) ? editors : []
                                }
                            }
                        },
                        opts = {};

                    // Interpretation of "elFinderConfig"
                    if (config && config.managers) {
                        $.each(config.managers, function(id, mOpts) {
                            opts = Object.assign(opts, config.defaultOpts || {});
                            // editors marges to opts.commandOptions.edit
                            try {
                                mOpts.commandsOptions.edit.editors = mOpts.commandsOptions.edit.editors.concat(editors || []);
                            } catch (e) {
                                Object.assign(mOpts, optEditors);
                            }
                            // Make elFinder
                            $('#' + id).elfinder(
                                // 1st Arg - options
                                $.extend(true, {
                                    lang: lang
                                }, opts, mOpts || {}),
                                // 2nd Arg - before boot up function
                                function(fm, extraObj) {
                                    // `init` event callback function
                                    fm.bind('init', function() {
                                        // Optional for Japanese decoder "extras/encoding-japanese.min"
                                        delete fm.options.rawStringDecoder;
                                        if (fm.lang === 'jp') {
                                            require(
                                                ['encoding-japanese'],
                                                function(Encoding) {
                                                    if (Encoding.convert) {
                                                        fm.options.rawStringDecoder = function(s) {
                                                            return Encoding.convert(s, {
                                                                to: 'UNICODE',
                                                                type: 'string'
                                                            });
                                                        };
                                                    }
                                                }
                                            );
                                        }
                                    });
                                }
                            );
                        });
                    } else {
                        alert('"elFinderConfig" object is wrong.');
                    }
                });
            },

            // JavaScript loader (REQUIRED)
            load = function() {
                require(
                    [
                        'elfinder', 'extras/editors.default' // load text, image editors
                        , 'elFinderConfig'
                        //  , 'extras/quicklook.googledocs'  // optional preview for GoogleApps contents on the GoogleDrive volume
                    ],
                    start,
                    function(error) {
                        alert(error.message);
                    }
                );
            },

            // is IE8? for determine the jQuery version to use (optional)
            ie8 = (typeof window.addEventListener === 'undefined' && typeof document.getElementsByClassName === 'undefined');

        // config of RequireJS (REQUIRED)
        require.config({
            baseUrl: '//cdnjs.cloudflare.com/ajax/libs/elfinder/' + elver + '/js',
            paths: {
                'jquery': '//cdnjs.cloudflare.com/ajax/libs/jquery/' + (ie8 ? '1.12.4' : jqver) + '/jquery.min',
                'jquery-ui': '//cdnjs.cloudflare.com/ajax/libs/jqueryui/' + uiver + '/jquery-ui.min',
                'elfinder': 'elfinder.min',
                'encoding-japanese': '//cdn.rawgit.com/polygonplanet/encoding.js/master/encoding.min'
            },
            waitSeconds: 10 // optional
        });

        // load JavaScripts (REQUIRED)
        load();

    })();

    let selectedFiles = elfinder.selectedFiles();
    console.log(selectedFiles);
</script>
<?= $this->endSection() ?>