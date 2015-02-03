<?php
namespace Cliente\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation as Form;
use LosBase\Entity\AbstractEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="cliente")
 * @Form\Name("formCliente")
 * @Form\Hydrator("Zend\Stdlib\Hydrator\ObjectProperty")
 * @Form\Type("LosBase\Form\AbstractForm")
 */
class Cliente extends AbstractEntity
{

    /**
     * @ORM\Column(type="string", length=250)
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Validator({"name":"StringLength", "options":{"min":3, "max":250}})
     * @Form\Attributes({"type":"text"})
     * @Form\Options({"label":"Nome"})
     */
    protected $nome;

    /**
     * @ORM\Column(type="brprice")
     * @Form\Validator({"name":"Float"})
     * @Form\Attributes({"type":"text"})
     * @Form\Options({"label":"Crédito"})
     */
    protected $credito;

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    public function getCredito()
    {
        return $this->credito;
    }

    public function setCredito($credito)
    {
        $this->credito = $credito;

        return $this;
    }

    public function __toString()
    {
        return $this->nome;
    }
}
