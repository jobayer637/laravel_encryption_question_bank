@extends('custom_layouts.admin.app')

@push('css')
<style>
    .ques_name p{
        float: left;
        margin-bottom: 0px;
        padding-bottom: 0px;
        font-weight: 600;
    }
</style>
@endpush

@section('current-page')
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb d-flex justify-content-between">
        <li class="breadcrumb-item active">{{ $subject->name }} &nbsp; <strong class="text-dark">Click to Download button <i class="fas fa-arrow-circle-right"></i></strong></li>
        <button class="btn btn-danger rounded-0 px-5" id="create_pdf">DOWNLOAD PDF <i class="fas fa-file-download"></i></button>
    </ul>
</div>
@endsection

@section('main-content')
    @php
        use App\Helper as RSA;
        use App\Key;
        $key = Key::where('user_id', 1)->first();
        $rsa = new RSA\Encryption($key->private_key, $key->public_key);
    @endphp


    <div class="card pdfStyle makePDF" style="opacity: .001;">
        <div class="card-header text-center">
            <p>MCQ Question</p>
            <p data-name="{{ $subject->name }}" id="subjectName">{{ $subject->name }}</p>
            <p>Time: 30 mins</p>
            <p>Marks: 30</p>
        </div>
        <div class="card-body ">
            <div class="row">
                @foreach ($subject->questions as $key => $question)
                    <div class="col-md-6 mb-3">
                        <div class="row">
                                <ul class="list-group">

                                    <div class="ques_name">
                                        <strong style="float: left;">{{ $key+1 }}. &nbsp;&nbsp;</strong>
                                        {!! $rsa->privDecrypt($question->question) !!}
                                    </div>

                                    <li class="list-group-item text-capitalize border-0 py-1">
                                    <span style="border: 1px solid black; border-radius:50%; width:19px; text-align: center; font-size: 12px;">A</span>
                                    &nbsp; {{ $rsa->privDecrypt($question->option1) }}</li>
                                    <li class="list-group-item text-capitalize py-1 border-0">
                                    <span style="border: 1px solid black; border-radius:50%; width:19px; text-align: center; font-size: 12px;">B</span>
                                    &nbsp; {{ $rsa->privDecrypt($question->option2) }}</li>
                                    <li class="list-group-item text-capitalize py-1 border-0">
                                    <span style="border: 1px solid black; border-radius:50%; width:19px; text-align: center; font-size: 12px;">C</span>
                                    &nbsp; {{ $rsa->privDecrypt($question->option3) }}</li>
                                    <li class="list-group-item text-capitalize py-1 border-0">
                                    <span style="border: 1px solid black; border-radius:50%; width:19px; text-align: center; font-size: 12px;">D</span>
                                    &nbsp; {{ $rsa->privDecrypt($question->option4) }}</li>
                                </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection


@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
<script>
    (function ($) {
        $.fn.html2canvas = function (options) {
            var date = new Date(),
            $message = null,
            timeoutTimer = false,
            timer = date.getTime();
            html2canvas.logging = options && options.logging;
            html2canvas.Preload(this[0], $.extend({
                complete: function (images) {
                    var queue = html2canvas.Parse(this[0], images, options),
                    $canvas = $(html2canvas.Renderer(queue, options)),
                    finishTime = new Date();

                    $canvas.css({ position: 'absolute', left: 0, top: 0 }).appendTo(document.body);
                    $canvas.siblings().toggle();

                    $(window).click(function () {
                        if (!$canvas.is(':visible')) {
                            $canvas.toggle().siblings().toggle();
                            throwMessage("Canvas Render visible");
                        } else {
                            $canvas.siblings().toggle();
                            $canvas.toggle();
                            throwMessage("Canvas Render hidden");
                        }
                    });
                    throwMessage('Screenshot created in ' + ((finishTime.getTime() - timer) / 1000) + " seconds<br />", 4000);
                }
            }, options));

            function throwMessage(msg, duration) {
                window.clearTimeout(timeoutTimer);
                timeoutTimer = window.setTimeout(function () {
                    $message.fadeOut(function () {
                        $message.remove();
                    });
                }, duration || 2000);
                if ($message)
                    $message.remove();
                $message = $('<div ></div>').html(msg).css({
                    margin: 0,
                    padding: 5,
                    background: "#000",
                    opacity: 1,
                    position: "fixed",
                    top: 10,
                    right: 10,
                    fontFamily: 'Tahoma',
                    color: '#fff',
                    fontSize: 11,
                    borderRadius: 12,
                    width: 'auto',
                    height: 'auto',
                    textAlign: 'center',
                    textDecoration: 'none'
                }).hide().fadeIn().appendTo('body');
            }
        };
    })(jQuery);
</script>

<script>
    (function () {
        var form = $('.makePDF'),
         cache_width = form.width(),
         a4 = [595.28, 841.89]; // for a4 size paper width and height
         var subjectId = $("#subjectName").data('name')

        $('#create_pdf').on('click', function () {
            $('body').scrollTop(0);
            createPDF();
        });
        //create pdf
        function createPDF() {
            getCanvas().then(function (canvas) {
                var
                 img = canvas.toDataURL("image/png"),
                 doc = new jsPDF({
                     unit: 'px',
                     format: 'a4'
                 });
                doc.addImage(img, 'JPEG', 20, 20);
                doc.save(subjectId+'_question.pdf');
                form.width(cache_width);
            });
        }

        // create canvas object
        function getCanvas() {
            form.width((a4[0] * 1.33333) - 80).css('max-width', 'none');
            return html2canvas(form, {
                imageTimeout: 2000,
                removeContainer: true
            });
        }

    }());
</script>
@endpush
