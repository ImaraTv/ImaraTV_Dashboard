<?php
//dd($proposal_id, $collection, $creatorProposal);
?>
<div class="row justify-content-center">
    <div class="col-xl-8">
        @if (session('upload-success'))
            <div class="p-4 mt-5 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400">
                {{ session('upload-success') }}
            </div>
        @endif
        <form class="required-form" action="<?= action([\App\Http\Controllers\UploadController::class, 'saveFile']); ?>"
              method="post" enctype="multipart/form-data">
            <div class="card w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <div class="p-3 flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200 rounded-t-lg bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                    <h3 class="mb-3 text-2xl font-extrabold tracking-tight text-gray-900 dark:text-white">Upload {{$collection_title}} for [{{$creatorProposal->working_title}}]</h3>
                </div>
                <div class="card-body p-3">
                    @if(!empty($creatorProposal))
                        <input type="hidden" name="film_project" id="film_project" value="{{ $creatorProposal->id }}" required>
                    @else
                        <div class="form-group row mb-3">
                            <label for="films" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select a Film Proposal<span class="required">*</span></label>
                            <select id="film_project" name="film_project" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>

                                <option>- Select Film -</option>
                                    <?php
                                    $projects = \App\Models\CreatorProposal::all();
                                    foreach($projects as $k => $project) {
                                        echo "<option value='".$project->id ."'> " .$project->working_title ."</option>";
                                    }
                                    ?>
                            </select>
                        </div>
                    @endif
                    @if(!empty($collection))
                        <input type="hidden" name="collection" id="collection" value="{{$collection}}">
                    @else
                        <div class="form-group row mb-3">
                            <label class="col-md-2 col-form-label" for="title">
                                Media Type
                                <span class="required">*</span>
                            </label>
                            <select id="collection" name="collection" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                <option value="videos">HD Video</option>
                                <option value="trailers">Trailer</option>
                            </select>
                        </div>
                    @endif

                    <input type="hidden" name="path" id="media_path" value="" required>
                    <input type="hidden" name="name" id="media_name" value="" required>
                    <input type="hidden" name="size" id="media_size" value="">
                    <input type="hidden" name="type" id="media_type" value="">
                    @csrf

                    <div>
                        <div id="filelist" style="display: none" class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">Your browser doesn't have Flash, Silverlight or HTML5 support.</div>
                        <div class="progress mb-2 w-full bg-gray-200 rounded-full dark:bg-gray-700">
                            <div id="uploadProgress" class="progress-bar bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="form-group">
                            <input type="file" id="tus-file-picker"></div>
                        <div id="container" style="display: none">
                            <a id="uploadFile" name="uploadFile" href="javascript:;" class="text-white bg-blue-700 hover:bg-blue-800 text-center mr-3 px-5 py-2.5">Select file</a>
                            <a id="upload" href="javascript:;" class="text-white bg-green-700 hover:bg-green-800 text-center px-5 py-2.5">Upload file</a>
                        </div>
                        <input type="hidden" id="file_ext" name="file_ext" value="<?= substr( md5( rand(10,100) ) , 0 ,10 )?>">
                        <div id="console" class="p-4 mb-4 mt-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert"></div>
                    </div>
                    <div id="saveButton" style="display: none">
                        <p class="p-4 mt-5 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400">After the file is uploaded 100%, click button below to save the media</p>
                        <div class="mb-3 mt-2">
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 text-center px-5 py-2.5">
                                Save
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!--<script src="<?= asset('js/plupload/plupload.full.min.js'); ?>"></script> -->
<script src="https://cdn.jsdelivr.net/npm/tus-js-client@latest/dist/tus.min.js"></script>
<script>
    $('#tus-file-picker').on('change', function (e) {
        var storage_path = '<?= storage_path('video-uploads') ?>';
        // Get the selected file from the input element
        var file = e.target.files[0]

        // Create a new tus upload
        var upload = new tus.Upload(file, {
            headers: {
                'X-CSRF-TOKEN': '<?= csrf_token() ?>'
            },
            // Endpoint is the upload creation URL from your tus server
            endpoint: '<?= url('/tus/files') ?>',
            // Retry delays will enable tus-js-client to automatically retry on errors
            retryDelays: [0, 3000, 5000],
            // Attach additional meta data about the file for the server
            metadata: {
                filename: file.name,
                filetype: file.type,
            },
            chunkSize: 10 * 1024 * 1024,
            //parallelUploads: 10,
            // Callback for errors which cannot be fixed using retries
            onError: function (error) {
                console.log('Failed because: ' + error)
                document.getElementById('console').innerHTML += "\nError: " + error;
            },
            // Callback for reporting upload progress
            onProgress: function (bytesUploaded, bytesTotal) {
                var percentage = ((bytesUploaded / bytesTotal) * 100).toFixed(2)
                console.log(bytesUploaded, bytesTotal, percentage + '%')
                //document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span class="label">' + file.percent + "%</span>";
                $('#uploadProgress').css("width", percentage < 10 ? 10 + "%" : percentage + "%").text(percentage + " %");
            },
            // Callback for once the upload is completed
            onSuccess: function () {
                console.log(upload)
                console.log('Download %s from %s', upload.file.name, upload.url)
                //$('#media_url').val(response.url);
                $('#media_path').val(storage_path + '/' + upload.file.name);
                $('#media_size').val(upload.file.size);
                $('#media_name').val(upload.file.name);
                $('#media_type').val(upload.file.type);
                // show save button
                $('#saveButton').show();
                $('#container').hide();
            },
        })

        // Check if there are any previous uploads to continue.
        upload.findPreviousUploads().then(function (previousUploads) {
            // Found previous uploads so we select the first one.
            if (previousUploads.length) {
                upload.resumeFromPreviousUpload(previousUploads[0])
            }

            // Start the upload
            upload.start()
        })
    })

</script>
<script>

</script>

