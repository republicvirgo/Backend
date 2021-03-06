<?php

namespace Persona\Hris\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\SoftDeletable\SoftDeletable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Persona\Hris\Core\Logger\ActionLoggerAwareTrait;
use Persona\Hris\Core\Logger\Model\ActionLoggerAwareInterface;
use Persona\Hris\Employee\Model\EmployeeAwareInterface;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Salary\Model\AdditionalBenefitInterface;
use Persona\Hris\Salary\Model\BenefitAwareInterface;
use Persona\Hris\Salary\Model\BenefitInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="sa_salary_additional_benefits", indexes={
 *     @ORM\Index(name="salary_additional_benefit_search_idx", columns={"employee_id", "benefit_id"}),
 *     @ORM\Index(name="salary_additional_benefit_search_employee_id", columns={"employee_id"}),
 *     @ORM\Index(name="salary_additional_benefit_search_benefit", columns={"benefit_id"})
 * })
 *
 * @ApiResource(
 *     attributes={
 *         "filters"={"order.filter"},
 *         "normalization_context"={"groups"={"read"}},
 *         "denormalization_context"={"groups"={"write"}}
 *     }
 * )
 *
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
class SalaryAdditionalBenefit implements AdditionalBenefitInterface, EmployeeAwareInterface, BenefitAwareInterface, ActionLoggerAwareInterface
{
    use ActionLoggerAwareTrait;
    use Timestampable;
    use SoftDeletable;

    /**
     * @Groups({"read"})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="guid")
     *
     * @var string
     */
    private $id;

    /**
     * @Groups({"read"})
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $employeeId;

    /**
     * @var EmployeeInterface
     */
    private $employee;

    /**
     * @Groups({"read"})
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $benefitId;

    /**
     * @var BenefitInterface
     */
    private $benefit;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="float", scale=27, precision=2)
     * @Assert\NotBlank()
     *
     * @var float
     */
    private $benefitValue;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmployeeId(): string
    {
        return (string) $this->employeeId;
    }

    /**
     * @param string $employeeId
     */
    public function setEmployeeId(string $employeeId = null)
    {
        $this->employeeId = $employeeId;
    }

    /**
     * @return EmployeeInterface
     */
    public function getEmployee(): ? EmployeeInterface
    {
        return $this->employee;
    }

    /**
     * @param EmployeeInterface $employee
     */
    public function setEmployee(EmployeeInterface $employee = null): void
    {
        $this->employee = $employee;
        if ($this->employee) {
            $this->employeeId = $employee->getId();
        }
    }

    /**
     * @return string
     */
    public function getBenefitId(): string
    {
        return (string) $this->benefitId;
    }

    /**
     * @param string $benefitId
     */
    public function setBenefitId(string $benefitId = null)
    {
        $this->benefitId = $benefitId;
    }

    /**
     * @return BenefitInterface
     */
    public function getBenefit(): ? BenefitInterface
    {
        return $this->benefit;
    }

    /**
     * @param BenefitInterface $benefit
     */
    public function setBenefit(BenefitInterface $benefit = null): void
    {
        $this->benefit = $benefit;
        if ($benefit) {
            $this->benefitId = $benefit->getId();
        }
    }

    /**
     * @return float
     */
    public function getBenefitValue(): float
    {
        return $this->benefitValue;
    }

    /**
     * @param float $benefitValue
     */
    public function setBenefitValue(float $benefitValue)
    {
        $this->benefitValue = $benefitValue;
    }
}
