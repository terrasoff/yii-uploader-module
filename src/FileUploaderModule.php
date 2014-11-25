<?php
/**
 * @author Anton Tyutin <anton@tyutin.ru>
 */

namespace YiiFileUploader;

use CException;
use CWebModule;
use Infotech\FileStorage\Storage\StorageInterface;
use YiiFileUploader\Form\FileFormBehavior;

class FileUploaderModule extends CWebModule
{
    const TEMPORARY_STORAGE_PARAM = 'storage';

    public $controllerNamespace = 'YiiFileStorage\Controllers';

    public $defaultController = 'upload';

    /**
     * @return string the directory that contains the controller classes. Defaults to 'protected/controllers'.
     */
    public function getControllerPath()
    {
        return __DIR__ . '/Controllers';
    }

    public function createFileFormBehavior(StorageInterface $permanentStorage, $permanentStoragePrefix = '')
    {
        return new FileFormBehavior(
            $permanentStorage,
            $this->getTemporaryStorage(),
            $permanentStoragePrefix
        );
    }

    public function getTemporaryStorage()
    {
        $component = $this->getComponent(self::TEMPORARY_STORAGE_PARAM);

        if (!$component instanceof StorageInterface) {
            throw new CException(
                sprintf(
                    'Компонент "%s" не настроен в конфигурации модуля "%s" или не является хранилищем файлов',
                    self::TEMPORARY_STORAGE_PARAM,
                    $this->getName()
                )
            );
        }

        return $component;
    }

}
