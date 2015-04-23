<?php namespace App\Library;

use Sanitize;
use Input;
use Image;
use File;
use Validator;
use App\Models\Image as ImageModel;

class ImageApi
{
    protected $config;
    protected $modelType;
    protected $modelId;
    protected $modelItem;
    protected $baseName;
    protected $filenameFormat = '[:base_name]_[:uniqid]'; // [:base_name][:original_name][:uniqid]
    protected $defaultQuality = 75;
    protected $actionsAll = [];
    protected $actionsBySize = [];
    protected $inputFields = [
        'files_new' => 'files_new',
        'files_update' => 'files_update',
        'alt_new' => 'alt_new',
        'alt_update' => 'alt_update',
        'description_new' => 'description_new',
        'description_update' => 'description_update'
    ];
    protected $errors = [];
    protected $errorsUpload = [];
    protected $uploadedFiles = [];

    public function setConfig($config)
    {
        if (is_array($config)) {
            $this->config = $config;
        } else {
            $this->config = config($config);
        }
        return $this;
    }

    public function setModelType($modelType)
    {
        $this->modelType = $modelType;
        return $this;
    }

    public function setModelId($modelId)
    {
        $this->modelId = $modelId;
        return $this;
    }

    public function setBaseName($baseName)
    {
        $this->baseName = $baseName;
        return $this;
    }

    public function setFilenameFormat($format)
    {
        $this->filenameFormat = $format;
        return $this;
    }

    public function setInputFields($field, $value = null)
    {
        if (is_array($field)) {
            $this->inputFields = array_merge($this->inputFields, $field);
        } else {
            $this->inputFields[$field] = $value;
        }
        return $this;
    }

    public function setActionsBySize($size, $actions = null)
    {
        if (is_array($size)) {
            $this->actionsBySize = array_merge($this->actionsBySize, $size);
        } elseif ($actions) {
            $this->actionsBySize[$size] = $actions;
        }
        return $this;
    }

    public function setActionsAll($actions)
    {
        if (is_array($actions)) {
            $this->actionsAll = $actions;
        }
        return $this;
    }

    public function setModelItem($modelItem)
    {
        $this->modelItem = $modelItem;
        return $this;
    }

    protected function getModelItem($find = true)
    {
        if ($this->modelId && $this->modelType && $find) {
            $model = $this->modelType;
            return $model::find($this->modelId);
        }
        return $this->modelItem;
    }

    public function getUploadedFiles($type = null)
    {
        if ($type == 'new') {
            if (isset($this->uploadedFiles['new']) && count($this->uploadedFiles['new'])) {
                foreach ($this->uploadedFiles['new'] as $key => $file) {
                    if (!is_object($file)) unset($this->uploadedFiles['new'][$key]);
                }
                return $this->uploadedFiles['new'];
            }
            return [];
        }

        if ($type == 'update') {
            if (isset($this->uploadedFiles['update']) && count($this->uploadedFiles['update'])) {
                foreach ($this->uploadedFiles['update'] as $key => $file) {
                    if (!is_object($file)) unset($this->uploadedFiles['update'][$key]);
                }
                return $this->uploadedFiles['update'];
            }
            return [];
        }
        return $this->uploadedFiles;
    }


    public function getErrors()
    {
        return $this->errors;
    }

    public function getErrorsUpload($type = null)
    {
        if ($type == 'new') {
            return isset($this->errorsUpload['new']) ? $this->errorsUpload['new'] : [];
        }

        if ($type == 'update') {
            return isset($this->errorsUpload['update']) ? $this->errorsUpload['update'] : [];
        }
        return $this->errorsUpload;
    }

    protected function setErrorsUpload($type, $error = [])
    {
        if (is_array($type)) {
            $this->errorsUpload = $type;
        } else {
            $this->errorsUpload[$type] = $error;
        }
    }

    public function getErrorsNew()
    {
        return isset($this->errors['new']) ? $this->errors['new'] : [];
    }

    public function getErrorsUpdate()
    {
        return isset($this->errors['update']) ? $this->errors['update'] : [];
    }

    public function hasErrors()
    {
        return $this->errors ? true : false;
    }

    public function hasErrorsNew()
    {
        return $this->errors['new'] ? true : false;
    }

    public function hasErrorsUpdate()
    {
        return $this->errors['update'] ? true : false;
    }

    public function getErrorsAll()
    {
        return array_merge(
            isset($this->errorsUpload['new']) ? $this->errorsUpload['new'] : [],
            isset($this->errorsUpload['update']) ? $this->errorsUpload['update'] : [],
            isset($this->errors['new']) ? $this->errors['new'] : [],
            isset($this->errors['update']) ? $this->errors['update'] : []
        );
    }

    /**
     * Main process method.
     *
     * @return bool
     */
    public function process()
    {
        $this->uploadFiles();

        if (!$this->checkRequired()) {
            return false;
        }

        if (!$this->checkMultiple()) {
            return false;
        }

        // Validate files
        $this->validateFiles();

        if ($this->hasErrors()) {
            return false;
        }

        // Process upload
        $this->processUpload($this->uploadedFiles);

        if ($this->hasErrors()) {
            return false;
        }

        // Update alt and description for existing images
        $this->dbUpdate();

        return true;
    }

