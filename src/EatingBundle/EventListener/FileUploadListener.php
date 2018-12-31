<?php

namespace EatingBundle\EventListener;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use EatingBundle\Entity\Products;
use EatingBundle\Service\FileUploader;

/**
 * Class FileUploadListener
 * @package EatingBundle\EventListener
 */
class FileUploadListener
{
    /**
     * @var FileUploader $uploader
     */
    private $uploader;

    /**
     * FileUploadListener constructor.
     *
     * @param FileUploader $uploader
     */
    public function __construct(FileUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    /**
     * Listen create actions
     *
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    /**
     * Listen update actions
     *
     * @param PreUpdateEventArgs $args
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    /**
     * Upload new file and save new path into entity
     *
     * @param $entity
     */
    private function uploadFile($entity)
    {
        // upload only works for Products entities
        if (!$entity instanceof Products) {
            return;
        }

        $file = $entity->getImage();

        // only upload new files
        if ($file instanceof UploadedFile) {
            $fileName = $this->uploader->upload($file);
            $entity->setImage($fileName);
        } elseif ($file instanceof File) {
            // prevents the full file path being saved on updates
            // as the path is set on the postLoad listener
            $entity->setImage($file->getFilename());
        }
    }

    /**
     * Listen Edit actions
     *
     * @param LifecycleEventArgs $args
     */
    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Products) {
            return;
        }

        if ($fileName = $entity->getImage()) {
            $entity->setImage(new File($this->uploader->getTargetDirectory() . 'products/' . $fileName));
        }
    }
}
