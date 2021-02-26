<?php

namespace App\Common\Liform\Transformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use League\Uri\Components\DataPath;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileToDataUriTransformer implements DataTransformerInterface
{
    /**
     * {@inheritdoc}
     */
    public function transform($value)
    {
        if (!$value instanceof \SplFileInfo) {
            return '';
        }
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($value)
    {
        if (empty($value)) {
            return null;
        }

        return $this->storeTemporary($value);
    }

    public function storeTemporary($data)
    {
        $prefix = 'data:';
        if (substr($data, 0, strlen($prefix)) == $prefix) {
            $data = substr($data, strlen($prefix));
        }
        $dataPath = new DataPath($data);
        if (false === $path = tempnam($directory = sys_get_temp_dir(), 'Base64EncodedFile')) {
            throw new FileException(sprintf('Unable to create a file into the "%s" directory', $directory));
        }
        $fileObject = $dataPath->save($path, 'w');
        return new UploadedFile($path, 'not-available', null, null, null, true);
    }
}