    public function uploadFiles()
    {
        foreach (['new', 'update'] as $type) {
            $filesType = "files_{$type}";

            if (Input::hasFile($this->inputFields[$filesType])) {
                $this->uploadedFiles[$type] = Input::file($this->inputFields[$filesType]);

                // Make sure it really is an array
                if (!is_array($this->uploadedFiles[$type])) {
                    $this->uploadedFiles[$type] = [$this->uploadedFiles[$type]];
                }
            } else {
                $this->errorsUpload[$type][] = 'The file is required. The file not uploaded ' . $this->inputFields[$filesType] . '.';
            }
        }
    }

    protected function checkRequired()
    {
        $config = $this->config;

        if (isset($config['required']) && $config['required']) {

            // Existing model
            if ($modelItem = $this->getModelItem()) {
                if (count($modelItem->images)) {
                    $this->setErrorsUpload([]);
                    return true;
                }
            }

            // New uploads
            if (count($this->getUploadedFiles('new'))) {
                $this->setErrorsUpload([]);
                return true;
            }
            return false;
        }
        $this->setErrorsUpload([]);
        return true;
    }

    protected function makeFilename($upload)
    {
        $originalName = $upload->getClientOriginalName();
        $originalExtension = $upload->guessExtension();

        $pathinfo = pathinfo($originalName);
        $extension = strtolower($originalExtension ?: $pathinfo['extension']);
        $extension = $this->extensionReplace($extension);

        $search = [
            '[:base_name]',
            '[:uniqid]',
            '[:original_name]',
        ];

        $replace = [
            $this->baseName,
            uniqid(),
            $pathinfo['filename']
        ];

        $baseName = str_replace($search, $replace, $this->filenameFormat);
        $baseName = Sanitize::string($baseName);

        return $baseName . '.' . $extension;
    }

    protected function extensionReplace($extension)
    {
        $extensions = [
            'jpeg' => 'jpg'
        ];

        if (isset($extensions[$extension]))
            return $extensions[$extension];

        return $extension;
    }

    protected function checkMultiple()
    {
        $config = $this->config;

        if (isset($config['multiple']) && !$config['multiple']) {

            // Existing model
            $exists = 0;
            if ($modelItem = $this->getModelItem()) {
                $exists = count($modelItem->images);
            }

            $new = count($this->getUploadedFiles('new'));

            if (($exists + $new) > 1) {
                $this->errorsUpload['new'][] = 'Multiple files are not allowed.';
                return false;
            }
        }
        return true;
    }

    /**
     * Validation process.
     *
     * @param  array $types
     * @return void
     */
    protected function validateFiles($types = ['new', 'update'])
    {
        foreach ($types as $type) {
//            if (!count($files)) {
//                $this->errors[] = 'There is no files.';
//                return false;
//            }

            $files = $this->getUploadedFiles($type);

            if (!count($files)) {
//                $this->errors[$type][] = 'No uploaded files.';
                continue;
            }

            foreach ($files as $key => $file) {

                $validator = Validator::make(
                    array('file' => $file),
                    array('file' => $this->prepareValidationRules())
                );

                if (!$validator->passes()) {
//                    $this->errors[$type][] = 'File "' . $file->getClientOriginalName() . '". ' . $validator->messages()->all();
                    $this->errors[$type][] = 'File "' . $file->getClientOriginalName() . '". ' . implode("\n", $validator->messages()->all());
                }
            }
        }
    }

    /**
     * Prepare validation rules from config.
     *
     * @return array
     */
    protected function prepareValidationRules()
    {
        $config = $this->config;

        $validationArray = array();

        if ($config['required']) $validationArray[] = 'required';

        $validationArray[] = 'image';

        if ($config['allowed_types']) $validationArray[] = 'mimes:' . $config['allowed_types'];

        if ($config['max']) $validationArray[] = 'max:' . $config['max'];

        return implode('|', $validationArray);
    }

