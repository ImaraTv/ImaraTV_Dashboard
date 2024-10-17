<?php

namespace App\Http\Controllers;

use App\Models\CreatorProposal;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Monolog\Logger;

class UploadController extends Controller
{
    public function create(Request $request)
    {
        return view('uploader');
    }
    public function saveFile(Request $request)
    {
        $form_fields = ['film_project', 'collection', 'path', 'url', 'size', 'name', 'type', 'file_ext'];
        $data = $request->only($form_fields);
        $creatorProposal = CreatorProposal::find($data['film_project']);
        //dd($data, $creatorProposal);
        $media = $creatorProposal->addMedia($data['path'])->toMediaCollection($data['collection']);
        //dd($media);
        if ($media) {
            $output = [
                'success' => true,
                'msg' => 'File successfully uploaded and attached to ' . $creatorProposal->working_title,
            ];
            return redirect('file-uploader')->with('upload-success', $output['msg']);
        }

    }
    public function uploadFile(Request $request)
    {
        // 5 minutes execution time
        @set_time_limit(5 * 60);

        $targetDir = storage_path('video-uploads');
        $cleanupTargetDir = true; // Remove old files
        $maxFileAge = 5 * 3600; // Temp file age in seconds

        // Create target dir
        if (!file_exists($targetDir)) {
            @mkdir($targetDir);
        }

        // Get a file name
        if (isset($_REQUEST["name"])) {
            $fileName = $_REQUEST["name"];
        } elseif (!empty($_FILES)) {
            $fileName = $_FILES["file"]["name"];
        } else {
            $fileName = uniqid("file_");
        }
        $originalFileName = $fileName;
        //$newFileName = random_string('alnum', 16);
        $filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
        //$newFilePath = $targetDir . DIRECTORY_SEPARATOR . $newFileName;
        $fileURL = storage_path('video-uploads/'. $fileName);
        //$newFileURL = storage_path('video-uploads/'. $newFileName);

        // Chunking might be enabled
        $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
        $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;


        // Remove old temp files
        if ($cleanupTargetDir) {
            if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
            }

            while (($file = readdir($dir)) !== false) {
                $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

                // If temp file is current file proceed to the next
                if ($tmpfilePath == "{$filePath}.part") {
                    continue;
                }

                // Remove temp file if it is older than the max age and is not the current file
                if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge)) {
                    @unlink($tmpfilePath);
                }
            }
            closedir($dir);
        }

        // Open temp file
        if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
            die('{"error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
        }

        if (!empty($_FILES)) {
            if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
                die('{"error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
            }

            // Read binary input stream and append it to temp file
            if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
                die('{"error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
            }
        } else {
            if (!$in = @fopen("php://input", "rb")) {
                die('{"error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
            }
        }

        while ($buff = fread($in, 4096)) {
            fwrite($out, $buff);
        }

        @fclose($out);
        @fclose($in);

        $success = [
            'success' => true,
            'file' => $filePath,
            'url' => $fileURL,
            'original_filename' => $originalFileName,
        ];

        // Check if file has been uploaded
        if (!$chunks || $chunk == $chunks - 1) {
            //$extension = strtolower(substr(strrchr($originalFileName, '.'), 1));
            //$newFileName = Str::random(16) . '.' . $extension;
            $newFilePath = $targetDir . DIRECTORY_SEPARATOR . $originalFileName;
            $newFileURL = storage_path('video-uploads/'. $originalFileName);

            // Strip the temp .part suffix off

            rename("{$filePath}.part", $newFilePath);
            $success['file'] = $newFilePath;
            $success['url'] = $newFileURL;
            die(json_encode($success));
        }

        // Return Success JSON-RPC response
        die(json_encode($success));
    }

}
