<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Application
 *
 * @ORM\Table(name="application")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ApplicationRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Application
{
    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->dateCreated = new \DateTime();
    }

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="userNumber", type="string", length=12)
     */
    private $userNumber;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthdate", type="date")
     */
    private $birthdate;

    /**
     * @var bool
     *
     * @ORM\Column(name="receiveNews", type="boolean")
     */
    private $receiveNews;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     * @Assert\Email()
     */
    private $email;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreated", type="datetime")
     */
    private $dateCreated;


    /**
     * @ORM\ManyToOne(targetEntity="Activity", inversedBy="applications")
     * @ORM\JoinColumn(nullable=false)
     */
    private $activity;

    /**
     * @ORM\ManyToOne(targetEntity="City", inversedBy="applications")
     * @ORM\JoinColumn(nullable=false)
     */
    private $city;

    /**
     * @ORM\OneToOne(targetEntity="Passport", inversedBy="application", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $passport;

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context)
    {
        // check if the name is actually a fake name
        if ($this->receiveNews && empty($this->email)) {
            $context->buildViolation('Veuillez fournir votre email !')
                ->atPath('email')
                ->addViolation();
        }
    }

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
     * Set userNumber
     *
     * @param string $userNumber
     * @return Application
     */
    public function setUserNumber($userNumber)
    {
        $this->userNumber = $userNumber;

        return $this;
    }

    /**
     * Get userNumber
     *
     * @return string
     */
    public function getUserNumber()
    {
        return $this->userNumber;
    }

    /**
     * Set birthdate
     *
     * @param \DateTime $birthdate
     * @return Application
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set receiveNews
     *
     * @param boolean $receiveNews
     * @return Application
     */
    public function setReceiveNews($receiveNews)
    {
        $this->receiveNews = $receiveNews;

        return $this;
    }

    /**
     * Get receiveNews
     *
     * @return boolean
     */
    public function getReceiveNews()
    {
        return $this->receiveNews;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Application
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return Application
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set activity
     *
     * @param \AppBundle\Entity\Activity $activity
     *
     * @return Application
     */
    public function setActivity(\AppBundle\Entity\Activity $activity)
    {
        $this->activity = $activity;

        return $this;
    }

    /**
     * Get activity
     *
     * @return \AppBundle\Entity\Activity
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * Set city
     *
     * @param \AppBundle\Entity\City $city
     *
     * @return Application
     */
    public function setCity(\AppBundle\Entity\City $city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return \AppBundle\Entity\City
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set passport
     *
     * @param \AppBundle\Entity\Passport $passport
     *
     * @return Application
     */
    public function setPassport(\AppBundle\Entity\Passport $passport)
    {
        $this->passport = $passport;

        return $this;
    }

    /**
     * Get passport
     *
     * @return \AppBundle\Entity\Passport
     */
    public function getPassport()
    {
        return $this->passport;
    }
}
