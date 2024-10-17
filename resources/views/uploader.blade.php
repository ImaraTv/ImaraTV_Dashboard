<div class="row justify-content-center">
    <div class="col-xl-8">
        @if (session('upload-success'))
            <div class="p-4 mt-5 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400">
                {{ session('upload-success') }}
            </div>
        @endif
        <form class="required-form" action="<?= action([\App\Http\Controllers\UploadController::class, 'saveFile']); ?>"
              method="post" enctype="multipart/form-data">
            <div class="card cta-box">
                <div class="card-body">
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
                    <input type="hidden" name="url" id="media_url" value="" required>
                    <input type="hidden" name="path" id="media_path" value="" required>
                    <input type="hidden" name="size" id="media_size" value="">
                    <input type="hidden" name="name" id="media_name" value="" required>
                    <input type="hidden" name="type" id="media_type" value="">
                    @csrf

                    <div>
                        <p>Select & Upload Media file</p>

                        <div id="filelist" class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">Your browser doesn't have Flash, Silverlight or HTML5 support.</div>
                        <div class="progress mb-2 w-full bg-gray-200 rounded-full dark:bg-gray-700">
                            <div id="uploadProgress" class="progress-bar bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div id="container">
                            <div class="form-group">
                                <a id="uploadFile" name="uploadFile" href="javascript:;" class="text-white bg-blue-700 hover:bg-blue-800 text-center mr-3 px-5 py-2.5">Select file</a>
                                <a id="upload" href="javascript:;" class="text-white bg-green-700 hover:bg-green-800 text-center px-5 py-2.5">Upload file</a>
                            </div>

                        </div>
                        <input type="hidden" id="file_ext" name="file_ext" value="<?= substr( md5( rand(10,100) ) , 0 ,10 )?>">
                        <div id="console" class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert"></div>
                    </div>
                    <div id="saveButton" style="display: none">
                        <p class="p-4 mt-5 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400">After the file is uploaded 100%, click button below to save the media</p>
                        <div class="mb-3 mt-2">
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 text-center px-5 py-2.5">
                                Save Media to Film Project
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="<?= asset('js/plupload/plupload.full.min.js'); ?>"></script>
<script>
    var uploader = new plupload.Uploader({
        runtimes : 'html5',
        browse_button : 'uploadFile', // you can pass in id...
        container: document.getElementById('container'), // ... or DOM Element itself
        chunk_size: '1mb',
        url : '<?= action([\App\Http\Controllers\UploadController::class, 'uploadFile']) ?>',
        max_file_count: 1,
        max_file_size: 0,
        unique_names: true,
        multipart_params: {
            _token: '<?= csrf_token() ?>'
        },

        //ADD FILE FILTERS HERE
        filters : {
            mime_types: [
                {title : "Video files", extensions : "mp4,mov,mpeg,mpg,avi,mkv,mts,3gp,m4v,webm"},
                {title : "Document files", extensions : "doc,pdf,docx,dot,ppt,pptx"},
                {title : "Image files", extensions : "jpg,jpeg,png,gif"},
            ]
        },

        // Flash settings
        flash_swf_url : '<?= asset('js/plupload/Moxie.swf'); ?>',

        // Silverlight settings
        silverlight_xap_url : '<?= asset('js/plupload/Moxie.xap'); ?>',

        init: {
            PostInit: function() {
                document.getElementById('filelist').innerHTML = '';
                document.getElementById('upload').onclick = function() {
                    uploader.start();
                    return false;
                };
            },

            FilesAdded: function(up, files) {
                plupload.each(files, function(file) {
                    document.getElementById('filelist').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
                });
            },

            UploadProgress: function(up, file) {
                document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span class="label">' + file.percent + "%</span>";
                $('#uploadProgress').css("width", file.percent + "%").text(file.percent + " %");
            },

            FileUploaded: function (up, file, object) {
                console.log(up,file, object);
                // save media to database
                var response = JSON.parse(object.response);
                if (response.success) {
                    $('#media_url').val(response.url);
                    $('#media_path').val(response.file);
                    $('#media_size').val(file.size);
                    $('#media_name').val(file.name);
                    $('#media_type').val(file.type);
                    // show save button
                    $('#saveButton').show();
                    $('#container').hide();
                }
            },

            Error: function(up, err) {
                document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
            }
        }
    });

    uploader.init();
</script>

