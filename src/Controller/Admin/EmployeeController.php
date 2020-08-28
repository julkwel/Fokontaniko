<?php
/**
 * © Julkwel <julienrajerison5@gmail.com>
 *
 * Fokontany Controller.
 */

namespace App\Controller\Admin;

use App\Constant\MessageConstant;
use App\Constant\PageConstant;
use App\Controller\AbstractBaseController;
use App\Entity\Employee;
use App\Entity\Fokontany;
use App\Form\EmployeeType;
use App\Manager\EmployeeManager;
use App\Repository\EmployeeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Endroid\QrCode\Factory\QrCodeFactoryInterface;
use Endroid\QrCodeBundle\Response\QrCodeResponse;
use Knp\Component\Pager\PaginatorInterface;
use Nzo\UrlEncryptorBundle\Annotations\ParamDecryptor;
use Nzo\UrlEncryptorBundle\UrlEncryptor\UrlEncryptor;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/admin/employee")
 *
 * Class EmployeeController.
 */
class EmployeeController extends AbstractBaseController
{
    /** @var EmployeeRepository */
    private $repository;

    /** @var EmployeeManager */
    private $employeManager;

    /**
     * EmployeeController constructor.
     *
     * @param EntityManagerInterface       $entityManager
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     * @param UrlEncryptor                 $urlEncrypt
     * @param PaginatorInterface           $paginator
     * @param EmployeeRepository           $employeeRepository
     * @param EmployeeManager              $employeeManager
     */
    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder, UrlEncryptor $urlEncrypt, PaginatorInterface $paginator, EmployeeRepository $employeeRepository, EmployeeManager $employeeManager)
    {
        parent::__construct($entityManager, $userPasswordEncoder, $urlEncrypt, $paginator);
        $this->repository = $employeeRepository;
        $this->employeManager = $employeeManager;
    }

    /**
     * @param Request        $request
     * @param Fokontany|null $fokontany
     *
     * @return Response the list of employee by fokontany
     *
     * @Route("/list/{fokontany?}", name="list_employee", methods={"POST","GET"})
     */
    public function listEmployee(Request $request, Fokontany $fokontany = null)
    {
        $fokontany = $fokontany ?? $this->getUser()->getFokontany();
        $needle = $request->get('search');
        $pagination = $this->paginator->paginate(
            $this->repository->findAllEmployee($fokontany, $needle),
            $request->query->getInt('page', PageConstant::DEFAULT_PAGE),
            PageConstant::DEFAULT_NUMBER_PER_PAGE
        );

        return $this->render('admin/employee/_employee_list.html.twig', ['employes' => $pagination]);
    }

    /**
     * @Route("/manage/{id?}", name="employee_manage", methods={"POST","GET"})
     *
     * @param Request       $request
     * @param Employee|null $employee
     *
     * @return Response
     */
    public function manageEmployee(Request $request, Employee $employee = null)
    {
        $employee = $employee ?? new Employee();
        $form = $this->createForm(EmployeeType::class, $employee, ['onEdit' => $employee->getId()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $employee = $this->employeManager->handleNewEmployee($employee, $form, $this->getUser());

            if ($this->save($employee)) {
                $this->addFlash(MessageConstant::SUCCESS_TYPE, 'Tafiditra i '.$employee->getUser()->getFirstName().' nampidirinao !');

                return $this->redirectToRoute('list_employee');
            }
            $this->addFlash(MessageConstant::ERROR_TYPE, 'Misy olana ity application ity, manasa anao hamerina indray !');

            return $this->redirectToRoute('employee_manage', ['id' => $employee->getId()]);
        }

        return $this->render(
            'admin/employee/_employee_form.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/remove/employee/{id}", name="remove_employee")
     *
     * @param Employee $employee
     *
     * @return RedirectResponse
     */
    public function removeUser(Employee $employee)
    {
        try {
            $this->entityManager->remove($employee);
            $this->entityManager->flush();
            $this->addFlash(MessageConstant::SUCCESS_TYPE, 'Voaray ny fanovàna');

            return $this->redirectToRoute('list_employee');
        } catch (\Exception $exception) {
            $this->addFlash(MessageConstant::ERROR_TYPE, 'Misy olana ny fokontaniko');

            return $this->redirectToRoute('list_employee');
        }
    }

    /**
     * @Route("/die/employee/{id}", name="die_employee")
     *
     * @param Employee $employee
     *
     * @return RedirectResponse
     */
    public function onEmployeeDie(Employee $employee)
    {
        try {
            $employee->setIsAlive(false);
            $this->entityManager->flush();
            $this->addFlash(MessageConstant::SUCCESS_TYPE, 'Voaray ny fanovàna');

            return $this->redirectToRoute('list_employee');
        } catch (\Exception $exception) {
            $this->addFlash(MessageConstant::ERROR_TYPE, 'Misy olana ny fokontaniko');

            return $this->redirectToRoute('list_employee');
        }
    }

    /**
     * @Route("/qr-code/{id}", name="generate_qr_employee", methods={"POST","GET"})
     *
     * @param Employee               $employee
     * @param QrCodeFactoryInterface $qrCodeFactory
     *
     * @return Response
     */
    public function generateQr(Employee $employee, QrCodeFactoryInterface $qrCodeFactory)
    {
        $data = $this->renderView('admin/employee/_employe_qr.html.twig', ['employe' => $employee]);
        $qrCode = $qrCodeFactory->create($data);

        return new QrCodeResponse($qrCode);
    }
}
