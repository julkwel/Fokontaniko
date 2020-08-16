<?php
/**
 * © Julkwel <julienrajerison5@gmail.com>
 *
 * Fokontany Manager.
 */

namespace App\Manager;

use App\Entity\Employee;
use App\Entity\User;
use Symfony\Component\Form\FormInterface;

/**
 * Class EmployeeManager.
 */
class EmployeeManager extends AbstractManager
{
    /**
     * @param Employee      $employee
     * @param FormInterface $form
     * @param User          $currentUser
     *
     * @return Employee
     */
    public function handleNewEmployee(Employee $employee, FormInterface $form, User $currentUser)
    {
        $user = $employee->getUser();
        if (!empty($form->get('user')->get('password')->getData())) {
            $user->setRoles(['ROLE_EM_FKT'])
                ->setPassword($form->get('user')->get('password')->getData())
                ->setPassword($this->passEncoder->encodePassword($user, $user->getPassword()))
                ->setFokontany($currentUser->getFokontany())
            ;
        }

        $employee->setFokontany($currentUser->getFokontany());

        return $employee;
    }
}
