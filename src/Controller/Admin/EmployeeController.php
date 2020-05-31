<?php
/**
 * @author <Bocasay>.
 */

namespace App\Controller\Admin;

use App\Constant\MessageConstant;
use App\Constant\PageConstant;
use App\Controller\AbstractBaseController;
use App\Entity\Employee;
use App\Entity\Fokontany;
use App\Form\EmployeeType;
use App\Repository\EmployeeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Nzo\UrlEncryptorBundle\Annotations\ParamDecryptor;
use Nzo\UrlEncryptorBundle\UrlEncryptor\UrlEncryptor;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/employee")
 *
 * Class EmployeeController.
 */
class EmployeeController extends AbstractBaseController
{
    /** @var EmployeeRepository */
    private $repository;

    /**
     * EmployeeController constructor.
     *
     * @param EntityManagerInterface       $entityManager
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     * @param UrlEncryptor                 $urlEncrypt
     * @param PaginatorInterface           $paginator
     * @param EmployeeRepository           $employeeRepository
     */
    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder, UrlEncryptor $urlEncrypt, PaginatorInterface $paginator, EmployeeRepository $employeeRepository)
    {
        parent::__construct($entityManager, $userPasswordEncoder, $urlEncrypt, $paginator);
        $this->repository = $employeeRepository;
    }

    /**
     * @param Request $request
     *
     * @return Response the list of employee by fokontany
     *
     * @Route("/list", name="list_employee", methods={"POST","GET"})
     */
    public function listEmployee(Request $request)
    {
        $pagination = $this->paginator->paginate(
            $this->repository->findAllEmployee(),
            $request->query->getInt('page', PageConstant::DEFAULT_PAGE),
            PageConstant::DEFAULT_NUMBER_PER_PAGE
        );

        return $this->render('admin/employee/_employee_list.html.twig', ['employes' => $pagination]);
    }

    /**
     * @Route("/manage/{id?}", name="employee_manage", methods={"POST","GET"})
     *
     * @ParamDecryptor(params="id")
     *
     * @param Request  $request
     * @param Employee $employee
     *
     * @return Response
     */
    public function manageEmployee(Request $request, Employee $employee = null)
    {
        $employee = $employee ?? new Employee();
        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $employee->setFokontany($this->getUser()->getFokontany());

            if ($this->save($employee)) {
                $this->addFlash(MessageConstant::SUCCESS_TYPE, 'Tafiditra i'.$employee->getUser()->getFirstName().' nampidirinao !');
            }
        }

        return $this->render(
            'admin/employee/_employee_form.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
