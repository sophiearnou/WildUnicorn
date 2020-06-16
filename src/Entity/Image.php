<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Image
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $name = "";

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $path;

    /**
     * @var UploadedFile
     * 
     * @Assert\Image()
     */
    private $file;

    /**
     * @var ?string
     *
     * Chemin de l'ancien fichier en cas de modification
     */
    private $oldPath;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(UploadedFile $file)
        {
            $this->oldPath = $this->path; // Sauvegarde le chemin de l'ancien fichier pour le supprimer lors de l'upload du nouveau
            $this->path = ''; // Modifie cette valeur pour activer la modif Doctrine
            $this->file = $file;
            return $this;
        }
    

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function generatePath()
    {
        if ($this->file instanceof UploadedFile) {
            // Génére le chemin du fichier à uploader
            $this->path = uniqid('img_') . '.' . $this->file->guessExtension();
            $this->name = $this->file->getClientOriginalName();
        }
    }
    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        // Supprimer l'ancien fichier s'il existe
        if (is_file($this->getPublicRootDir() . $this->oldPath)) {
            unlink($this->getPublicRootDir() . $this->oldPath);
        }
        if ($this->file instanceof UploadedFile) {
            // Déplace le fichier uploadé var le dossier uploads
            $this->file->move(
                $this->getPublicRootDir(), // Vers le dossier public/uploads
                $this->path
            );
        }
    }
   
    
    /**
     * @ORM\PreRemove()
     */
    public function remove()
    {
        // Test si le fichier existe
        if (is_file($this->getPublicRootDir() . $this->path)) {
            unlink($this->getPublicRootDir() . $this->path); // Supprime le fichier
        }
    }
    
    /**
     * Emplacement des fichiers
     */
    public function getPublicRootDir()
    {
        return __DIR__ . '/../../public/uploads/images/'; 
        // public/uploads/ -> téléverse dans le fichier uploads
        // Correction public/uploads/images/ -> téléverse dans le fichier images
    }

     /**
     * Retourne le lien pour afficher l'image (peut être inclus dans une balise img).
     */
    public function getWebPath()
    {
        return '/uploads/images/'.$this->path; // Comme avant getPublicRootDir -> public/uploads/ => ne peut pas afficher images dans l'administration
    }

    public function __toString()
    {
        return $this->name;
    }
}
