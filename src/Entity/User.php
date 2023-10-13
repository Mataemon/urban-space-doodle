<?php

// src/Entity/User.php
namespace App\Entity;

class User
{
    // Properties

    private $firstname;
    private $lastname;
    private $email;
    private $country;
    private $address1;
    private $statut;
    private $company;
    private $city;
    private $zipcode;
    private $gender;
    private $password;
    private $companySiret;
    private $companyTva;
    private $address2;
    private $confirmed;
    private $billingEmail;
    private $notifyEv;
    private $notifyAr;
    private $notifyNg;
    private $notifyConsent;
    private $notifyEidasToValid;
    private $notifyRecipientUpdate;
    private $notifyWaitingArAnswer;
    private $isLegalEntity;
    private $id;

    // Getters

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function getAddress1(): ?string
    {
        return $this->address1;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getCompanySiret(): ?string
    {
        return $this->companySiret;
    }

    public function getCompanyTva(): ?string
    {
        return $this->companyTva;
    }

    public function getAddress2(): ?string
    {
        return $this->address2;
    }

    public function getConfirmed(): ?bool
    {
        return $this->confirmed;
    }

    public function getBillingEmail(): ?string
    {
        return $this->billingEmail;
    }

    public function getNotifyEv(): ?bool
    {
        return $this->notifyEv;
    }

    public function getNotifyAr(): ?bool
    {
        return $this->notifyAr;
    }

    public function getNotifyNg(): ?bool
    {
        return $this->notifyNg;
    }

    public function getNotifyConsent(): ?bool
    {
        return $this->notifyConsent;
    }

    public function getNotifyEidasToValid(): ?bool
    {
        return $this->notifyEidasToValid;
    }

    public function getNotifyRecipientUpdate(): ?bool
    {
        return $this->notifyRecipientUpdate;
    }

    public function getNotifyWaitingArAnswer(): ?bool
    {
        return $this->notifyWaitingArAnswer;
    }

    public function getIsLegalEntity(): ?bool
    {
        return $this->isLegalEntity;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    // Setters

    public function setFirstname(?string $firstname): void
    {
        $this->firstname = $firstname;
    }

    public function setLastname(?string $lastname): void
    {
        $this->lastname = $lastname;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function setCountry(?string $country): void
    {
        $this->country = $country;
    }

    public function setAddress1(?string $address1): void
    {
        $this->address1 = $address1;
    }

    public function setStatut(?string $statut): void
    {
        $this->statut = $statut;
    }

    public function setCompany(?string $company): void
    {
        $this->company = $company;
    }

    public function setCity(?string $city): void
    {
        $this->city = $city;
    }

    public function setZipcode(?string $zipcode): void
    {
        $this->zipcode = $zipcode;
    }

    public function setGender(?string $gender): void
    {
        $this->gender = $gender;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    public function setCompanySiret(?string $companySiret): void
    {
        $this->companySiret = $companySiret;
    }

    public function setCompanyTva(?string $companyTva): void
    {
        $this->companyTva = $companyTva;
    }

    public function setAddress2(?string $address2): void
    {
        $this->address2 = $address2;
    }

    public function setConfirmed(?bool $confirmed): void
    {
        $this->confirmed = $confirmed;
    }

    public function setBillingEmail(?string $billingEmail): void
    {
        $this->billingEmail = $billingEmail;
    }

    public function setNotifyEv(?bool $notifyEv): void
    {
        $this->notifyEv = $notifyEv;
    }

    public function setNotifyAr(?bool $notifyAr): void
    {
        $this->notifyAr = $notifyAr;
    }

    public function setNotifyNg(?bool $notifyNg): void
    {
        $this->notifyNg = $notifyNg;
    }

    public function setNotifyConsent(?bool $notifyConsent): void
    {
        $this->notifyConsent = $notifyConsent;
    }

    public function setNotifyEidasToValid(?bool $notifyEidasToValid): void
    {
        $this->notifyEidasToValid = $notifyEidasToValid;
    }

    public function setNotifyRecipientUpdate(?bool $notifyRecipientUpdate): void
    {
        $this->notifyRecipientUpdate = $notifyRecipientUpdate;
    }

    public function setNotifyWaitingArAnswer(?bool $notifyWaitingArAnswer): void
    {
        $this->notifyWaitingArAnswer = $notifyWaitingArAnswer;
    }

    public function setIsLegalEntity(?bool $isLegalEntity): void
    {
        $this->isLegalEntity = $isLegalEntity;
    }
    public function setId(?string $id): void
    {
        $this->id = $id;
    }
}
