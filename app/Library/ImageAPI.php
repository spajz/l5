<?php namespace Library;

class ImageApi
{
    protected $config;
    protected $modelType;
    protected $modelId;
    protected $baseName;
    protected $key;
    protected $actionsAll;
    protected $actionsBySize;
    protected $inputFields = array(
        'files' => 'files',
        'alt' => 'alt',
        'description' => 'description'
    );
    protected $errors = array();


    protected $uploadedFiles = array();

    public function setConfig($config)
    {
        if (is_array($config)) {
            $this->config = $config;
        } else {
            $this->config = Config::get($config);
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

    public function setKey($key)
    {
        $this->key = $key;
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

    public function setActionsBySize($actions)
    {
        if (is_array($actions)) {
            $this->actionsBySize = $actions;
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

    public function getErrors()
    {
        return $this->errors;
    }


    public function uploadFiles()
    {
        if (Input::hasFile($this->inputField['files'])) {
            $uploadedFiles = Input::file($this->inputField['files']);

            // Make sure it really is an array
            if (!is_array($uploadedFiles)) {
                if (is_null($this->key)) {
                    $uploadedFiles = array($uploadedFiles);
                } else {
                    $uploadedFiles = array($this->key => $uploadedFiles);
                }
            }

            $this->uploadedFiles = $uploadedFiles;
            return true;

        } else {
            $this->errors[] = 'File not uploaded ' . $this->inputField['files'];
        }
    }

    public function validateFiles()
    {

    }


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









    ////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////


    protected $errors = array();
    protected $uploadedFiles = array();
    protected $key = null;


    public function processUpload()
    {
        $this->upload();

        if (!empty($this->uploadedFiles)) {
            foreach ($this->uploadedFiles as $key => $file) {
                $this->save($file, $key);
            }
        }
    }

    public function upload($onlyValidate = false)
    {
        if (Input::hasFile($this->inputField['files'])) {
            
            // Loop through all uploaded files
            foreach ($uploads as $key => $upload) {

                // Ignore array member if it's not an UploadedFile object, just to be extra safe
                if (!is_a($upload, 'Symfony\Component\HttpFoundation\File\UploadedFile')) {
                    continue;
                }

                $validator = Validator::make(
                    array('file' => $upload),
                    array('file' => $this->prepareValidationRules())
                );

                if ($validator->passes()) {
                    // Do something
                    if (!$onlyValidate) $this->process($upload, $key);
                } else {
                    // Collect error messages
                    $this->errors[] = 'File "' . $upload->getClientOriginalName() . '":' . $validator->messages()->first('file');
                }
            }

        } else {
            // No files have been uploaded
        }
    }

    protected function process($upload, $key)
    {
        $config = $this->config;
        $originalName = $upload->getClientOriginalName();
        $pathinfo = pathinfo($originalName);
        $extension = strtolower($pathinfo['extension']);
        $baseName = $this->baseName ? $this->baseName : $pathinfo['filename'];
        $baseName = Sanitize::string($baseName) . '_' . uniqid();
        $file = $baseName . '.' . $extension;
        $defaultQuality = isset($config['quality']) ? $config['quality'] : 90;
        $fullPath = false;
        $error = false;

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

                if (isset($size['actions']) && !empty($size['actions'])) {

                    foreach ($size['actions'] as $action => $param) {
                        call_user_func_array(array($image, $action), $param);

                        $fullPath = $config['path'] . $size['folder'] . $file;
                        $image->save($fullPath, $quality);
                        if (!is_file($fullPath)) {
                            $error = true;
                        }
                    }
                } else {
                    $fullPath = $config['path'] . $size['folder'] . $file;
                    $image->save($fullPath, $quality);
                    if (!is_file($fullPath)) {
                        $error = true;
                    }
                }
            }

            if ($error) {
                $this->errors[] = 'File "' . $upload->getClientOriginalName() . '": error during processing.';
                // Delete already uploaded images
                $this->delete($fullPath);
            } else {
                $this->uploadedFiles[$key] = $file;
            }
        }
    }

    protected function save($file, $key = null)
    {
        $image = new ImageModel();

        $image->model_id = $this->modelId;
        $image->model_type = $this->modelType;
        $image->image = $file;
        $image->alt = Input::get($this->inputField['alt'] . '.' . $key);
        $image->description = Input::get($this->inputField['description'] . '.' . $key);
        $image->save();
    }


    public function destroy($ids)
    {
        $return = array();

        if (!is_array($ids)) $ids = array($ids);

        if (empty($ids)) return $return;

        foreach ($ids as $id) {

            $image = ImageModel::find($id);

            if ($image && $image->delete()) {
                $return[] = $id;
            }
        }

        return $return;
    }

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

}