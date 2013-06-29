<?php

namespace Digitalthoreau\FileBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * File
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Digitalthoreau\FileBundle\Entity\FileRepository")
 * @Vich\Uploadable
 */
class File
{
     /**
     *@Assert\File(
     *     maxSize="20M",
     *     mimeTypes={"image/png", "image/jpeg", "image/tiff", "text/xml", "text/html", "application/xml"}
     * )
     * @Vich\UploadableField(mapping="file_file", fileNameProperty="path")
     *
     * @var File $file
     */
    protected $file;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer")
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255, nullable=true)
     */
    private $path;
    
    /**
     * @ORM\OneToOne(targetEntity="Digitalthoreau\FileBundle\Entity\File")
     * @ORM\JoinColumn(name="file_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    protected $manuscriptimage; 
    
    /**
     * @var text $notes
     *
     * @ORM\Column(name="notes", type="text")
     */
    private $notes;    


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set file
     *
     * @param string $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * Get file
     *
     * @return string 
     */
    public function getFile()
    {
        return $this->file;
    }    

    /**
     * Set name
     *
     * @param string $name
     * @return File
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return File
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return File
     */
    public function setPath($path)
    {
        $this->path = $path;
    
        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }
    
    /**
     * Return the extention of the file.
     * 
     * @return string
     */
    public function getExt()
    {
        $filename = $this->getPath(); 
        return pathinfo($filename, PATHINFO_EXTENSION);
    }     



    /**
     * Set manuscriptimage
     *
     * @param \Digitalthoreau\FileBundle\Entity\File $manuscriptimage
     * @return File
     */
    public function setManuscriptimage(\Digitalthoreau\FileBundle\Entity\File $manuscriptimage = null)
    {
        $this->manuscriptimage = $manuscriptimage;
    
        return $this;
    }

    /**
     * Get manuscriptimage
     *
     * @return \Digitalthoreau\FileBundle\Entity\File 
     */
    public function getManuscriptimage()
    {
        return $this->manuscriptimage;
    }

    /**
     * Set notes
     *
     * @param string $notes
     * @return File
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    
        return $this;
    }

    /**
     * Get notes
     *
     * @return string 
     */
    public function getNotes()
    {
        return $this->notes;
    }
}