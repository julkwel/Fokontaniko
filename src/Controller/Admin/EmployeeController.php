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
     * @param Request     $request
     * @param string|null $id
     *
     * @return Response the list of employee by fokontany
     *
     * @Route("/list", name="list_employee", methods={"POST","GET"})
     */
    public function listEmployee(Request $request, ?string $id)
    {
        /** @var Employee $employe */
        $employe = $this->repository->findOneBy(['user' => $this->getUser()]);

        /** @var Fokontany|null $fokontany */
        $fokontany = $this->entityManager->getRepository(Fokontany::class)->find($employe->getFokontany());

        $pagination = $this->paginator->paginate(
            $this->repository->findAllEmployee($fokontany),
            $request->query->getInt('page', PageConstant::DEFAULT_PAGE),
            PageConstant::DEFAULT_NUMBER_PER_PAGE
        );

        return $this->render('admin/employee/_employee_list.html.twig', ['employes' => $pagination]);
    }

    /**
     * @Route("/manage/{id?}", name="employee_manage", methods={"POST","GET"})
     *
     * @param Request     $request
     * @param string|null $id
     *
     * @return Response
     */
    public function manageEmployee(Request $request, ?string $id = null)
    {
        $employee = $this->repository->find($this->decryptThisId($id)) ?? new Employee();
        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $employee->getUser();

            if (!empty($form->get('user')->get('password')->getData())) {
                $user->setPassword($form->get('user')->get('password')->getData());
                $user->setPassword($this->userPassEncoder->encodePassword($user, $user->getPassword()));
            }

            $employee->setFokontany($this->getUser()->getFokontany());

            if ($this->save($employee)) {
                $this->addFlash(MessageConstant::SUCCESS_TYPE, 'Tafiditra i'.$employee->getUser()->getFirstName().' nampidirinao !');

                return $this->redirectToRoute('list_employee');
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
