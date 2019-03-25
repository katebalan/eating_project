<?php

namespace EatingBundle\EventListener;

use EatingBundle\Entity\Activity;
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

    private $file;

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
        $folder = "";
        // upload only works for Products entities
        if (!($entity instanceof Products or $entity instanceof Activity)) {
            return;
        }
        if ($entity instanceof Products) {
            $folder = "products";
        }
        if ($entity instanceof Activity) {
            $folder = "activity";
        }

        $file = $entity->getImage();

        // only upload new files
        if ($file instanceof UploadedFile) {
            $fileName = $this->uploader->upload($file, $folder);
            $entity->setImage($fileName);
        } elseif ($this->file instanceof File) {
            // prevents the full file path being saved on updates
            // as the path is set on the postLoad listener
            $entity->setImage($this->file->getFilename());
            unset($this->file);
        }
    }

    /**
     * Listen Edit actions
     *
     * @param LifecycleEventArgs $args
     */
    public function postLoad(LifecycleEventArgs $args)
    {
        $folder = "";
        $entity = $args->getEntity();

        if (!($entity instanceof Products or $entity instanceof Activity)) {
            return;
        }
        if ($entity instanceof Products) {
            $folder = "products";
        }
        if ($entity instanceof Activity) {
            $folder = "activity";
        }

        if ($fileName = $entity->getImage()) {
            $entity->setImage(new File($this->uploader->getTargetDirectory() . $folder . '/' . $fileName));
            $this->file = $entity->getFile();
        }
    }
}
