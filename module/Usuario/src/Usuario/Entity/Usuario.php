<?php
namespace Usuario\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation as Form;
use Doctrine\Common\Collections\ArrayCollection;
use ZfcUser\Entity\UserInterface as ZfcUserInterface;
use ZfcRbac\Identity\IdentityInterface;
use LosBase\Entity\AbstractEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="usuario")
 * @Form\Name("formUsuario")
 * @Form\Hydrator("Zend\Stdlib\Hydrator\ObjectProperty")
 * @Form\Type("LosBase\Form\AbstractForm")
 */
class Usuario extends AbstractEntity implements ZfcUserInterface, IdentityInterface
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
     * @ORM\Column(type="string", length=255)
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Validator({"name":"StringLength", "options":{"min":1, "max":255}})
     * @Form\Attributes({"type":"email"})
     * @Form\Options({"label":"Email"})
     */
    protected $email = '';

    /**
     * @ORM\ManyToOne(targetEntity="Cliente\Entity\Cliente", inversedBy="usuarios")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     * @ORM\OrderBy({"nome" = "ASC"})
     * @Form\Options({"label":"Cliente", "target_class":"Cliente\Entity\Cliente","find_method":{"name":"findBy","params":{"criteria":{}, "orderBy":{"nome":"ASC"}}},"display_empty_item":true,"empty_item_label":"---"})
     * @Form\Type("DoctrineModule\Form\Element\ObjectSelect")
     * @Form\Required(false)
     */
    protected $cliente;

    /**
     * @ORM\Column(type="string", length=32)
     * @Form\Type("Zend\Form\Element\Select")
     * @Form\Options({"label":"Permissão","value_options":{
     *     "usuario":"Usuário",
     *     "gerente":"Gerente",
     *     "suporte":"Suporte",
     *     "admin":"Admin",
     *     }
     * })
     * Possiveis: visitante, usuario, suporte, admin
     */
    protected $permissao = 'visitante';

    protected $username;

    /**
     * @ORM\Column(type="string", length=128)
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Validator({"name":"StringLength", "options":{"min":1, "max":128}})
     * @Form\Attributes({"type":"password"})
     * @Form\Options({"label":"Senha"})
     */
    protected $password = '';

    /**
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Validator({"name":"StringLength", "options":{"min":3, "max":32}})
     * @Form\Validator({"name":"Identical", "options":{"token":"password", "message":"As senhas não combinam"}})
     * @Form\Attributes({"type":"password"})
     * @Form\Options({"label":"Confirme a Senha"})
     */
    protected $confirmesenha;

    /**
     * @ORM\OneToMany(targetEntity="Usuario\Entity\Acesso", mappedBy="usuario")
     * @ORM\JoinColumn(nullable=false)
     * @Form\Exclude()
     */
    protected $acessos;

    public function __construct()
    {
        $this->created = new \DateTime('now');
        $this->updated = new \DateTime('now');
    }

    /**
     * @return string the $nome
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Retorna o campo $permissao
     * @return $permissao
     */
    public function getPermissao()
    {
        return $this->permissao;
    }

    /**
     * Seta o campo $permissao
     * @param field_type $permissao
     * @return $this
     */
    public function setPermissao($permissao)
    {
        $this->permissao = $permissao;

        return $this;
    }

    public function getRoles()
    {
        return array(
            $this->permissao
        );
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    public function getDisplayName()
    {
        return $this->getNome();
    }

    public function setDisplayName($displayName)
    {}

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        if (! empty($password)) {
            $this->password = (string) $password;
        }
    }

    public function getState()
    {}

    public function setState($state)
    {}

    public function getConfirmesenha()
    {
        return $this->confirmesenha;
    }

    public function setConfirmesenha($confirmesenha)
    {
        $this->confirmesenha = $confirmesenha;
        return $this;
    }

    public function getCliente()
    {
        return $this->cliente;
    }

    public function setCliente($cliente)
    {
        $this->cliente = $cliente;
        return $this;
    }

    public function getAcessos()
    {
        return $this->acessos;
    }

    public function setAcessos($acessos)
    {
        $this->acessos = $acessos;
        return $this;
    }

    public function __toString()
    {
        return $this->getDisplayName();
    }
}
