<?php

namespace App\Entity;

use App\Repository\CursoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CursoRepository::class)
 */
class Curso
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $cantAlumnos;

    /**
     * @ORM\ManyToMany(targetEntity=Alumno::class, inversedBy="cursos")
     */
    private $alumnos;

    /**
     * @ORM\ManyToOne(targetEntity=Profesor::class, inversedBy="cursos", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $profesor;

    /**
     * @ORM\ManyToOne(targetEntity=Materia::class, cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $materia;

    public function __construct()
    {
        $this->alumnos = new ArrayCollection();
        $this->cantAlumnos = 0;
    }

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

    /**
     * @return Collection|Alumno[]
     */
    public function getAlumnos(): Collection
    {
        return $this->alumnos;
    }

    public function addAlumno(Alumno $alumno): self
    {
        if (!$this->alumnos->contains($alumno)) {
            $this->alumnos[] = $alumno;
            $this->cantAlumnos = count($this->alumnos);
        }

        return $this;
    }

    public function removeAlumno(Alumno $alumno): self
    {
        $this->alumnos->removeElement($alumno);
        $this->cantAlumnos = count($this->alumnos);

        return $this;
    }

    public function getProfesor(): ?Profesor
    {
        return $this->profesor;
    }

    public function setProfesor(?Profesor $profesor): self
    {
        $this->profesor = $profesor;

        return $this;
    }

    public function getMateria(): ?Materia
    {
        return $this->materia;
    }

    public function setMateria(?Materia $materia): self
    {
        $this->materia = $materia;

        return $this;
    }

    public function getCantAlumnos(): ?int
    {
        return $this->cantAlumnos;
    }

    public function setCantAlumnos(int $cantAlumnos): self
    {
        $this->cantAlumnos = $cantAlumnos;

        return $this;
    }
}
