<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?=$title?></title>
        <link href="https://fonts.cdnfonts.com/css/circular-std" rel="stylesheet">
        <link href="https://fonts.cdnfonts.com/css/proxima-nova-2" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.2.1/chart.min.js" integrity="sha512-v3ygConQmvH0QehvQa6gSvTE2VdBZ6wkLOlmK7Mcy2mZ0ZF9saNbbk19QeaoTHdWIEiTlWmrwAL4hS8ElnGFbA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.min.css" integrity="sha512-SbiR/eusphKoMVVXysTKG/7VseWii+Y3FdHrt0EpKgpToZeemhqHeZeLWLhJutz/2ut2Vw1uQEj2MbRF+TVBUA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" integrity="sha512-YFENbnqHbCRmJt5d+9lHimyEMt8LKSNTMLSaHjvsclnZGICeY/0KYEeiHwD1Ux4Tcao0h60tdcMv+0GljvWyHg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.7.3/sweetalert2.min.css" integrity="sha512-NvuRGlPf6cHpxQqBGnPe7fPoACpyrjhlSNeXVUY7BZAj1nNhuNpRBq3osC4yr2vswUEuHq2HtCsY2vfLNCndYA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="<?= base_url('assets/css/style.css')?>">
        <link rel="stylesheet" href="<?= base_url('assets/css/sidebars.css')?>">
        <?= $this->renderSection('style') ?>
        <?= $this->renderSection('cdnHeaders') ?>
    </head>
    <body>
        <?= $this->renderSection('cdnBody') ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.7.3/sweetalert2.all.min.js" integrity="sha512-/iBgV43zPirSC0tue+PT/1VHGs7En24twBmT+sVMgn9PTaOpKfbgIyL5YsGKlbAIxcwz9S8W/YEnYjpIYj2Axw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        
        <?= view('templates/navbar')?>
        <?= $this->renderSection('content')?>
        <?= view('templates/footer')?>
           
        
        <?= $this->renderSection('scripts') ?>
        <script src="<?= base_url('assets/js/sidebars.js')?>"></script>
        <script src="<?=base_url('assets/js/ckeditor/ckeditor.js')?>"></script>
    </body>
</html>