    /**
     * Procces upload.
     *
     * @return void
     */
    protected function processUpload()
    {
        foreach (['new', 'update'] as $type) {

            $uploadedFiles = $this->getUploadedFiles($type);

            if (!$uploadedFiles) continue;

            foreach ($uploadedFiles as $key => $upload) {

                $config = $this->config;
                $defaultQuality = isset($config['quality']) ? $config['quality'] : $this->defaultQuality;
                $fullPath = null;
                $error = null;
                $filename = $this->makeFilename($upload);

                if (isset($config['sizes'])) {
                    foreach ($config['sizes'] as $k => $size) {
                        $image = Image::make($upload);

                        if (!empty($this->actionsAll)) {
                            $size['actions'] = array_merge($size['actions'], $this->actionsAll);
                        }

                        if (isset($this->actionsBySize[$k])) {
                            $size['actions'] = array_merge($size['actions'], $this->actionsBySize[$k]['actions']);
                        }

                        $quality = isset($size['quality']) ? $size['quality'] : $defaultQuality;

                        // Make directory
                        $dir = $config['path'] . $size['folder'];
                        if (!is_dir($dir)) {
                            File::makeDirectory($dir);
                        }
                        $fullPath = $dir . $filename;

                        // Apply actions
                        if (isset($size['actions']) && !empty($size['actions'])) {

                            foreach ($size['actions'] as $action => $param) {
                                call_user_func_array(array($image, $action), $param);
                            }
                        }

                        $image->save($fullPath, $quality);
                        if (!is_file($fullPath)) {
                            $error = true;
                        }
                    }

                    if ($error) {
                        $this->errors[$type][] = 'File "' . $upload->getClientOriginalName() . '": error during processing.';
                        // Delete already uploaded images
                        $this->delete($filename);
                    } else {
                        $this->dbSave($type, $filename, $key);
                    }
                }
            }
        }
    }

    /**
     * Delete all images that are not in the database.
     *
     * @return string $log
     */
    public function cleaner()
    {
        $log = '';
        $images = File::allFiles(public_path('media/images'));
        if ($images) {
            foreach ($images as $image) {
                $item = ImageModel::where('image', $image->getFilename())->first();
                if (!$item) {
                    $path = $image->getRealPath();
                    if (is_file($path)) {
                        $log .= $path . "\n";
                        unlink($path);
                    }
                }
            }
        }
        return $log;
    }

    /**
     * Save data in the database.
     *
     * @param  string $type
     * @param  string $filename
     * @param  int $key
     * @return void
     */
    protected function dbSave($type, $filename, $key = null)
    {
        if ($type == 'update') {
            $image = ImageModel::find($key);
            if (!$image) return false;
            $oldImage = $image->image;

            $image->alt = Input::get($this->inputFields['alt_' . $type] . '.' . $key);
            $image->description = Input::get($this->inputFields['description_' . $type] . '.' . $key);

            $image->model_id = $this->modelId;
            $image->model_type = $this->modelType;
            $image->image = $filename;
            $image->save();

            // Delete old image
            $this->delete($oldImage);
        }

        if ($type == 'new') {
            $image = new ImageModel();

            $inputAlt = Input::get($this->inputFields['alt_' . $type]);

            if (count($inputAlt) > 1) {
                // Multiple input fields
                $image->alt = Input::get($this->inputFields['alt_' . $type] . '.' . $key);
                $image->description = Input::get($this->inputFields['description_' . $type] . '.' . $key);
            } else {
                // Multiple files, one input field
                $image->alt = current(Input::get($this->inputFields['alt_' . $type], []));
                $image->description = current(Input::get($this->inputFields['description_' . $type], []));
            }

            $image->model_id = $this->modelId;
            $image->model_type = $this->modelType;
            $image->image = $filename;
            $image->save();
        }
    }

    protected function dbUpdate()
    {
        $inputAlt = Input::get($this->inputFields['alt_update']);
        $inputDescription = Input::get($this->inputFields['description_update']);

        if (!empty($inputAlt)) {
            foreach ($inputAlt as $id => $value) {
                $image = ImageModel::find($id);
                if ($image) {
                    $image->alt = $value;
                    $image->description = $inputDescription[$id];
                    $image->save();
                }
            }
        }
    }

    /**
     * Delete image from db by id.
     *
     * @param  mixed $ids
     * @param  bool $withImages
     * @return array $return
     */
    public function destroy($ids, $withImages = true)
    {
        $return = array();

        $ids = (array)$ids;

        if (empty($ids)) return $return;

        foreach ($ids as $id) {

            $image = ImageModel::find($id);

            if ($image) {

                $moduleLower = strtolower(class_basename($image->model_type));
                $config = (config($moduleLower));

                $filename = $image->image;
                // Don't delete last image if is required
                if ((count($image->sameParent()) < 2) && $config['image']['required']) {
                    msg('You can not delete last image.', 'danger');
                    return $return;
                }

                if ($image->delete()) {
                    if ($withImages && !$this->checkImageReusedByFilename($filename)) {
                        $this->delete($filename);
                    }
                    $return[] = $id;
                }
            }
        }

        return $return;
    }

    /**
     * Delete image from filesystem.
     *
     * @param  string $image
     * @return void
     */
    public function delete($image)
    {
        $config = $this->config;

        if (isset($config['sizes'])) {
            foreach ($config['sizes'] as $size) {
                $filename = $config['path'] . $size['folder'] . $image;
                if (is_file($filename)) {
                    unlink($filename);
                }
            }
        }
    }

    protected function checkImageReusedByFilename($filename)
    {
        $images = ImageModel::where('image', $filename);
        if (count($images) > 1) {
            return true;
        }
        return false;
    }

    protected function checkImageReusedById($id)
    {
        $image = ImageModel::find($id);
        if ($image) {
            $filename = $image->image;
            $images = ImageModel::where('image', $filename);
            if (count($images) > 1) {
                return true;
            }
        }
        return false;
    }

}